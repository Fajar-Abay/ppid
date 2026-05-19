<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ settings('site_name') }} - {{ settings('site_tagline') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset(settings('favicon_url', 'favicon.ico')) }}">
    
    <!-- SEO -->
    <meta name="description" content="{{ settings('site_description') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-base text-institutional-600 bg-institutional-50">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white border-b border-institutional-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-4">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-smea.svg') }}" alt="Logo SMKN 2 Sumedang" class="w-12 h-12 object-contain">
                        <div class="flex flex-col">
                            <span class="font-display text-xl font-bold tracking-tight text-institutional-800 leading-tight">{{ settings('site_name', 'PPID SMKN 2 Sumedang') }}</span>
                            <span class="text-xs text-institutional-500 font-medium uppercase tracking-widest">{{ settings('department_name', 'SMK Negeri 2 Sumedang') }}</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-8 h-full">
                    <a href="/" class="font-display text-sm font-medium tracking-wide {{ request()->is('/') ? 'text-primary-700 border-b-2 border-primary-600' : 'text-institutional-600 border-b-2 border-transparent hover:text-primary-700 hover:border-primary-300' }} h-full flex items-center transition-colors">Beranda</a>
                    
                    <a href="{{ route('pages.profil') }}" class="font-display text-sm font-medium tracking-wide {{ request()->is('profil') ? 'text-primary-700 border-b-2 border-primary-600' : 'text-institutional-600 border-b-2 border-transparent hover:text-primary-700 hover:border-primary-300' }} h-full flex items-center transition-colors">Profil</a>

                    <!-- Dropdown Tentang PPID -->
                    <div class="relative group h-full flex items-center">
                        <button class="font-display text-sm font-medium tracking-wide {{ request()->is('ppid/*', 'regulasi', 'pedoman', 'standar-layanan') ? 'text-primary-700 border-b-2 border-primary-600' : 'text-institutional-600 border-b-2 border-transparent hover:text-primary-700 hover:border-primary-300' }} h-full flex items-center transition-colors gap-1">
                            Tentang PPID
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div class="absolute top-[80px] left-0 hidden group-hover:flex flex-col bg-white border border-institutional-200 shadow-lg min-w-[240px] z-50">
                            <a href="{{ route('pages.ppid.profil') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Profil PPID</a>
                            <a href="{{ route('pages.ppid.tugas-fungsi') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Tugas dan Fungsi PPID</a>
                            <a href="{{ route('pages.ppid.visi-misi') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Visi dan Misi PPID</a>
                            <a href="{{ route('pages.regulasi') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Regulasi KIP</a>
                            <a href="{{ route('pages.pedoman') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Pedoman PPID</a>
                            <a href="{{ route('pages.standar-layanan') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors">Standar Layanan</a>
                        </div>
                    </div>

                    <!-- Dropdown Informasi Publik -->
                    <div class="relative group h-full flex items-center">
                        <button class="font-display text-sm font-medium tracking-wide {{ request()->is('berita', 'agenda', 'pengumuman') ? 'text-primary-700 border-b-2 border-primary-600' : 'text-institutional-600 border-b-2 border-transparent hover:text-primary-700 hover:border-primary-300' }} h-full flex items-center transition-colors gap-1">
                            Informasi Publik
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div class="absolute top-[80px] left-0 hidden group-hover:flex flex-col bg-white border border-institutional-200 shadow-lg min-w-[200px] z-50">
                            <a href="{{ route('pages.berita') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Berita</a>
                            <a href="{{ route('pages.agenda') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Agenda</a>
                            <a href="{{ route('pages.pengumuman') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors">Pengumuman</a>
                        </div>
                    </div>

                    <a href="{{ route('public.dokumen') }}" class="font-display text-sm font-medium tracking-wide {{ request()->is('dokumen') ? 'text-primary-700 border-b-2 border-primary-600' : 'text-institutional-600 border-b-2 border-transparent hover:text-primary-700 hover:border-primary-300' }} h-full flex items-center transition-colors">Pusat Dokumen</a>

                    <!-- Dropdown Layanan -->
                    <div class="relative group h-full flex items-center">
                        <button class="font-display text-sm font-medium tracking-wide {{ request()->is('pengaduan', 'lacak', 'f-a-q', 'hubungi') ? 'text-primary-700 border-b-2 border-primary-600' : 'text-institutional-600 border-b-2 border-transparent hover:text-primary-700 hover:border-primary-300' }} h-full flex items-center transition-colors gap-1">
                            Layanan
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div class="absolute top-[80px] left-0 hidden group-hover:flex flex-col bg-white border border-institutional-200 shadow-lg min-w-[200px] z-50">
                            <a href="{{ route('public.complaint') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Form Pengaduan</a>
                            <a href="{{ route('public.lacak') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">Lacak Permohonan</a>
                            <a href="{{ route('pages.faq') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors border-b border-institutional-100">F A Q</a>
                            <a href="{{ route('pages.hubungi') }}" class="px-4 py-3 text-sm text-institutional-700 hover:bg-institutional-50 hover:text-primary-700 transition-colors">Hubungi Kami</a>
                        </div>
                    </div>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="/admin" class="hidden sm:inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-primary-600 rounded-sm hover:bg-primary-700 transition-colors">
                        Portal Admin
                    </a>
                    <button class="md:hidden p-2 text-institutional-600 hover:text-primary-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="min-h-[70vh]">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-institutional-900 text-institutional-300 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/logo-smea.svg') }}" alt="Logo SMKN 2 Sumedang" class="w-10 h-10 object-contain bg-white rounded-full p-0.5">
                        <span class="font-display text-xl font-bold text-white">{{ settings('site_name', 'PPID SMKN 2 Sumedang') }}</span>
                    </div>
                    <p class="text-institutional-400 max-w-md leading-relaxed mb-6">
                        {{ settings('site_description', 'Layanan Informasi Publik Terintegrasi.') }}
                    </p>
                    <div class="flex gap-4">
                        <!-- Social Icons Placeholder -->
                    </div>
                </div>
                
                <div>
                    <h4 class="font-display text-white font-bold mb-6">Tautan Cepat</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Permohonan Informasi</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Daftar Informasi Publik</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Prosedur Keberatan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kontak Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-display text-white font-bold mb-6">Kontak Kami</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ settings('contact_address', 'Alamat Kantor Instansi') }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ settings('contact_phone', '(021) 1234567') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-institutional-700 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-institutional-400">
                <p>&copy; {{ date('Y') }} {{ settings('site_name', 'PPID CMS') }}. Seluruh hak cipta dilindungi.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    @filamentScripts
    @livewireScripts
</body>
</html>
