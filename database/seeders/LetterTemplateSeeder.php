<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LetterTemplate;
use Illuminate\Database\Seeder;

class LetterTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $headerHtml = <<<HTML
<div style="text-align: center; border-bottom: 3px double #0f172a; padding-bottom: 16px; margin-bottom: 24px; font-family: 'Times New Roman', Times, serif;">
    <h2 style="margin: 0; font-size: 18px; font-weight: bold; text-transform: uppercase; color: #0f172a; letter-spacing: 0.05em;">PEMERINTAH DAERAH PROVINSI / KOTA</h2>
    <h1 style="margin: 4px 0 0 0; font-size: 22px; font-weight: bold; text-transform: uppercase; color: #1e3a8a; letter-spacing: 0.03em;">PEJABAT PENGELOLA INFORMASI DAN DOKUMENTASI (PPID)</h1>
    <p style="margin: 6px 0 0 0; font-size: 11px; color: #475569; font-style: italic;">Jl. Pahlawan Protokol No. 1, Gedung Hubungan Masyarakat | Telp: (021) 555-0199 | Email: ppid@pemda.go.id</p>
</div>
HTML;

        $footerHtml = <<<HTML
<div style="margin-top: 48px; padding-top: 16px; border-top: 1px solid #cbd5e1; text-align: center; font-size: 11px; color: #64748b; font-family: 'Times New Roman', Times, serif;">
    <p style="margin: 0;">Surat tanggapan ini diterbitkan secara elektronik oleh Sistem Portal PPID Satu Pintu Pemerintah Daerah.</p>
    <p style="margin: 4px 0 0 0; font-weight: bold; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.02em;">Keterbukaan Informasi Publik adalah Pilar Utama Demokrasi</p>
</div>
HTML;

        $cssStyles = <<<CSS
p { margin: 0 0 12px 0; text-align: justify; }
strong { font-weight: bold; }
em { font-style: italic; }
CSS;

        // 1. Template Tanggapan Pengaduan Umum
        LetterTemplate::updateOrCreate(
            ['slug' => 'surat-tanggapan-pengaduan'],
            [
                'name'             => 'Surat Tanggapan Pengaduan Publik',
                'subject_template' => 'Tanggapan Resmi Pengaduan PPID - No. Tiket {ticket_number}',
                'body_template'    => <<<HTML
<p>Sehubungan dengan pengaduan / permohonan informasi publik yang Bapak/Ibu ajukan melalui portal PPID dengan nomor tiket/resi <strong>{ticket_number}</strong> perihal <em>"{complaint_subject}"</em>, bersama ini kami sampaikan tanggapan resmi dari Tim PPID Pelaksana:</p>

<div class="callout">
    {response_text}
</div>

<p>Dokumen kelengkapan pendukung atau berkas rujukan (apabila ada) telah kami lampirkan bersama surat elektronik ini, atau Bapak/Ibu dapat melacak perkembangan kelanjutan pengaduan melalui modul Pelacakan Tiket PPID di portal utama kami.</p>

<p>Demikian tanggapan resmi ini kami sampaikan. Kami berkomitmen untuk terus meningkatkan pelayanan informasi yang cepat, mudah, akuntabel, dan transparan bagi seluruh masyarakat.</p>
HTML,
                'header_html'      => $headerHtml,
                'footer_html'      => $footerHtml,
                'css_styles'       => $cssStyles,
                'is_active'        => true,
            ]
        );

        // 2. Template Persetujuan Permohonan Informasi
        LetterTemplate::updateOrCreate(
            ['slug' => 'surat-persetujuan-informasi'],
            [
                'name'             => 'Surat Keputusan Pemberian Informasi (Disetujui)',
                'subject_template' => 'Persetujuan Permohonan Informasi PPID - No. {ticket_number}',
                'body_template'    => <<<HTML
<p>Menindaklanjuti permohonan informasi publik yang Bapak/Ibu ajukan melalui portal PPID dengan nomor tiket/resi <strong>{ticket_number}</strong>, dengan ini kami sampaikan bahwa permohonan informasi Anda dinyatakan <strong>DISETUJUI</strong> dan dapat dipenuhi seluruhnya.</p>

<p>Adapun rincian informasi dan berkas dokumen yang Anda minta telah kami sertakan sebagai lampiran resmi surat ini. Anda juga dapat mengakses berkas tersebut sewaktu-waktu melalui menu pelacakan status di portal PPID Pemerintah Daerah.</p>

<p>Semoga data dan informasi yang kami sajikan dapat dipergunakan dengan sebaik-baiknya guna mendukung transparansi dan kemajuan publik.</p>
HTML,
                'header_html'      => $headerHtml,
                'footer_html'      => $footerHtml,
                'css_styles'       => $cssStyles,
                'is_active'        => true,
            ]
        );

        // 3. Template Penolakan Permohonan Informasi (Dikecualikan)
        LetterTemplate::updateOrCreate(
            ['slug' => 'surat-penolakan-informasi'],
            [
                'name'             => 'Surat Pemberitahuan Penolakan Informasi (Dikecualikan)',
                'subject_template' => 'Pemberitahuan Penolakan Permohonan Informasi PPID - No. {ticket_number}',
                'body_template'    => <<<HTML
<p>Merujuk pada surat permohonan informasi publik yang Bapak/Ibu ajukan melalui portal PPID dengan nomor tiket/resi <strong>{ticket_number}</strong> perihal <em>"{complaint_subject}"</em>, setelah dilakukan verifikasi dan kajian seksama oleh Tim Pertimbangan Pelayanan Informasi PPID, bersama ini kami sampaikan bahwa permohonan informasi tersebut <strong>BELUM DAPAT KAMI PENUHI</strong>.</p>

<p>Adapun dasar pertimbangan dan alasan penolakan permohonan informasi tersebut adalah sebagai berikut:</p>

<div class="callout" style="background-color: #fff5f5; border-left: 4px solid #dc2626; padding: 12px 15px; border-radius: 4px; color: #991b1b; font-size: 10.5pt; text-indent: 0;">
    <strong>Dasar Hukum & Alasan Pengecualian:</strong><br>
    {response_text}
</div>

<p>Keputusan ini merujuk secara resmi pada ketentuan <strong>Undang-Undang Republik Indonesia Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik Pasal 17</strong> mengenai Klasifikasi Informasi Publik yang Dikecualikan dan wajib dilindungi oleh hukum negara.</p>

<p>Apabila Bapak/Ibu merasa keberatan terhadap keputusan penolakan ini, Bapak/Ibu berhak mengajukan surat keberatan resmi kepada Atasan PPID dalam jangka waktu selambat-lambatnya 30 (tiga puluh) hari kerja sejak surat pemberitahuan ini diterima.</p>

<p>Demikian pemberitahuan ini kami sampaikan untuk menjadi maklum. Atas pengertian dan kerja sama yang baik dari Bapak/Ibu, kami ucapkan terima kasih.</p>
HTML,
                'header_html'      => $headerHtml,
                'footer_html'      => $footerHtml,
                'css_styles'       => $cssStyles,
                'is_active'        => true,
            ]
        );
    }
}
