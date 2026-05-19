<x-app-layout>
    @section('title', $post->title . ' - Berita')
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="mb-8 border-b border-institutional-200 pb-8">
            <div class="flex items-center gap-2 text-sm text-institutional-500 mb-4">
                <a href="{{ route('pages.berita') }}" class="hover:text-primary-600 transition-colors">Berita</a>
                <span>&bull;</span>
                <span>{{ $post->published_at->translatedFormat('d F Y') }}</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-institutional-900 tracking-tight leading-tight mb-6">
                {{ $post->title }}
            </h1>
            
            @if($post->hasMedia('posts'))
                <div class="w-full h-[400px] md:h-[500px] mt-8 rounded-sm overflow-hidden">
                    <img src="{{ $post->getFirstMediaUrl('posts') }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif
        </div>
        
        <div class="prose prose-lg prose-institutional max-w-none">
            {!! $post->content !!}
        </div>
        
        <div class="mt-12 pt-8 border-t border-institutional-200">
            <a href="{{ route('pages.berita') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-institutional-600 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</x-app-layout>
