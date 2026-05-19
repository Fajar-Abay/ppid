<x-app-layout>
    @php
        $headerImage = settings('profile_header_image');
        $headerImageUrl = empty($headerImage) 
            ? 'https://images.unsplash.com/photo-1541888079633-5c26b911762c?q=80&w=2000&auto=format&fit=crop' 
            : (\Illuminate\Support\Str::startsWith($headerImage, ['http://', 'https://']) ? $headerImage : \Illuminate\Support\Facades\Storage::disk('public')->url($headerImage));

        $headImage = settings('profile_head_image');
        $headImageUrl = empty($headImage) 
            ? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=800&auto=format&fit=crop' 
            : (\Illuminate\Support\Str::startsWith($headImage, ['http://', 'https://']) ? $headImage : \Illuminate\Support\Facades\Storage::disk('public')->url($headImage));
    @endphp

    <!-- Page Header -->
    <div class="relative bg-institutional-900 pt-24 pb-32 overflow-hidden border-b border-primary-900">
        <div class="absolute inset-0 z-0">
            <img src="{{ $headerImageUrl }}" alt="Gedung Instansi" class="w-full h-full object-cover opacity-40 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-b from-institutional-900/80 via-institutional-900/90 to-institutional-900"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-in fade-in slide-in-from-bottom-4 duration-700">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                {{ settings('profile_title', 'Profil Instansi') }}
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                {{ settings('profile_subtitle', 'Mengenal lebih dekat peran, fungsi, serta komitmen kami dalam melayani masyarakat.') }}
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 z-20 pb-24">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            
            <!-- Left Sidebar / Navigation (Optional for long profiles) -->
            <div class="hidden lg:block lg:col-span-3">
                <div class="sticky top-28 bg-white border border-institutional-200 rounded-sm p-6 shadow-sm">
                    <h3 class="font-display text-sm font-bold text-institutional-900 uppercase tracking-widest mb-4">Daftar Isi</h3>
                    <nav class="space-y-3">
                        <a href="#sejarah" class="block text-sm text-institutional-600 font-medium hover:text-primary-700 transition-colors">Sejarah Singkat</a>
                        <a href="#visi-misi" class="block text-sm text-institutional-600 hover:text-primary-700 transition-colors">Visi & Misi</a>
                    </nav>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="lg:col-span-9 space-y-16">
                
                <!-- Section: Sejarah -->
                <section id="sejarah" class="bg-white border border-institutional-200 rounded-sm p-8 md:p-12 shadow-sm">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-primary-50 rounded-sm flex items-center justify-center text-primary-700 border border-primary-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h2 class="font-display text-2xl md:text-3xl font-bold text-institutional-900 tracking-tight">Sejarah Singkat</h2>
                    </div>
                    
                    <div class="prose prose-lg max-w-none text-institutional-600 font-light leading-relaxed prose-p:text-institutional-600 prose-headings:text-institutional-900">
                        {!! settings('profile_history', '
                        <p>PPID (Pejabat Pengelola Informasi dan Dokumentasi) dibentuk sebagai perpanjangan tangan institusi dalam mewujudkan keterbukaan informasi publik sebagaimana diamanatkan oleh Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik (KIP).</p>
                        <p>Sejak pendiriannya, kami berkomitmen untuk menyediakan layanan informasi yang transparan, akuntabel, dan mudah diakses oleh seluruh lapisan masyarakat. Kami terus berinovasi dalam mengelola dokumentasi publik untuk memastikan hak masyarakat atas informasi terpenuhi dengan standar pelayanan terbaik.</p>
                        ') !!}
                    </div>
                </section>

                <!-- Section: Visi Misi -->
                <section id="visi-misi" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Visi -->
                    <div class="bg-institutional-900 border border-institutional-800 rounded-sm p-8 md:p-10 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <h2 class="font-display text-2xl font-bold text-white tracking-tight mb-6 relative z-10">Visi</h2>
                        <div class="text-institutional-300 font-light leading-relaxed relative z-10 text-lg">
                            {!! settings('profile_vision', 'Terwujudnya pelayanan informasi publik yang transparan, efektif, dan efisien untuk mendukung tata kelola pemerintahan yang baik <em>(Good Corporate Governance)</em>.') !!}
                        </div>
                    </div>

                    <!-- Misi -->
                    <div class="bg-white border border-institutional-200 rounded-sm p-8 md:p-10 shadow-sm">
                        <h2 class="font-display text-2xl font-bold text-institutional-900 tracking-tight mb-6">Misi</h2>
                        <div class="prose max-w-none text-institutional-600 font-light prose-li:text-institutional-600 prose-ul:space-y-2">
                            {!! settings('profile_mission', '
                            <ul>
                                <li>Meningkatkan kualitas pengelolaan dan pelayanan informasi publik.</li>
                                <li>Membangun dan mengembangkan sistem penyediaan informasi berbasis teknologi.</li>
                                <li>Meningkatkan kompetensi sumber daya manusia dalam bidang pelayanan informasi.</li>
                                <li>Menjamin aksesibilitas informasi bagi seluruh masyarakat.</li>
                            </ul>
                            ') !!}
                        </div>
                    </div>
                </section>

                <!-- Section: Pimpinan / Struktur -->
                <section id="struktur" class="bg-white border border-institutional-200 rounded-sm overflow-hidden shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-5">
                        <div class="md:col-span-2 bg-institutional-100 relative">
                            <!-- Image -->
                            <img src="{{ $headImageUrl }}" alt="Kepala Instansi" class="absolute inset-0 w-full h-full object-cover">
                        </div>
                        <div class="md:col-span-3 p-8 md:p-12 flex flex-col justify-center min-h-[400px]">
                            <div class="inline-block px-3 py-1 bg-primary-50 text-primary-700 text-xs font-bold uppercase tracking-widest rounded-sm mb-4 border border-primary-100 w-max">
                                {{ settings('profile_head_title', 'Kepala Instansi') }}
                            </div>
                            <h2 class="font-display text-3xl font-bold text-institutional-900 tracking-tight mb-4">
                                {{ settings('profile_head_name', 'Dr. Budi Santoso, M.Si.') }}
                            </h2>
                            <div class="text-institutional-600 font-light leading-relaxed mb-8 italic">
                                {!! settings('profile_head_message', '
                                "Keterbukaan informasi adalah kunci dari kepercayaan publik. Kami berkomitmen untuk terus memberikan akses informasi yang cepat, tepat, dan akurat demi mewujudkan tata kelola pemerintahan yang bersih dan melayani."
                                ') !!}
                            </div>
                            <div class="mt-auto pt-6 border-t border-institutional-200">
                                <a href="{{ route('public.dokumen') }}" class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors">
                                    Lihat Standar Operasional Prosedur 
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>
