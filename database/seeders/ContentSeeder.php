<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Complaint;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        $cat1 = Category::firstOrCreate(['slug' => 'laporan-keuangan'], ['name' => 'Laporan Keuangan', 'description' => 'Dokumen keuangan tahunan dan semesteran.']);
        $cat2 = Category::firstOrCreate(['slug' => 'regulasi'], ['name' => 'Regulasi', 'description' => 'Peraturan daerah dan undang-undang.']);
        
        // 2. Documents
        Document::firstOrCreate(['slug' => 'laporan-keuangan-2025'], [
            'title' => 'Laporan Keuangan Instansi 2025',
            'category_id' => $cat1->id,
            'description' => 'Laporan pertanggungjawaban keuangan tahun anggaran 2025.',
            'download_count' => 150,
            'status' => \App\Enums\DocumentStatus::Published,
            'published_at' => now(),
        ]);
        
        Document::firstOrCreate(['slug' => 'sk-kepala-dinas-01-2026'], [
            'title' => 'SK Kepala Dinas tentang Keterbukaan Informasi',
            'category_id' => $cat2->id,
            'description' => 'Surat Keputusan tentang prosedur pelayanan informasi publik.',
            'download_count' => 45,
            'status' => \App\Enums\DocumentStatus::Published,
            'published_at' => now(),
        ]);

        // 3. Posts
        Post::firstOrCreate(['slug' => 'sosialisasi-ppid-2026'], [
            'title' => 'Sosialisasi Keterbukaan Informasi Publik 2026',
            'content' => '<p>Pada hari ini instansi kami menyelenggarakan sosialisasi keterbukaan informasi publik yang dihadiri oleh seluruh elemen masyarakat dan tokoh pemuda...</p>',
            'published_at' => now(),
            'is_published' => true,
        ]);
        
        Post::firstOrCreate(['slug' => 'penghargaan-ki-2025'], [
            'title' => 'Instansi Meraih Penghargaan Keterbukaan Informasi',
            'content' => '<p>Alhamdulillah, berkat kerja keras tim PPID, instansi kita meraih penghargaan bergengsi dalam kategori institusi paling informatif tingkat nasional...</p>',
            'published_at' => now()->subDays(5),
            'is_published' => true,
        ]);

        // 4. Agendas
        Agenda::firstOrCreate(['slug' => 'rapat-koordinasi-ppid'], [
            'title' => 'Rapat Koordinasi PPID Pelaksana',
            'description' => '<p>Pertemuan rutin seluruh admin PPID untuk membahas evaluasi triwulan layanan informasi.</p>',
            'location' => 'Ruang Rapat Utama',
            'start_date' => now()->addDays(2)->setHour(9)->setMinute(0),
            'end_date' => now()->addDays(2)->setHour(12)->setMinute(0),
        ]);

        Agenda::firstOrCreate(['slug' => 'pelatihan-sengketa-informasi'], [
            'title' => 'Pelatihan Penanganan Sengketa Informasi',
            'description' => '<p>Pelatihan teknis mengenai ajudikasi non-litigasi dan mediasi sengketa informasi oleh Komisi Informasi.</p>',
            'location' => 'Aula Gedung Serbaguna',
            'start_date' => now()->addDays(10)->setHour(8)->setMinute(0),
            'end_date' => now()->addDays(10)->setHour(15)->setMinute(0),
        ]);

        // 5. Announcements
        Announcement::firstOrCreate(['slug' => 'libur-nasional-idul-adha'], [
            'title' => 'Penyesuaian Jam Layanan Selama Libur Nasional',
            'content' => '<p>Sehubungan dengan libur nasional, pelayanan tatap muka dihentikan sementara mulai tanggal 15 hingga 17 Juni. Namun layanan digital tetap beroperasi normal.</p>',
        ]);

        // 6. Complaints
        Complaint::firstOrCreate(['tracking_code' => 'PPID-2026-0001'], [
            'complainant_name' => 'Budi Santoso',
            'complainant_email' => 'budi.santoso@example.com',
            'complainant_phone' => '081234567890',
            'complainant_address' => 'Jl. Merdeka No 1',
            'subject' => 'Permohonan Salinan SK',
            'description' => 'Mohon dikirimkan salinan SK terbaru mengenai tata kelola PPID',
            'category' => 'permohonan_informasi',
            'status' => \App\Enums\ComplaintStatus::Pending,
            'submitted_at' => now(),
        ]);
        
        Complaint::firstOrCreate(['tracking_code' => 'PPID-2026-0002'], [
            'complainant_name' => 'Siti Aminah',
            'complainant_email' => 'siti@example.com',
            'complainant_phone' => '08987654321',
            'complainant_address' => 'Jl. Kebon Jeruk No 15',
            'subject' => 'Keluhan Pelayanan Kurang Cepat',
            'description' => 'Kemarin saya datang ke kantor namun loket PPID kosong. Mohon diperbaiki kedisiplinan petugas.',
            'category' => 'pengaduan',
            'status' => \App\Enums\ComplaintStatus::Processing,
            'submitted_at' => now()->subDays(2),
        ]);

        // 7. Letter Templates
        \App\Models\LetterTemplate::firstOrCreate(['name' => 'Template Jawaban Standar PPID'], [
            'subject_template' => 'Tanggapan Atas Permohonan Informasi Publik - {tracking_code}',
            'body_template' => '<p>Menindaklanjuti permohonan informasi publik saudara/i dengan nomor registrasi <strong>{tracking_code}</strong> mengenai <strong>"{subject}"</strong>, bersama ini kami sampaikan tanggapan resmi dari Pejabat Pengelola Informasi dan Dokumentasi (PPID).</p><p>Berdasarkan hasil analisis berkas dan koordinasi internal kami, dokumen informasi publik yang Anda minta berkategori <strong>Terbuka</strong> dan terlampir bersama surat keputusan ini.</p><p>Demikian surat tanggapan ini kami sampaikan untuk dipergunakan sebagaimana mestinya.</p>',
            'header_html' => '',
            'footer_html' => '',
            'css_styles' => '',
            'is_active' => true,
        ]);

        $this->command->info('Dummy content seeded successfully!');
    }
}
