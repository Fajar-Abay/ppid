<x-mail::message>
# Pemberitahuan Tanggapan PPID

Yth. **{{ $complaint->complainant_name }}**,

Merujuk pada permohonan/pengaduan informasi publik yang Anda ajukan sebelumnya dengan rincian:

- **Kode Registrasi:** {{ $complaint->tracking_code }}
- **Kategori:** {{ ucwords(str_replace('_', ' ', $complaint->category)) }}
- **Perihal:** {{ $complaint->subject }}

Melalui pesan elektronik ini, kami menginformasikan bahwa proses penanganan atas permohonan/pengaduan tersebut telah **Selesai**. 

Sebagai bentuk tindak lanjut dan penyelesaian akhir, kami telah menyertakan **Surat Tanggapan Resmi** pada *attachment* (lampiran) email ini. Silakan unduh lampiran berformat PDF tersebut untuk menelaah rincian keputusan dan tanggapan lengkap dari Pejabat Pengelola Informasi dan Dokumentasi (PPID).

Untuk melihat riwayat penanganan laporan Anda secara terintegrasi, Anda dapat mengakses halaman pelacakan pada portal layanan kami:

<x-mail::button :url="url('/lacak')">
Lihat Riwayat di Portal
</x-mail::button>

Kami senantiasa berkomitmen penuh untuk memberikan pelayanan informasi publik yang transparan, akuntabel, dan prima. Apabila terdapat hal-hal yang perlu diklarifikasi, silakan ajukan melalui saluran keberatan atau kontak layanan resmi kami.

Atas perhatian dan kerja sama Anda, kami sampaikan terima kasih.

Hormat kami,

**Pejabat Pengelola Informasi dan Dokumentasi (PPID)**  
{{ settings('site_name', 'Instansi Kami') }}  
_{{ settings('contact_address', '') }}_
</x-mail::message>
