<x-app-layout>
    @section('title', 'Visi dan Misi PPID')
    
    <div class="bg-institutional-900 pt-20 pb-16 border-b border-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-sm bg-primary-900/50 border border-primary-800 text-primary-200 text-sm font-medium mb-6">
                Tentang PPID
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                Visi dan Misi
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                Arah dan cita-cita dalam memberikan layanan informasi publik yang prima dan berkualitas bagi seluruh masyarakat.
            </p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="space-y-12">
            <!-- Visi -->
            <div class="text-center max-w-4xl mx-auto py-8">
                <span class="text-primary-600 font-bold tracking-widest uppercase text-sm mb-6 block">Visi PPID</span>
                <div class="prose prose-xl mx-auto text-institutional-900 font-display">
                    {!! settings('profile_vision', '"Terwujudnya pelayanan informasi publik yang transparan, efektif, efisien, dan akuntabel demi mendorong terciptanya tata kelola pemerintahan yang baik dan bersih."') !!}
                </div>
            </div>

            <div class="w-24 h-1 bg-institutional-200 mx-auto"></div>

            <!-- Misi -->
            <div class="bg-white border border-institutional-200 p-8 md:p-12 rounded-sm shadow-sm mt-8">
                <div class="text-center mb-12">
                    <span class="text-primary-600 font-bold tracking-widest uppercase text-sm mb-4 block">Misi Kami</span>
                    <h3 class="text-2xl md:text-3xl font-display font-bold text-institutional-900">Langkah Nyata Mencapai Visi</h3>
                    <p class="mt-4 text-institutional-600 font-light max-w-2xl mx-auto text-lg">
                        Dalam rangka mencapai visi keterbukaan informasi yang ideal, Pejabat Pengelola Informasi dan Dokumentasi (PPID) menetapkan misi-misi strategis sebagai berikut:
                    </p>
                </div>
                
                <div class="prose prose-lg max-w-none text-institutional-600 prose-headings:text-institutional-900 prose-headings:font-display prose-p:text-institutional-600 prose-p:font-light leading-relaxed">
                    {!! settings('profile_mission', '<p>Meningkatkan pengelolaan dan pelayanan informasi yang berkualitas.</p>') !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
