<x-app-layout>
    @section('title', 'Tugas dan Fungsi PPID')
    
    <div class="bg-institutional-900 pt-20 pb-16 border-b border-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-sm bg-primary-900/50 border border-primary-800 text-primary-200 text-sm font-medium mb-6">
                Tentang PPID
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                Tugas dan Fungsi
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                Peran dan tanggung jawab dalam pengelolaan informasi publik.
            </p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Tugas -->
            <div class="bg-white border border-institutional-200 p-8 rounded-sm shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary-50 rounded-sm flex items-center justify-center text-primary-700 mb-6 border border-primary-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h2 class="text-2xl font-display font-bold text-institutional-900 mb-4">Tugas PPID</h2>
                <div class="prose prose-lg max-w-none text-institutional-600 prose-headings:text-institutional-900 prose-headings:font-display prose-p:text-institutional-600 prose-p:font-light leading-relaxed">
                    {!! settings('profile_tasks', '<p>Dalam rangka memberikan pelayanan informasi yang paripurna...</p>') !!}
                </div>
            </div>

            <!-- Fungsi -->
            <div class="bg-institutional-50 border border-institutional-200 p-8 rounded-sm shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-institutional-200 rounded-sm flex items-center justify-center text-institutional-700 mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h2 class="text-2xl font-display font-bold text-institutional-900 mb-4">Fungsi PPID</h2>
                <div class="prose prose-lg max-w-none text-institutional-600 prose-headings:text-institutional-900 prose-headings:font-display prose-p:text-institutional-600 prose-p:font-light leading-relaxed">
                    {!! settings('profile_functions', '<p>Untuk menyelenggarakan tugas-tugas di atas dengan optimal...</p>') !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
