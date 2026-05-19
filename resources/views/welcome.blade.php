<x-app-layout>
    @php
        $heroBanner = \App\Models\Banner::where('is_active', true)
            ->where('display_location', 'homepage')
            ->orderBy('sort_order', 'asc')
            ->first();
            
        $bgImage = $heroBanner && $heroBanner->hasMedia('banner_image') 
            ? $heroBanner->getFirstMediaUrl('banner_image') 
            : 'https://images.unsplash.com/photo-1541888079633-5c26b911762c?q=80&w=2000&auto=format&fit=crop';
    @endphp

    <!-- Premium Hero Section -->
    <section class="relative min-h-[90vh] flex items-center overflow-hidden bg-institutional-900">
        <!-- Abstract Background Elements -->
        <div class="absolute inset-0 z-0">
            <!-- Background Image with Overlay -->
            <img src="{{ $bgImage }}" alt="Hero Background" class="w-full h-full object-cover opacity-25 mix-blend-luminosity">
            <div class="absolute inset-0 bg-gradient-to-r from-institutional-900 via-institutional-900/95 to-institutional-900/40"></div>
            
            <!-- Glowing Accents -->
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-primary-900/40 rounded-full blur-[120px] translate-x-1/3 -translate-y-1/4"></div>
            <div class="absolute bottom-0 left-1/4 w-[600px] h-[600px] bg-accent-dark/30 rounded-full blur-[100px] translate-y-1/3"></div>
            
            <!-- Tech Pattern Overlay -->
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <!-- Left Content -->
                <div class="lg:col-span-7 space-y-10 animate-in slide-in-from-bottom-8 duration-1000 ease-out fill-mode-both">
                    
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm shadow-xl">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-accent"></span>
                        </span>
                        <span class="font-display text-sm font-semibold tracking-widest text-primary-100 uppercase">Portal Informasi Resmi</span>
                    </div>
                    
                    <!-- Headline -->
                    @if($heroBanner && $heroBanner->title)
                        <h1 class="font-display text-5xl lg:text-7xl font-bold tracking-tight text-white leading-[1.1]">
                            {!! nl2br(e($heroBanner->title)) !!}
                        </h1>
                    @else
                        <h1 class="font-display text-5xl lg:text-7xl font-bold tracking-tight text-white leading-[1.1]">
                            Keterbukaan <br />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-200 via-white to-primary-100">Informasi Publik</span>
                        </h1>
                    @endif
                    
                    <!-- Description -->
                    <p class="text-lg lg:text-xl text-institutional-300 leading-relaxed max-w-2xl font-light">
                        {{ $heroBanner && $heroBanner->subtitle ? $heroBanner->subtitle : 'Mewujudkan tata kelola pemerintahan yang bersih, efektif, transparan, dan akuntabel melalui pelayanan informasi publik yang prima dan terintegrasi.' }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-5 pt-4">
                        @if($heroBanner && $heroBanner->link_url && $heroBanner->button_text)
                        <a href="{{ $heroBanner->link_url }}" class="group relative inline-flex justify-center items-center px-8 py-4 bg-primary-600 text-white font-semibold rounded-sm overflow-hidden shadow-[0_0_40px_-10px_rgba(53,88,149,0.5)] hover:shadow-[0_0_60px_-15px_rgba(53,88,149,0.7)] transition-all duration-300">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-primary-500 to-primary-700"></span>
                            <span class="absolute bottom-0 right-0 block w-64 h-64 mb-32 mr-4 transition duration-500 origin-bottom-left transform rotate-45 translate-x-24 bg-accent opacity-30 group-hover:rotate-90 ease"></span>
                            <span class="relative flex items-center gap-2 font-display tracking-wide">
                                {{ $heroBanner->button_text }}
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </a>
                        @else
                        <a href="/pengaduan" class="group relative inline-flex justify-center items-center px-8 py-4 bg-primary-600 text-white font-semibold rounded-sm overflow-hidden shadow-[0_0_40px_-10px_rgba(53,88,149,0.5)] hover:shadow-[0_0_60px_-15px_rgba(53,88,149,0.7)] transition-all duration-300">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-primary-500 to-primary-700"></span>
                            <span class="absolute bottom-0 right-0 block w-64 h-64 mb-32 mr-4 transition duration-500 origin-bottom-left transform rotate-45 translate-x-24 bg-accent opacity-30 group-hover:rotate-90 ease"></span>
                            <span class="relative flex items-center gap-2 font-display tracking-wide">
                                Ajukan Permohonan
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </a>
                        
                        <a href="/dokumen" class="group relative inline-flex justify-center items-center px-8 py-4 bg-transparent text-white font-semibold rounded-sm border border-white/20 hover:border-white/40 hover:bg-white/5 backdrop-blur-sm transition-all duration-300">
                            <span class="relative flex items-center gap-2 font-display tracking-wide">
                                Cari Dokumen
                                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Right Abstract UI / Composition -->
                <div class="lg:col-span-5 hidden lg:block animate-in slide-in-from-right-16 duration-1000 delay-300 ease-out fill-mode-both">
                    <div class="relative w-full aspect-square">
                        <!-- Glass Panel 1 -->
                        <div class="absolute top-10 right-0 w-[80%] h-[70%] bg-white/[0.03] border border-white/10 backdrop-blur-md rounded-sm shadow-2xl p-6 flex flex-col justify-between transform translate-x-4 -rotate-3 hover:rotate-0 transition-transform duration-700">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-sm bg-accent/20 flex items-center justify-center border border-accent/30">
                                    <svg class="w-6 h-6 text-accent-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-2 w-24 bg-white/20 rounded-full"></div>
                                    <div class="h-2 w-32 bg-white/10 rounded-full"></div>
                                </div>
                            </div>
                            <div class="h-1 w-full bg-gradient-to-r from-accent to-transparent rounded-full opacity-50"></div>
                        </div>

                        <!-- Glass Panel 2 -->
                        <div class="absolute bottom-10 left-0 w-[75%] h-[65%] bg-primary-900/40 border border-primary-400/20 backdrop-blur-xl rounded-sm shadow-2xl p-6 flex flex-col justify-between z-10 transform -translate-x-4 rotate-2 hover:rotate-0 transition-transform duration-700 delay-100">
                            <div class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-3 h-3 rounded-full bg-success shadow-[0_0_10px_rgba(47,133,90,0.8)]"></div>
                                    <span class="text-xs font-medium text-primary-200 tracking-wider uppercase">Sistem Online</span>
                                </div>
                                <div>
                                    <div class="font-display text-4xl font-bold text-white mb-1">98.5%</div>
                                    <div class="text-sm text-primary-300">Indeks Kepuasan Masyarakat</div>
                                </div>
                            </div>
                            <!-- Mini chart -->
                            <div class="flex items-end gap-2 h-12 opacity-70">
                                <div class="w-1/6 bg-primary-500 rounded-t-sm h-[40%]"></div>
                                <div class="w-1/6 bg-primary-500 rounded-t-sm h-[60%]"></div>
                                <div class="w-1/6 bg-primary-400 rounded-t-sm h-[50%]"></div>
                                <div class="w-1/6 bg-primary-400 rounded-t-sm h-[80%]"></div>
                                <div class="w-1/6 bg-primary-300 rounded-t-sm h-[70%]"></div>
                                <div class="w-1/6 bg-accent-light rounded-t-sm h-[100%] shadow-[0_0_15px_rgba(168,69,101,0.5)]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom gradient fade to white -->
        <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-institutional-50 to-transparent z-20"></div>
    </section>

    <!-- Premium Stats Section -->
    <section class="relative py-12 -mt-16 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-2xl shadow-institutional-200/50 border border-institutional-100 p-8 lg:p-12" data-aos="fade-up">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-8 divide-x-0 md:divide-x divide-institutional-100">
                    
                    <div class="flex flex-col items-center text-center px-4 group">
                        <div class="w-12 h-12 mb-4 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 group-hover:scale-110 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="font-display text-4xl font-bold text-institutional-900 mb-1 tracking-tight group-hover:text-primary-700 transition-colors">500+</div>
                        <div class="text-xs font-semibold text-institutional-500 uppercase tracking-widest">Informasi Publik</div>
                    </div>
                    
                    <div class="flex flex-col items-center text-center px-4 group">
                        <div class="w-12 h-12 mb-4 rounded-full bg-accent/10 flex items-center justify-center text-accent group-hover:scale-110 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <div class="font-display text-4xl font-bold text-institutional-900 mb-1 tracking-tight group-hover:text-accent transition-colors">98%</div>
                        <div class="text-xs font-semibold text-institutional-500 uppercase tracking-widest">Tingkat Respon</div>
                    </div>
                    
                    <div class="flex flex-col items-center text-center px-4 group">
                        <div class="w-12 h-12 mb-4 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 group-hover:scale-110 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="font-display text-4xl font-bold text-institutional-900 mb-1 tracking-tight group-hover:text-primary-700 transition-colors"><10hr</div>
                        <div class="text-xs font-semibold text-institutional-500 uppercase tracking-widest">Waktu Rata-rata</div>
                    </div>
                    
                    <div class="flex flex-col items-center text-center px-4 group">
                        <div class="w-12 h-12 mb-4 rounded-full bg-success/10 flex items-center justify-center text-success group-hover:scale-110 group-hover:bg-success group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="font-display text-4xl font-bold text-institutional-900 mb-1 tracking-tight group-hover:text-success transition-colors">A+</div>
                        <div class="text-xs font-semibold text-institutional-500 uppercase tracking-widest">Indeks Keterbukaan</div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Elegant Services Section -->
    <section class="py-24 bg-institutional-50 relative overflow-hidden">
        <!-- Decor -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-[40rem] h-[40rem] bg-primary-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-[40rem] h-[40rem] bg-accent-light/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16" data-aos="fade-up">
                <div class="max-w-2xl space-y-4">
                    <h2 class="font-display text-sm font-bold tracking-widest text-primary-600 uppercase">Klasifikasi Layanan</h2>
                    <h3 class="font-display text-4xl font-bold text-institutional-900 tracking-tight">Kategori Layanan Informasi</h3>
                    <p class="text-lg text-institutional-600 font-light">Telusuri berbagai klasifikasi informasi dan dokumentasi yang kami sediakan untuk menunjang keterbukaan publik yang terstruktur.</p>
                </div>
                <a href="/dokumen" class="inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-800 transition-colors group pb-2 border-b border-primary-200 hover:border-primary-600">
                    Lihat Semua Dokumen 
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="group relative bg-white p-10 rounded-md border border-institutional-200 shadow-sm hover:shadow-xl hover:border-primary-200 transition-all duration-300 overflow-hidden flex flex-col h-full" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-400 to-primary-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    
                    <div class="w-14 h-14 bg-institutional-50 text-institutional-700 rounded-sm flex items-center justify-center mb-8 group-hover:bg-primary-50 group-hover:text-primary-600 transition-colors border border-institutional-100 group-hover:border-primary-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-institutional-900 mb-4 group-hover:text-primary-700 transition-colors">Informasi Berkala</h3>
                    <p class="text-institutional-600 leading-relaxed mb-8 flex-grow font-light">Informasi yang wajib disediakan dan diumumkan secara rutin oleh Pejabat Pengelola Informasi tanpa perlu adanya permohonan.</p>
                    
                    <a href="/dokumen?type=berkala" class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-institutional-900 group-hover:text-primary-600 transition-colors">
                        Telusuri Kategori
                        <div class="w-8 h-8 rounded-full bg-institutional-50 flex items-center justify-center group-hover:bg-primary-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                </div>

                <!-- Service 2 -->
                <div class="group relative bg-white p-10 rounded-md border border-institutional-200 shadow-sm hover:shadow-xl hover:border-primary-200 transition-all duration-300 overflow-hidden flex flex-col h-full" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-accent-light to-accent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    
                    <div class="w-14 h-14 bg-institutional-50 text-institutional-700 rounded-sm flex items-center justify-center mb-8 group-hover:bg-accent/10 group-hover:text-accent transition-colors border border-institutional-100 group-hover:border-accent/20">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-institutional-900 mb-4 group-hover:text-accent transition-colors">Informasi Serta Merta</h3>
                    <p class="text-institutional-600 leading-relaxed mb-8 flex-grow font-light">Informasi yang dapat mengancam hajat hidup orang banyak dan ketertiban umum apabila tidak segera diumumkan.</p>
                    
                    <a href="/dokumen?type=serta_merta" class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-institutional-900 group-hover:text-accent transition-colors">
                        Telusuri Kategori
                        <div class="w-8 h-8 rounded-full bg-institutional-50 flex items-center justify-center group-hover:bg-accent/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                </div>

                <!-- Service 3 -->
                <div class="group relative bg-white p-10 rounded-md border border-institutional-200 shadow-sm hover:shadow-xl hover:border-primary-200 transition-all duration-300 overflow-hidden flex flex-col h-full" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-400 to-primary-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    
                    <div class="w-14 h-14 bg-institutional-50 text-institutional-700 rounded-sm flex items-center justify-center mb-8 group-hover:bg-primary-50 group-hover:text-primary-600 transition-colors border border-institutional-100 group-hover:border-primary-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-institutional-900 mb-4 group-hover:text-primary-700 transition-colors">Informasi Setiap Saat</h3>
                    <p class="text-institutional-600 leading-relaxed mb-8 flex-grow font-light">Informasi yang harus tersedia setiap saat dan dapat diakses oleh masyarakat umum melalui permohonan informasi.</p>
                    
                    <a href="/dokumen?type=setiap_saat" class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-institutional-900 group-hover:text-primary-600 transition-colors">
                        Telusuri Kategori
                        <div class="w-8 h-8 rounded-full bg-institutional-50 flex items-center justify-center group-hover:bg-primary-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita & Agenda Section -->
    <section class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16" data-aos="fade-up">
                <div class="max-w-2xl space-y-4">
                    <h2 class="font-display text-sm font-bold tracking-widest text-accent uppercase">Kabar Terkini</h2>
                    <h3 class="font-display text-4xl font-bold text-institutional-900 tracking-tight">Berita & Informasi Terbaru</h3>
                    <p class="text-lg text-institutional-600 font-light">Pantau kegiatan, kebijakan, dan berita terbaru seputar pelayanan publik di instansi kami.</p>
                </div>
                <a href="{{ route('pages.berita') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-accent hover:text-accent-dark transition-colors group pb-2 border-b border-accent/30 hover:border-accent">
                    Lihat Semua Berita 
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            @php
                $latestPosts = \App\Models\Post::where('is_published', true)->orderBy('published_at', 'desc')->take(3)->get();
                
                $latestAgendas = \App\Models\Agenda::where('is_active', true)
                                ->where('start_date', '>=', now())
                                ->orderBy('start_date', 'asc')
                                ->take(3)
                                ->get();
                                
                if ($latestAgendas->isEmpty()) {
                    $latestAgendas = \App\Models\Agenda::where('is_active', true)
                                    ->orderBy('start_date', 'desc')
                                    ->take(3)
                                    ->get();
                }
                
                $latestAnnouncements = \App\Models\Announcement::where('is_active', true)
                                        ->orderBy('created_at', 'desc')
                                        ->take(3)
                                        ->get();
            @endphp

            <!-- Responsive Grid (Mobile First) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($latestPosts as $post)
                    <article class="bg-white border border-institutional-200 rounded-sm overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="relative h-56 overflow-hidden bg-institutional-100">
                            @if($post->featured_image)
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-institutional-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-bold text-primary-700 rounded-sm">
                                Berita
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-xs text-institutional-500 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('d F Y') }}
                            </div>
                            <h4 class="font-display text-xl font-bold text-institutional-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                <a href="{{ route('pages.berita-detail', $post->slug) }}" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    {{ $post->title }}
                                </a>
                            </h4>
                            <p class="text-institutional-600 font-light line-clamp-3 text-sm mb-6 flex-grow">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <div class="mt-auto flex items-center text-sm font-semibold text-primary-600">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </article>
                @empty
                    <!-- Empty State Berita -->
                    <div class="col-span-full border border-dashed border-institutional-300 rounded-sm p-12 text-center bg-institutional-50">
                        <svg class="w-12 h-12 text-institutional-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <h4 class="text-lg font-bold text-institutional-900 mb-2">Belum Ada Publikasi</h4>
                        <p class="text-institutional-500 font-light max-w-md mx-auto">Saat ini belum ada berita atau artikel yang dipublikasikan. Silakan cek kembali nanti.</p>
                    </div>
                @endforelse
            </div>

            <!-- Short Info Section for Agenda/Pengumuman (Mobile First Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-16 pt-16 border-t border-institutional-200">
                <!-- Agenda Widget -->
                <div class="bg-institutional-50 border border-institutional-200 p-6 sm:p-8 rounded-sm" data-aos="fade-right" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="font-display text-lg sm:text-xl font-bold text-institutional-900 flex items-center gap-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Agenda Mendatang
                        </h4>
                        <a href="{{ route('pages.agenda') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-800">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($latestAgendas as $agenda)
                        <div class="p-4 bg-white border border-institutional-100 rounded-sm shadow-sm flex items-start gap-4 hover:border-primary-200 transition-colors">
                            <div class="bg-primary-50 text-primary-700 px-3 py-2 rounded-sm text-center shrink-0">
                                <span class="block text-xl font-bold leading-none">{{ \Carbon\Carbon::parse($agenda->start_date)->format('d') }}</span>
                                <span class="block text-xs uppercase tracking-wider mt-1">{{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('M') }}</span>
                            </div>
                            <div>
                                <h5 class="font-bold text-institutional-900 mb-1 text-sm sm:text-base line-clamp-1">{{ $agenda->title }}</h5>
                                <p class="text-xs text-institutional-500">{{ $agenda->location }} | {{ \Carbon\Carbon::parse($agenda->start_date)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-institutional-500 text-sm italic bg-white border border-institutional-100 rounded-sm">
                            Tidak ada agenda dalam waktu dekat.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pengumuman Widget -->
                <div class="bg-institutional-50 border border-institutional-200 p-6 sm:p-8 rounded-sm" data-aos="fade-left" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="font-display text-lg sm:text-xl font-bold text-institutional-900 flex items-center gap-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            Papan Pengumuman
                        </h4>
                        <a href="{{ route('pages.pengumuman') }}" class="text-sm font-semibold text-accent hover:text-accent-dark">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($latestAnnouncements as $announcement)
                        <div class="p-4 bg-white border border-institutional-100 rounded-sm shadow-sm border-l-4 border-l-accent hover:bg-institutional-50 transition-colors">
                            <h5 class="font-bold text-institutional-900 mb-1 text-sm sm:text-base line-clamp-1">{{ $announcement->title }}</h5>
                            <p class="text-xs text-institutional-500 mb-2">Dipublikasikan: {{ \Carbon\Carbon::parse($announcement->created_at)->translatedFormat('d F Y') }}</p>
                            @if($announcement->file_attachment)
                            <a href="{{ Storage::url($announcement->file_attachment) }}" target="_blank" class="text-xs font-semibold text-accent inline-flex items-center">Unduh Lampiran <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg></a>
                            @else
                            <a href="#" class="text-xs font-semibold text-accent inline-flex items-center">Baca Detail <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
                            @endif
                        </div>
                        @empty
                        <div class="p-4 text-center text-institutional-500 text-sm italic bg-white border border-institutional-100 rounded-sm">
                            Belum ada pengumuman terbaru.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Call to Action -->
    <section class="relative py-24 bg-institutional-900 overflow-hidden">
        <!-- Abstract BG -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-primary-900 mix-blend-multiply opacity-50"></div>
            <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-accent/20 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-0 left-1/4 w-[600px] h-[600px] bg-primary-600/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" data-aos="zoom-in" data-aos-duration="1000">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 border border-white/20 text-white rounded-full text-xs font-semibold tracking-widest uppercase mb-8 backdrop-blur-md">
                Layanan Publik
            </div>
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-white tracking-tight mb-6">Perlu Bantuan Lebih Lanjut?</h2>
            <p class="text-xl text-primary-100 font-light max-w-3xl mx-auto mb-10 leading-relaxed">
                Jika Anda tidak menemukan informasi yang dicari pada pusat dokumen kami, Anda berhak mengajukan permohonan informasi publik secara resmi melalui portal terintegrasi kami.
            </p>
            
            <a href="/pengaduan" class="inline-flex justify-center items-center px-10 py-5 bg-white text-primary-900 font-bold rounded-sm hover:bg-institutional-50 hover:scale-105 transition-all duration-300 shadow-[0_0_30px_rgba(255,255,255,0.3)]">
                Isi Formulir Permohonan
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </section>
</x-app-layout>
