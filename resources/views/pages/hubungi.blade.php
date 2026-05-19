<x-app-layout>
    @section('title', 'Hubungi Kami')
    
    <div class="bg-institutional-900 pt-20 pb-16 border-b border-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-sm bg-primary-900/50 border border-primary-800 text-primary-200 text-sm font-medium mb-6">
                Layanan Kontak
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                Hubungi PPID
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                Kami siap membantu Anda. Jangan ragu untuk menghubungi tim layanan informasi kami untuk pertanyaan lebih lanjut.
            </p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Kontak Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-display font-bold text-institutional-900 mb-6">Informasi Kontak Resmi</h2>
                    <p class="text-institutional-600 font-light mb-8 leading-relaxed">
                        Pusat Pelayanan Informasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) beroperasi pada hari kerja. Silakan kunjungi meja layanan kami atau hubungi melalui saluran resmi di bawah ini:
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-4 border border-institutional-200 rounded-sm bg-institutional-50">
                        <div class="bg-white p-3 rounded-sm shadow-sm text-primary-600 border border-institutional-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-institutional-900">Alamat Kantor</h4>
                            <p class="text-institutional-600 font-light mt-1">{{ settings('contact_address', 'Jl. Arief Rakhman Hakim No. 59, Situ, Sumedang Utara, Kabupaten Sumedang, Jawa Barat 45323') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4 p-4 border border-institutional-200 rounded-sm bg-institutional-50">
                        <div class="bg-white p-3 rounded-sm shadow-sm text-primary-600 border border-institutional-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-institutional-900">Telepon</h4>
                            <p class="text-institutional-600 font-light mt-1">{{ settings('contact_phone', '(0261) 201531') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 border border-institutional-200 rounded-sm bg-institutional-50">
                        <div class="bg-white p-3 rounded-sm shadow-sm text-primary-600 border border-institutional-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-institutional-900">Email Utama</h4>
                            <p class="text-institutional-600 font-light mt-1">{{ settings('contact_email', 'smkn2sumedang@yahoo.com') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-institutional-200">
                    <h4 class="font-bold text-institutional-900 mb-4">Jam Operasional Layanan</h4>
                    <div class="flex justify-between text-institutional-600 font-light mb-2">
                        <span>{{ settings('contact_hours', 'Senin - Jumat, 07:00 - 15:30 WIB') }}</span>
                    </div>
                    <div class="flex justify-between text-institutional-500 font-medium mt-4">
                        <span>Sabtu, Minggu, Libur Nasional</span>
                        <span class="text-red-500">Tutup</span>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white border border-institutional-200 p-8 shadow-sm rounded-sm">
                <h3 class="text-2xl font-display font-bold text-institutional-900 mb-2">Kirim Pesan Cepat</h3>
                <p class="text-institutional-500 font-light mb-8">Formulir ini ditujukan untuk pertanyaan ringan atau dukungan teknis website. Bukan formulir permohonan informasi/pengaduan resmi.</p>
                
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-sm border border-emerald-200 bg-emerald-50 text-emerald-800 flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <span class="font-bold">Sukses!</span> {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-sm border border-red-200 bg-red-50 text-red-800">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span class="font-bold">Terjadi kesalahan input:</span>
                        </div>
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pages.hubungi.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-institutional-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-institutional-50 border border-institutional-200 rounded-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500" placeholder="Masukkan nama Anda" required>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-institutional-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 bg-institutional-50 border border-institutional-200 rounded-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500" placeholder="alamat@email.com" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-institutional-700 mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 bg-institutional-50 border border-institutional-200 rounded-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500" placeholder="08xx xxxx xxxx">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-institutional-700 mb-2">Pesan Anda</label>
                        <textarea name="message" rows="5" class="w-full px-4 py-3 bg-institutional-50 border border-institutional-200 rounded-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500" placeholder="Tuliskan pesan Anda secara detail..." required>{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-sm transition-colors shadow-sm inline-flex items-center justify-center gap-2">
                        Kirim Pesan Sekarang <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Peta Lokasi Kantor -->
        <div class="mt-16 bg-white border border-institutional-200 rounded-sm p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-primary-50 p-2 rounded-sm text-primary-600 border border-primary-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div>
                    <h3 class="text-xl font-display font-bold text-institutional-900">Peta Lokasi Kantor</h3>
                    <p class="text-sm text-institutional-500 font-light">Temukan rute tercepat ke kantor pelayanan PPID kami</p>
                </div>
            </div>
            
            <div class="relative w-full h-[450px] overflow-hidden rounded-sm border border-institutional-100 shadow-inner group">
                <iframe 
                    class="absolute inset-0 w-full h-full border-0 grayscale-[15%] contrast-[110%] group-hover:grayscale-0 transition-all duration-500" 
                    src="{{ settings('contact_map_embed', 'https://maps.google.com/maps?q=SMK%20Negeri%202%20Sumedang,%20Jl.%20Arief%20Rakhman%20Hakim%20No.%2059,%20Situ,%20Sumedang%20Utara,%20Kabupaten%20Sumedang&t=&z=15&ie=UTF8&iwloc=&output=embed') }}" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</x-app-layout>
