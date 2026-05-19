<x-app-layout>
    @section('title', 'Papan Pengumuman')
    
    <div class="bg-institutional-900 pt-20 pb-16 border-b border-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-sm bg-primary-900/50 border border-primary-800 text-primary-200 text-sm font-medium mb-6">
                Informasi Berkala
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                Papan Pengumuman
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                Kumpulan rilis informasi, kebijakan terbaru, dan surat edaran resmi dari instansi.
            </p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        @php
            $announcements = \App\Models\Announcement::where('is_active', true)->orderBy('created_at', 'desc')->paginate(10);
        @endphp

        <div class="bg-white border border-institutional-200 rounded-sm shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-institutional-200 bg-institutional-50 flex justify-between items-center">
                <h2 class="text-xl font-display font-bold text-institutional-900">Daftar Pengumuman</h2>
                <span class="text-sm text-institutional-500">Menampilkan {{ $announcements->count() }} dari {{ $announcements->total() }}</span>
            </div>
            
            <div class="divide-y divide-institutional-100">
                @forelse($announcements as $announcement)
                <div class="p-8 hover:bg-institutional-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="mt-1 bg-accent/10 text-accent p-2 rounded-sm shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-institutional-900">{{ $announcement->title }}</h3>
                                <span class="px-2 py-1 bg-institutional-100 text-institutional-500 text-xs font-semibold rounded-sm">
                                    {{ \Carbon\Carbon::parse($announcement->created_at)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            <div class="text-institutional-600 font-light mb-4 prose prose-sm max-w-none">
                                {!! $announcement->content !!}
                            </div>
                            @if($announcement->file_attachment)
                            <a href="{{ Storage::url($announcement->file_attachment) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-medium text-accent hover:text-accent-dark transition-colors border border-accent/30 px-4 py-2 rounded-sm bg-white hover:bg-accent/5">
                                Unduh Lampiran Dokumen <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-institutional-50 text-institutional-300 rounded-full flex items-center justify-center mx-auto mb-6 border border-institutional-100">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-institutional-900 mb-2">Belum Ada Pengumuman</h3>
                    <p class="text-institutional-500 font-light max-w-md mx-auto">
                        Saat ini belum ada dokumen pengumuman atau surat edaran publik yang diterbitkan. Silakan periksa halaman ini secara berkala.
                    </p>
                </div>
                @endforelse
            </div>
            
            @if($announcements->hasPages())
            <div class="p-6 border-t border-institutional-200 bg-institutional-50">
                {{ $announcements->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
