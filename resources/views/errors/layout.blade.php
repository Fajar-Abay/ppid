<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ settings('site_name', 'PPID Portal') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f4fa',
                            100: '#dbe6f5',
                            200: '#bdcde8',
                            300: '#94afd7',
                            400: '#678cc2',
                            500: '#3d60a1', // Navy Blue
                            600: '#354f8a',
                            700: '#2b3f70',
                            800: '#23325c',
                            900: '#1d274c',
                        },
                        institutional: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased font-sans bg-institutional-50 text-institutional-600 min-h-screen flex flex-col justify-between">
    <!-- Background glowing spots -->
    <div class="absolute inset-0 overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[600px] h-[600px] bg-primary-100 rounded-full blur-[140px] opacity-60"></div>
        <div class="absolute top-[40%] right-[5%] w-[500px] h-[500px] bg-indigo-100 rounded-full blur-[130px] opacity-50"></div>
    </div>

    <!-- Minimal Header -->
    <header class="bg-white border-b border-institutional-200 py-5 px-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-primary-600 rounded-sm flex items-center justify-center text-white font-extrabold text-base">P</div>
                <div class="flex flex-col">
                    <span class="font-display text-lg font-bold tracking-tight text-institutional-800 leading-none">{{ settings('site_name', 'PPID') }}</span>
                    <span class="text-[10px] text-institutional-400 font-semibold uppercase tracking-widest mt-1">{{ settings('department_name', 'Portal Informasi') }}</span>
                </div>
            </a>
            <a href="/" class="text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-1 transition-colors">
                Kembali ke Portal Utama
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </header>

    <!-- Main Container: Split Column Layout -->
    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 flex-grow flex items-center">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-stretch w-full">
            
            <!-- Left Column: Big Error State (Artistic) -->
            <div class="lg:col-span-5 bg-white border border-institutional-200 shadow-xl rounded-sm p-8 sm:p-12 flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <div>
                    <!-- Code -->
                    <h1 class="font-display text-8xl sm:text-9xl font-extrabold tracking-tighter bg-gradient-to-r from-primary-500 via-primary-600 to-indigo-700 bg-clip-text text-transparent drop-shadow-sm select-none leading-none mb-6">
                        @yield('code')
                    </h1>

                    <!-- Message -->
                    <h2 class="font-display text-2xl sm:text-3xl font-bold text-institutional-800 tracking-tight mb-4">
                        @yield('message')
                    </h2>

                    <!-- Description -->
                    <p class="text-institutional-500 leading-relaxed text-sm sm:text-base mb-8">
                        @yield('description')
                    </p>
                </div>

                <!-- Back Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-institutional-100">
                    <a href="/" class="inline-flex justify-center items-center px-5 py-3 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-sm transition-colors shadow-sm shadow-primary-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Ke Beranda
                    </a>
                    <a href="javascript:history.back()" class="inline-flex justify-center items-center px-5 py-3 text-sm font-semibold text-institutional-600 bg-institutional-100 hover:bg-institutional-200 rounded-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Kembali Sebelumnya
                    </a>
                </div>
            </div>

            <!-- Right Column: Interactive Navigation & Help Hub -->
            <div class="lg:col-span-7 flex flex-col justify-between gap-8">
                <!-- Navigation Cards -->
                <div class="bg-white border border-institutional-200 shadow-xl rounded-sm p-8 sm:p-10 flex-grow">
                    <h3 class="font-display text-lg font-bold text-institutional-800 border-b border-institutional-100 pb-4 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-primary-600 rounded-sm inline-block"></span>
                        Mungkin Anda sedang mencari layanan berikut:
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Card 1: Pusat Dokumen -->
                        <a href="/dokumen" class="group border border-institutional-200 rounded-sm p-4 hover:border-primary-500 hover:bg-primary-50/20 transition-all duration-200">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-primary-50 rounded-sm text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-sm text-institutional-800 group-hover:text-primary-600 transition-colors">Pusat Dokumen Publik</h4>
                                    <p class="text-xs text-institutional-400 mt-1 leading-relaxed">Cari regulasi KIP, laporan tahunan, dan berkas PPID resmi.</p>
                                </div>
                            </div>
                        </a>

                        <!-- Card 2: Lacak Permohonan -->
                        <a href="/lacak" class="group border border-institutional-200 rounded-sm p-4 hover:border-primary-500 hover:bg-primary-50/20 transition-all duration-200">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-primary-50 rounded-sm text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z" /></svg>
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-sm text-institutional-800 group-hover:text-primary-600 transition-colors">Lacak Permohonan</h4>
                                    <p class="text-xs text-institutional-400 mt-1 leading-relaxed">Pantau secara real-time status pengajuan informasi publik Anda.</p>
                                </div>
                            </div>
                        </a>

                        <!-- Card 3: Form Pengaduan -->
                        <a href="/pengaduan" class="group border border-institutional-200 rounded-sm p-4 hover:border-primary-500 hover:bg-primary-50/20 transition-all duration-200">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-primary-50 rounded-sm text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-sm text-institutional-800 group-hover:text-primary-600 transition-colors">Ajukan Keberatan/Laporan</h4>
                                    <p class="text-xs text-institutional-400 mt-1 leading-relaxed">Formulir online resmi untuk keluhan, saran, atau permohonan keberatan.</p>
                                </div>
                            </div>
                        </a>

                        <!-- Card 4: Berita & Publikasi -->
                        <a href="/berita" class="group border border-institutional-200 rounded-sm p-4 hover:border-primary-500 hover:bg-primary-50/20 transition-all duration-200">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-primary-50 rounded-sm text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m-7.5-6h7.5m-3-3h3m-7.5-3h7.5c1.03 0 1.865.836 1.865 1.865v11.27c0 1.03-.836 1.865-1.865 1.865H4.865C3.835 18.735 3 17.9 3 16.87V5.615C3 4.585 3.835 3.75 4.865 3.75H12v3.75z" /></svg>
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-sm text-institutional-800 group-hover:text-primary-600 transition-colors">Berita & Pengumuman</h4>
                                    <p class="text-xs text-institutional-400 mt-1 leading-relaxed">Simak berita terbaru, agenda kegiatan, dan pengumuman instansi.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Assistance Card -->
                <div class="bg-white border border-institutional-200 shadow-xl rounded-sm p-8 flex items-center justify-between gap-6 relative overflow-hidden">
                    <!-- Left -->
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.186-4.164-6.99-6.99l1.293-.97c.362-.272.528-.834.417-1.273L5.203 3.033A1.25 1.25 0 004.093 2.25H2.25A2.25 2.25 0 002.25 6.75z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-display font-bold text-sm text-institutional-800">Butuh bantuan langsung?</h4>
                            <p class="text-xs text-institutional-400 mt-1 leading-relaxed">Hubungi helpdesk kami di <span class="font-semibold text-institutional-700">{{ settings('contact_phone', '(021) 1234-5678') }}</span> atau email <span class="font-semibold text-institutional-700">{{ settings('contact_email', 'ppid@instansi.go.id') }}</span></p>
                        </div>
                    </div>
                    <!-- Right -->
                    <a href="/hubungi" class="hidden sm:inline-flex items-center px-4 py-2 border border-institutional-300 rounded-sm text-xs font-semibold text-institutional-700 hover:border-primary-500 hover:text-primary-600 hover:bg-primary-50/20 transition-all duration-200">
                        Hubungi Kami
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-institutional-200 py-6 text-center text-xs font-medium text-institutional-400">
        <div class="max-w-7xl mx-auto px-4">
            &copy; {{ date('Y') }} {{ settings('site_name', 'PPID CMS') }}. Seluruh Hak Cipta Dilindungi.
        </div>
    </footer>
</body>
</html>
