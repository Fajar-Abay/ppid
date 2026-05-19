<x-app-layout>
    @section('title', 'Lacak Laporan / Permohonan')
    
    <div class="bg-institutional-900 pt-20 pb-16 border-b border-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-sm bg-primary-900/50 border border-primary-800 text-primary-200 text-sm font-medium mb-6">
                Layanan Publik
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                Tracking Center
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                Pantau status penyelesaian dari permohonan informasi maupun pengaduan yang telah Anda kirimkan kepada kami secara real-time.
            </p>
        </div>
    </div>

    <div class="bg-institutional-50 border-b border-institutional-200">
        @livewire('complaint-tracker')
    </div>

</x-app-layout>
