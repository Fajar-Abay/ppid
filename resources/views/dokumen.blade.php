<x-app-layout>
    @section('title', 'Pusat Dokumen')
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <!-- Page Title & Header -->
        <div class="mb-12 border-b border-institutional-200 pb-8">
            <h1 class="text-3xl md:text-5xl font-display font-bold text-institutional-900 tracking-tight leading-tight">
                Pusat Dokumen Publik
            </h1>
            <p class="text-institutional-500 mt-2 text-sm md:text-base">Temukan dan unduh dokumen resmi, regulasi, surat keputusan, serta laporan berkala pemerintah secara transparan.</p>
        </div>

        <!-- Advanced Search and Filter Bar -->
        <div class="bg-white border border-institutional-200 p-6 rounded-sm shadow-sm mb-8">
            <form action="{{ route('public.dokumen') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Keyword Input -->
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari judul dokumen, deskripsi, atau nomor regulasi..." 
                        class="w-full pl-10 pr-4 py-2.5 border border-institutional-200 rounded-sm text-institutional-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm placeholder-institutional-400 transition-all"
                    >
                    <div class="absolute left-3 top-3 text-institutional-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Category Selector -->
                <div class="w-full md:w-64">
                    <select 
                        name="category" 
                        class="w-full px-3 py-2.5 border border-institutional-200 rounded-sm text-institutional-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm transition-all"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2.5 bg-institutional-900 text-white font-medium text-sm rounded-sm hover:bg-primary-600 transition-colors flex items-center justify-center gap-2 w-full md:w-auto">
                        Cari
                    </button>
                    @if(request()->filled('search') || request()->filled('category'))
                        <a href="{{ route('public.dokumen') }}" class="px-4 py-2.5 bg-institutional-100 text-institutional-700 font-medium text-sm rounded-sm hover:bg-institutional-200 transition-colors flex items-center justify-center w-full md:w-auto">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Documents List -->
        <div class="space-y-4">
            @forelse($documents as $doc)
                <div class="bg-white border border-institutional-200 p-6 rounded-sm shadow-sm flex flex-col md:flex-row gap-6 md:items-center justify-between hover:shadow-md transition-shadow">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-2.5 py-1 bg-primary-50 text-primary-700 text-xs font-medium rounded-sm border border-primary-100">
                                {{ $doc->category?->name ?? 'Dokumen Umum' }}
                            </span>
                            <span class="text-sm text-institutional-500">
                                {{ $doc->published_at ? $doc->published_at->format('d M Y') : $doc->created_at->format('d M Y') }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold font-display text-institutional-900 mb-2">
                            {{ $doc->title }}
                        </h3>
                        <p class="text-institutional-600 font-light text-sm line-clamp-2">
                            {{ $doc->description }}
                        </p>
                    </div>
                    
                    <div class="shrink-0 flex items-center gap-4">
                        <!-- Accurate Live Download Counter -->
                        <div class="text-center md:text-right hidden sm:block text-institutional-500 text-sm">
                            <span class="block font-bold text-institutional-900">{{ $doc->download_count }}</span>
                            Unduhan
                        </div>
                        
                        @if($doc->hasMedia('documents'))
                            <!-- Secure Route handling download and incrementing hits -->
                            <a href="{{ route('public.dokumen.download', $doc) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-institutional-900 text-white font-medium rounded-sm hover:bg-primary-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Unduh Dokumen
                            </a>
                        @else
                            <button disabled class="inline-flex items-center gap-2 px-5 py-2.5 bg-institutional-200 text-institutional-500 font-medium rounded-sm cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Tidak Ada File
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty Search State -->
                <div class="text-center py-16 bg-institutional-50 rounded-sm border border-dashed border-institutional-200">
                    <svg class="w-12 h-12 text-institutional-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-institutional-600 font-medium mb-1">Dokumen tidak ditemukan.</p>
                    <p class="text-institutional-400 text-sm">Tidak ada dokumen publik yang sesuai dengan kata kunci atau filter pencarian Anda.</p>
                </div>
            @endforelse
            
            <!-- Pagination links maintaining query search params -->
            <div class="mt-8">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
