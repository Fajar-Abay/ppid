<x-app-layout>
    @section('title', 'Tanya Jawab (FAQ)')
    
    <div class="bg-institutional-900 pt-20 pb-16 border-b border-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-sm bg-primary-900/50 border border-primary-800 text-primary-200 text-sm font-medium mb-6">
                Pusat Bantuan PPID
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white tracking-tight leading-tight mb-4">
                Pertanyaan yang Sering Diajukan
            </h1>
            <p class="text-lg text-institutional-300 font-light max-w-2xl mx-auto">
                Temukan jawaban cepat atas pertanyaan-pertanyaan mendasar seputar hak dan layanan Keterbukaan Informasi Publik di instansi kami.
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="space-y-6">
            <!-- FAQ Item -->
            <div class="bg-white border border-institutional-200 rounded-sm p-8 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-institutional-900 mb-3 font-display">Siapa saja yang memiliki hak untuk memohon informasi publik?</h3>
                <div class="h-0.5 w-12 bg-primary-500 mb-4"></div>
                <p class="text-institutional-600 font-light leading-relaxed">
                    Berdasarkan amanat UU No. 14 Tahun 2008, setiap **Warga Negara Indonesia (WNI)** baik secara perseorangan, kelompok orang, maupun badan hukum perdata di Indonesia berhak sepenuhnya untuk mengajukan permohonan informasi publik. Syarat mutlaknya adalah menyertakan kelengkapan identitas yang sah (seperti KTP elektronik) dan mengisi formulir dengan alasan/tujuan permohonan yang jelas.
                </p>
            </div>

            <!-- FAQ Item -->
            <div class="bg-white border border-institutional-200 rounded-sm p-8 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-institutional-900 mb-3 font-display">Apakah saya harus membayar sejumlah biaya untuk mendapatkan informasi?</h3>
                <div class="h-0.5 w-12 bg-primary-500 mb-4"></div>
                <p class="text-institutional-600 font-light leading-relaxed">
                    Sama sekali **Tidak**. Pada prinsipnya seluruh bentuk pelayanan informasi publik dari PPID diberikan secara **gratis** (bebas biaya permohonan). Pemohon hanya diwajibkan membayar biaya riil apabila dokumen tersebut perlu digandakan secara fisik (seperti biaya fotokopi, cetak buku, atau flashdisk) dan itupun dikenakan sesuai dengan tarif wajar fotokopi umum tanpa keuntungan instansi.
                </p>
            </div>

            <!-- FAQ Item -->
            <div class="bg-white border border-institutional-200 rounded-sm p-8 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-institutional-900 mb-3 font-display">Berapa lama waktu resmi yang dibutuhkan PPID untuk memproses permohonan saya?</h3>
                <div class="h-0.5 w-12 bg-primary-500 mb-4"></div>
                <p class="text-institutional-600 font-light leading-relaxed">
                    Undang-Undang mengamanatkan bahwa Badan Publik wajib memberikan surat "Pemberitahuan Tertulis" paling lambat **10 (sepuluh) hari kerja** sejak dokumen permohonan dinyatakan lengkap dan tercatat dalam register. Namun, apabila PPID membutuhkan waktu lebih panjang untuk menghimpun data dari unit pelaksana teknis, PPID dapat memperpanjang masa tersebut secara resmi maksimal **7 (tujuh) hari kerja** dengan menyertakan alasan penundaan kepada pemohon.
                </p>
            </div>

            <!-- FAQ Item -->
            <div class="bg-white border border-institutional-200 rounded-sm p-8 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-institutional-900 mb-3 font-display">Apa langkah hukum yang bisa saya ambil jika permohonan informasi saya ditolak?</h3>
                <div class="h-0.5 w-12 bg-primary-500 mb-4"></div>
                <p class="text-institutional-600 font-light leading-relaxed">
                    Apabila Anda merasa tanggapan PPID tidak memuaskan, ditolak secara tidak wajar, data tidak lengkap, atau tidak ditanggapi melewati batas waktu undang-undang, Anda berhak penuh untuk mengajukan gugatan **Keberatan Informasi** yang ditujukan langsung kepada **Atasan PPID**. Pengajuan keberatan harus dilakukan selambat-lambatnya 30 (tiga puluh) hari kerja setelah diterimanya pemberitahuan penolakan. Jika Atasan PPID tidak memuaskan, Anda bisa menempuh jalur Sengketa ke Komisi Informasi tingkat provinsi/pusat.
                </p>
            </div>
            
            <!-- FAQ Item -->
            <div class="bg-white border border-institutional-200 rounded-sm p-8 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-xl font-bold text-institutional-900 mb-3 font-display">Apa yang dimaksud dengan "Informasi yang Dikecualikan"?</h3>
                <div class="h-0.5 w-12 bg-primary-500 mb-4"></div>
                <p class="text-institutional-600 font-light leading-relaxed">
                    Perlu diketahui bahwa **tidak semua dokumen pemerintah bersifat terbuka**. Informasi yang Dikecualikan adalah dokumen rahasia negara/instansi yang apabila dibuka dapat menghambat proses penegakan hukum (penyelidikan kepolisian/kejaksaan), mengganggu perlindungan hak kekayaan intelektual (HAKI) dan persaingan usaha sehat, membahayakan strategi pertahanan dan keamanan negara, atau dokumen yang mengungkap rahasia pribadi pasien/klien secara hukum.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
