<x-app-layout>
    @section('title', 'Profil PPID')
    
    <div class="bg-institutional-900 pt-20 pb-16 border-b border-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-sm bg-primary-900/50 border border-primary-800 text-primary-200 text-sm font-medium mb-6">
                Tentang PPID
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                Profil Pejabat Pengelola Informasi dan Dokumentasi (PPID)
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                Mengenal lebih dekat komitmen kami dalam penyelenggaraan keterbukaan informasi publik yang transparan dan akuntabel.
            </p>
        </div>
    </div>

    @php
        $headName = settings('profile_head_name', 'Dr. Budi Santoso, M.Si.');
        $headTitle = settings('profile_head_title', 'Atasan PPID / Kepala Instansi');
        $headMessage = settings('profile_head_message', '"Keterbukaan informasi adalah kunci dari kepercayaan publik. Kami berkomitmen untuk terus memberikan akses informasi yang cepat, tepat, dan akurat demi mewujudkan tata kelola pemerintahan yang bersih dan melayani."');
        
        $headImageSetting = \App\Models\Setting::where('key', 'profile_head_image')->first();
        $headImage = $headImageSetting && $headImageSetting->value 
            ? Storage::url($headImageSetting->value) 
            : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=800&auto=format&fit=crop';
            
        $structureSetting = \App\Models\Setting::where('key', 'profile_structure_image')->first();
        $structureImage = $structureSetting && $structureSetting->value
            ? Storage::url($structureSetting->value)
            : null;
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Left Content: Sejarah, Maklumat, Struktur -->
            <div class="lg:col-span-8 space-y-12">
                
                <!-- Sejarah / Narrative -->
                <div class="prose prose-lg max-w-none text-institutional-600 prose-headings:text-institutional-900 prose-headings:font-display prose-p:text-institutional-600 prose-p:font-light leading-relaxed">
                    {!! settings('profile_history', '<p>Sejalan dengan amanat Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik (UU KIP), setiap Badan Publik diwajibkan untuk menyediakan layanan informasi publik yang terbuka, transparan, dan dapat dipertanggungjawabkan. Menyadari pentingnya hal tersebut, <strong>'.settings('site_name').'</strong> secara resmi telah membentuk struktur Pejabat Pengelola Informasi dan Dokumentasi (PPID).</p><p>Pembentukan PPID di lingkungan institusi kami bukan semata-mata untuk menggugurkan kewajiban hukum, melainkan sebagai bentuk manifestasi komitmen nyata dari pimpinan dalam mewujudkan tata kelola pemerintahan yang baik <em>(Good Public Governance)</em>.</p>') !!}
                </div>

                <!-- Maklumat Pelayanan (Service Promise) -->
                <div class="bg-primary-900 rounded-sm p-8 md:p-10 relative overflow-hidden shadow-xl">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
                    <div class="relative z-10 flex flex-col md:flex-row gap-6 items-center md:items-start text-center md:text-left">
                        <div class="w-16 h-16 shrink-0 bg-accent rounded-sm flex items-center justify-center text-white shadow-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-display font-bold text-white mb-3">Maklumat Pelayanan PPID</h3>
                            <p class="text-primary-100 font-light leading-relaxed">
                                "Kami berjanji dan sanggup menyelenggarakan pelayanan informasi publik sesuai dengan Standar Pelayanan yang telah ditetapkan, memberikan pelayanan yang Cepat, Tepat, dan Sederhana serta bersedia menerima sanksi apabila pelayanan yang diberikan tidak sesuai dengan standar."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Struktur Organisasi -->
                <div class="mt-12">
                    <h3 class="text-2xl font-display font-bold text-institutional-900 mb-6 border-b border-institutional-200 pb-4">Struktur Organisasi PPID</h3>
                    @if($structureImage)
                        <div class="bg-white p-4 border border-institutional-200 shadow-sm rounded-sm">
                            <img src="{{ $structureImage }}" alt="Struktur Organisasi PPID" class="w-full h-auto">
                        </div>
                    @else
                        <div class="bg-institutional-50 border-2 border-dashed border-institutional-300 p-12 text-center rounded-sm">
                            <svg class="w-12 h-12 text-institutional-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <h4 class="text-institutional-700 font-medium mb-2">Bagan Struktur Organisasi Belum Tersedia</h4>
                            <p class="text-institutional-500 text-sm">Anda dapat mengunggah gambar struktur organisasi PPID melalui menu Pengaturan Situs (Buat Key baru: <code>profile_structure_image</code> dengan tipe Image).</p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Sidebar: Head's Message -->
            <div class="lg:col-span-4">
                <div class="sticky top-24">
                    <div class="bg-white border border-institutional-200 rounded-sm shadow-xl overflow-hidden">
                        <!-- Head Image -->
                        <div class="h-80 w-full relative">
                            <img src="{{ $headImage }}" alt="{{ $headName }}" class="w-full h-full object-cover object-top">
                            <div class="absolute inset-0 bg-gradient-to-t from-institutional-900/90 via-institutional-900/20 to-transparent"></div>
                            
                            <div class="absolute bottom-0 left-0 w-full p-6 text-white">
                                <div class="text-xs font-bold tracking-widest text-accent uppercase mb-1">{{ $headTitle }}</div>
                                <h3 class="text-2xl font-display font-bold leading-tight">{{ $headName }}</h3>
                            </div>
                        </div>
                        
                        <!-- Head Message -->
                        <div class="p-6 md:p-8 bg-white relative">
                            <svg class="absolute top-4 left-4 w-12 h-12 text-institutional-100 -z-0" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                            <div class="relative z-10 prose prose-institutional text-institutional-600 font-light italic leading-relaxed text-lg">
                                {!! $headMessage !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
