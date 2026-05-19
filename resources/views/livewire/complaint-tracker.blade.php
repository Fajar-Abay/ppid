<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold font-display text-institutional-900 mb-4">Lacak Status Pengaduan / Permohonan</h1>
        <p class="text-institutional-600 font-light">Masukkan nomor resi (Tracking Code) untuk melihat status terkini dari pengaduan atau permohonan informasi Anda.</p>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-sm shadow-sm border border-institutional-200 mb-8">
        <form wire:submit="track" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="trackingCode" class="sr-only">Nomor Resi / Tracking Code</label>
                <input type="text" id="trackingCode" wire:model="trackingCode" placeholder="Contoh: PPID-2026-0001" class="w-full px-4 py-3 rounded-sm border-institutional-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono">
                @error('trackingCode') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-medium rounded-sm hover:bg-primary-700 transition-colors flex items-center justify-center gap-2 whitespace-nowrap" wire:loading.attr="disabled">
                <svg wire:loading.remove wire:target="track" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <svg wire:loading wire:target="track" class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Lacak Status
            </button>
        </form>
    </div>

    @if($searched)
        @if($complaint)
            <div class="bg-white rounded-sm shadow-sm border border-institutional-200 overflow-hidden">
                <div class="p-6 border-b border-institutional-100 bg-institutional-50">
                    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                        <div>
                            <p class="text-sm text-institutional-500 mb-1">Nomor Resi</p>
                            <h3 class="text-xl font-mono font-bold text-institutional-900">{{ $complaint->tracking_code }}</h3>
                        </div>
                        <div class="text-left md:text-right">
                            <p class="text-sm text-institutional-500 mb-1">Tanggal Masuk</p>
                            <p class="font-medium text-institutional-800">{{ $complaint->submitted_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h4 class="font-bold text-institutional-900 mb-2">{{ $complaint->subject }}</h4>
                    <p class="text-institutional-600 mb-8">{{ $complaint->description }}</p>

                    <!-- Timeline -->
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-institutional-200"></div>
                        <ul class="space-y-6 relative">
                            @foreach($complaint->status_timeline as $step)
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full border-2 flex items-center justify-center bg-white z-10 {{ $step['done'] ? 'border-primary-600 text-primary-600' : 'border-institutional-300 text-institutional-300' }}">
                                        @if($step['done'])
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        @else
                                            <div class="w-2 h-2 rounded-full bg-institutional-300"></div>
                                        @endif
                                    </div>
                                    <div class="ml-4 mt-1">
                                        <h5 class="text-sm font-bold {{ $step['done'] ? 'text-institutional-900' : 'text-institutional-500' }}">{{ $step['label'] }}</h5>
                                        @if($step['status'] === 'completed' && $step['done'] && $complaint->responseLetter)
                                            <p class="text-sm text-institutional-600 mt-2">Permohonan Anda telah ditanggapi. Silakan unduh surat tanggapan melalui tombol di bawah.</p>
                                            <a href="{{ Storage::url($complaint->responseLetter->pdf_path) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-institutional-100 text-institutional-800 text-sm font-medium rounded hover:bg-institutional-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                Unduh Surat Tanggapan
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-50 border border-red-200 text-red-700 p-6 rounded-sm text-center">
                <svg class="w-12 h-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <h3 class="font-bold mb-1">Data Tidak Ditemukan</h3>
                <p class="text-sm">Maaf, kami tidak dapat menemukan pengaduan atau permohonan dengan nomor resi tersebut. Pastikan Anda mengetikkan nomor yang benar.</p>
            </div>
        @endif
    @endif
</div>
