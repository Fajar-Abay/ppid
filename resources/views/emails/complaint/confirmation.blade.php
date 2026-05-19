<x-mail::message>
# Tanda Terima Layanan PPID

Yth. **{{ $complaint->complainant_name }}**,

Bersama surat elektronik ini, kami memberitahukan bahwa permohonan/pengaduan informasi publik yang Anda sampaikan kepada Pejabat Pengelola Informasi dan Dokumentasi (PPID) {{ settings('site_name', 'Instansi Kami') }} telah kami terima dengan baik.

Berikut adalah rincian data permohonan/pengaduan Anda:

<x-mail::panel>
**Kode Registrasi:** {{ $complaint->tracking_code }}  
**Kategori:** {{ ucwords(str_replace('_', ' ', $complaint->category)) }}  
**Perihal:** {{ $complaint->subject }}  
**Tanggal Masuk:** {{ $complaint->submitted_at->format('d F Y, H:i') }} WIB  
</x-mail::panel>

Berkas permohonan Anda akan segera direviu dan diproses oleh tim layanan kami sesuai dengan Standar Operasional Prosedur (SOP) Keterbukaan Informasi Publik yang berlaku. 

Anda dapat memantau status tindak lanjut dari permohonan Anda secara berkala melalui portal resmi kami dengan menggunakan **Kode Registrasi** di atas atau melalui tombol berikut:

<x-mail::button :url="url('/lacak')">
Lacak Status Permohonan
</x-mail::button>

Atas perhatian dan partisipasi aktif Anda dalam mewujudkan keterbukaan informasi, kami sampaikan terima kasih.

Hormat kami,

**Tim Layanan PPID**  
{{ settings('site_name', 'Instansi Kami') }}  
_{{ settings('contact_address', '') }}_
</x-mail::message>
