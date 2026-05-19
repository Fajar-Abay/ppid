<?php

use App\Livewire\PublicComplaintForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pengaduan', function () {
    return view('pengaduan');
})->name('public.complaint');

Route::get('/dokumen', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Document::with('category')->published();

    // Filter pencarian berdasarkan kata kunci pada judul, deskripsi, atau kata kunci meta
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('meta_keywords', 'like', "%{$search}%");
        });
    }

    // Filter berdasarkan kategori dokumen
    if ($request->filled('category')) {
        $query->where('category_id', $request->input('category'));
    }

    $documents = $query->orderBy('published_at', 'desc')->paginate(10)->withQueryString();
    
    // Ambil hanya kategori aktif yang diperuntukkan bagi dokumen (bukan berita)
    $categories = \App\Models\Category::where('type', '!=', \App\Enums\DocumentCategoryType::Berita)
        ->where('is_active', true)
        ->orderBy('sort_order', 'asc')
        ->get();

    return view('dokumen', compact('documents', 'categories'));
})->name('public.dokumen');

Route::get('/dokumen/download/{document}', function (\App\Models\Document $document) {
    if ($document->hasMedia('documents')) {
        // Tambahkan jumlah hit unduhan secara akurat dan aman
        $document->increment('download_count');
        
        $media = $document->getFirstMedia('documents');
        return response()->download($media->getPath(), $media->file_name);
    }
    
    abort(404, 'File dokumen tidak ditemukan di penyimpanan server.');
})->name('public.dokumen.download');

Route::get('/lacak', function () {
    return view('pages.lacak');
})->name('public.lacak');

// Static Pages
Route::view('/profil', 'pages.profil')->name('pages.profil');

Route::get('/berita', function () {
    $posts = \App\Models\Post::where('is_published', true)->orderBy('published_at', 'desc')->paginate(10);
    return view('pages.berita', compact('posts'));
})->name('pages.berita');

Route::get('/berita/{slug}', function ($slug) {
    $post = \App\Models\Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
    return view('pages.berita-detail', compact('post'));
})->name('pages.berita-detail');

Route::view('/standar-layanan', 'pages.standar-layanan')->name('pages.standar-layanan');
Route::view('/regulasi', 'pages.regulasi')->name('pages.regulasi');

Route::prefix('ppid')->name('pages.ppid.')->group(function () {
    Route::view('/profil', 'pages.ppid.profil')->name('profil');
    Route::view('/tugas-dan-fungsi', 'pages.ppid.tugas-fungsi')->name('tugas-fungsi');
    Route::view('/visi-dan-misi', 'pages.ppid.visi-misi')->name('visi-misi');
});

Route::view('/pedoman', 'pages.pedoman')->name('pages.pedoman');
Route::view('/agenda', 'pages.agenda')->name('pages.agenda');
Route::view('/pengumuman', 'pages.pengumuman')->name('pages.pengumuman');
Route::view('/f-a-q', 'pages.f-a-q')->name('pages.faq');
Route::view('/hubungi', 'pages.hubungi')->name('pages.hubungi');
Route::post('/hubungi', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'message' => 'required|string|max:2000',
    ]);

    \App\Models\ContactMessage::create($validated);

    return back()->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menindaklanjutinya.');
})->name('pages.hubungi.store');

// Rute sementara untuk melihat desain (Preview) Email di browser
Route::get('/preview-email', function () {
    $complaint = \App\Models\Complaint::first();
    if (!$complaint) {
        return "Buat pengaduan terlebih dahulu untuk melihat preview.";
    }
    return new \App\Mail\ComplaintResponseMail($complaint);
});
