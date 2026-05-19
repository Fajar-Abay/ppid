<x-app-layout>
    <div class="bg-institutional-50 min-h-screen pt-12 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm font-medium" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="text-institutional-500 hover:text-primary-600 transition-colors">Beranda</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-institutional-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 md:ml-2 text-institutional-900 font-bold">Pengaduan Online</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-sm border border-institutional-200 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <!-- Sidebar Info -->
                    <div class="lg:col-span-4 bg-institutional-800 p-12 text-white border-b lg:border-b-0 lg:border-r border-institutional-200">
                        <div class="space-y-12">
                            <div>
                                <h3 class="font-display text-2xl font-semibold mb-4">Informasi Penting</h3>
                                <p class="text-institutional-300 leading-relaxed text-sm">Sebelum mengisi formulir, pastikan Anda telah menyiapkan dokumen pendukung dalam format PDF atau Gambar.</p>
                            </div>

                            <div class="space-y-6">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 bg-institutional-700 rounded-sm flex items-center justify-center shrink-0 border border-institutional-600">1</div>
                                    <div>
                                        <h4 class="font-sans font-semibold mb-1">Identitas Valid</h4>
                                        <p class="text-sm text-institutional-400">Gunakan KTP/SIM yang masih berlaku untuk verifikasi.</p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 bg-institutional-700 rounded-sm flex items-center justify-center shrink-0 border border-institutional-600">2</div>
                                    <div>
                                        <h4 class="font-sans font-semibold mb-1">Detail Jelas</h4>
                                        <p class="text-sm text-institutional-400">Ceritakan kronologi atau detail informasi yang dibutuhkan selengkap mungkin.</p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 bg-institutional-700 rounded-sm flex items-center justify-center shrink-0 border border-institutional-600">3</div>
                                    <div>
                                        <h4 class="font-sans font-semibold mb-1">Simpan Kode</h4>
                                        <p class="text-sm text-institutional-400">Setelah submit, simpan kode lacak untuk memantau progres.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-8 border-t border-institutional-700">
                                <h4 class="font-sans font-semibold mb-4">Butuh Bantuan Cepat?</h4>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 text-success rounded-sm flex items-center justify-center">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.187-2.59-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.522-2.961-2.638-.086-.117-.718-.955-.718-1.818 0-.863.453-1.288.614-1.46.16-.173.346-.217.462-.217h.332c.106 0 .218-.007.314.23.1.245.342.833.372.894.03.06.05.13.01.21-.04.08-.06.13-.12.21-.06.07-.124.13-.18.196-.054.06-.11.127-.046.24.064.11.285.469.612.76.422.376.777.493.888.54.11.048.175.04.24-.03.064-.073.272-.314.345-.423.073-.108.147-.09.248-.052.1.037.64.302.75.357.11.055.183.08.21.124.025.044.025.256-.119.661z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-institutional-400">WhatsApp Support</p>
                                        <p class="font-sans font-semibold tracking-wide text-institutional-100">{{ settings('contact_phone', '(021) 1234567') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Area -->
                    <div class="lg:col-span-8 p-6 md:p-12">
                        @livewire('public-complaint-form')
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="mt-8 text-center text-institutional-500 text-sm">
                <p>{{ settings('complaint_notice', 'Layanan ini dikelola secara profesional untuk menjamin keterbukaan informasi publik.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
