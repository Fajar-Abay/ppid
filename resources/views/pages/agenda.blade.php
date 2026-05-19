<x-app-layout>
    @section('title', 'Agenda Kegiatan')
    
    <div class="bg-institutional-900 pt-20 pb-16 border-b border-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-sm bg-primary-900/50 border border-primary-800 text-primary-200 text-sm font-medium mb-6">
                Kalender Instansi
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                Agenda Kegiatan
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                Jadwal acara, rapat publik, dan kegiatan pelayanan yang akan diselenggarakan oleh instansi.
            </p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        @php
            $agendas = \App\Models\Agenda::where('is_active', true)
                        ->orderBy('start_date', 'asc')
                        ->paginate(12);
        @endphp

        @if($agendas->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($agendas as $agenda)
            <div class="bg-white border border-institutional-200 rounded-sm shadow-sm overflow-hidden flex flex-col hover:border-primary-300 transition-colors">
                <div class="flex items-stretch">
                    <!-- Date Column -->
                    <div class="w-24 bg-primary-50 border-r border-institutional-200 flex flex-col items-center justify-center py-6 shrink-0 text-primary-700">
                        <span class="text-3xl font-display font-bold leading-none">{{ \Carbon\Carbon::parse($agenda->start_date)->format('d') }}</span>
                        <span class="text-sm font-bold uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('M') }}</span>
                        <span class="text-xs text-primary-500 mt-1">{{ \Carbon\Carbon::parse($agenda->start_date)->format('Y') }}</span>
                    </div>
                    <!-- Content -->
                    <div class="p-6 flex-grow flex flex-col justify-center">
                        <h3 class="text-xl font-bold text-institutional-900 mb-2">{{ $agenda->title }}</h3>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-institutional-600">
                                <svg class="w-4 h-4 mr-2 text-institutional-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ \Carbon\Carbon::parse($agenda->start_date)->format('H:i') }} WIB @if($agenda->end_date) - {{ \Carbon\Carbon::parse($agenda->end_date)->format('H:i') }} WIB @endif
                            </div>
                            <div class="flex items-start text-sm text-institutional-600">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-institutional-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $agenda->location }}
                            </div>
                        </div>
                        @if($agenda->description)
                        <div class="prose prose-sm text-institutional-500 font-light max-w-none line-clamp-2">
                            {!! $agenda->description !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($agendas->hasPages())
        <div class="mt-12">
            {{ $agendas->links() }}
        </div>
        @endif
        
        @else
        <div class="bg-white border border-institutional-200 rounded-sm shadow-sm p-12 text-center">
            <div class="w-20 h-20 bg-primary-50 text-primary-300 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-institutional-900 mb-2">Kalender Kosong</h3>
            <p class="text-institutional-500 font-light max-w-md mx-auto">
                Tidak ada agenda kegiatan publik yang dijadwalkan dalam waktu dekat.
            </p>
            <a href="{{ route('pages.berita') }}" class="mt-8 inline-flex items-center gap-2 px-6 py-3 bg-institutional-50 text-institutional-700 font-medium rounded-sm border border-institutional-200 hover:bg-white hover:text-primary-700 transition-colors">
                Lihat Berita Terbaru
            </a>
        </div>
        @endif
    </div>
</x-app-layout>
