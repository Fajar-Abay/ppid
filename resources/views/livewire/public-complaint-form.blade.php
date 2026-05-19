<div class="max-w-6xl mx-auto py-8">
    @if ($trackingCode)
        <div class="max-w-2xl mx-auto text-center space-y-8">
            <div class="w-20 h-20 bg-success/10 text-success rounded-sm flex items-center justify-center mx-auto border border-success/20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            
            <div>
                <h2 class="font-display text-3xl font-bold text-institutional-800 mb-2">Pengaduan Berhasil Dikirim</h2>
                <p class="text-institutional-600">Terima kasih atas laporan Anda. Mohon simpan kode lacak di bawah ini untuk memantau status pengaduan Anda.</p>
            </div>

            <div class="p-8 bg-institutional-50 border border-institutional-200 rounded-sm">
                <span class="text-xs font-semibold text-institutional-500 uppercase tracking-widest mb-4 block">Kode Lacak Anda</span>
                <div class="font-display text-4xl font-bold text-primary-700 tracking-wider select-all">{{ $trackingCode }}</div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                <button wire:click="$set('trackingCode', null)" class="px-8 py-3 bg-institutional-800 text-white font-medium rounded-sm hover:bg-institutional-900 transition-colors">
                    Kirim Pengaduan Baru
                </button>
                <a href="/" class="px-8 py-3 bg-white border border-institutional-200 text-institutional-700 font-medium rounded-sm hover:bg-institutional-50 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    @else
        <div class="space-y-8">
            <div class="max-w-2xl">
                <h1 class="font-display text-3xl font-bold text-institutional-800 tracking-tight mb-4">Layanan Permohonan Informasi Online</h1>
                <p class="text-institutional-600 leading-relaxed">
                    Sampaikan pengaduan atau permohonan informasi publik Anda melalui formulir di bawah ini. Kami berkomitmen untuk merespons sesuai batas waktu perundang-undangan.
                </p>
            </div>

            <form wire:submit="submit" class="space-y-8">
                {{ $this->form }}

                <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-6 bg-institutional-50 rounded-sm border border-institutional-200 gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-primary-100 text-primary-700 rounded-sm flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                        <p class="text-sm text-institutional-700 font-medium leading-relaxed">
                            Pastikan data yang Anda masukkan sesuai identitas yang sah. Laporan yang tidak valid tidak akan diproses.
                        </p>
                    </div>

                    <button type="submit" class="shrink-0 inline-flex items-center gap-2 px-8 py-3 bg-primary-600 text-white font-medium rounded-sm hover:bg-primary-700 transition-colors w-full md:w-auto justify-center">
                        <span>Kirim Permohonan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
