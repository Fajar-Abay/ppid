<x-app-layout>
    @section('title', 'Berita')
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="mb-12 border-b border-institutional-200 pb-8">
            <h1 class="text-3xl md:text-5xl font-display font-bold text-institutional-900 tracking-tight leading-tight">
                Berita & Publikasi
            </h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <div class="bg-white border border-institutional-200 rounded-sm overflow-hidden flex flex-col hover:shadow-lg transition-shadow">
                    @if($post->hasMedia('posts'))
                        <img src="{{ $post->getFirstMediaUrl('posts') }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-institutional-100 flex items-center justify-center">
                            <svg class="w-12 h-12 text-institutional-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20a2 2 0 012 2v1m-2 13v-1M12 21v-1M5 21v-1"/></svg>
                        </div>
                    @endif
                    <div class="p-6 flex flex-col flex-1">
                        <span class="text-xs font-semibold text-primary-600 mb-2">{{ $post->published_at->translatedFormat('d F Y') }}</span>
                        <h3 class="font-display font-bold text-xl text-institutional-900 mb-3 leading-snug hover:text-primary-600 transition-colors">
                            <a href="{{ route('pages.berita-detail', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-institutional-600 line-clamp-3 text-sm mb-4 flex-1">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        <a href="{{ route('pages.berita-detail', $post->slug) }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-1 mt-auto">
                            Baca Selengkapnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center border border-dashed border-institutional-300 bg-institutional-50 rounded-sm">
                    <p class="text-institutional-500 font-medium">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
