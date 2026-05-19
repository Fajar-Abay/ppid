# Portal PPID (Pejabat Pengelola Informasi dan Dokumentasi)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-FFA500?style=for-the-badge&logo=filament&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

Sistem Informasi Portal PPID (Pejabat Pengelola Informasi dan Dokumentasi) merupakan platform digital terpadu yang dirancang untuk instansi pemerintah guna mewujudkan keterbukaan informasi publik. Sistem ini memfasilitasi pengelolaan konten informasi, pelayanan permohonan informasi (surat menyurat), serta penanganan pengaduan masyarakat secara transparan, efektif, dan efisien.

Sistem ini terbagi menjadi dua bagian utama:
1. **Public Portal (Frontend):** Antarmuka publik yang informatif, responsif, dan mudah diakses oleh masyarakat umum.
2. **Admin Dashboard (Backend/CMS):** Panel kontrol komprehensif berbasis Filament PHP untuk mengelola seluruh aspek portal.

---

## ✨ Fitur Utama (Core Features)

### 📢 Portal Publik (Frontend)
- **Halaman Informasi Statis:** Profil Instansi, Visi Misi, Tugas & Fungsi (Tupoksi), Struktur Organisasi.
- **Berita & Artikel:** Publikasi berita, pengumuman, dan artikel terbaru mengenai kegiatan instansi.
- **Layanan Pengaduan (Complaint Tracker):** Masyarakat dapat mengirimkan aduan/laporan dan melacak status penyelesaian aduan tersebut secara *real-time* (dengan integrasi notifikasi email).
- **Formulir Kontak:** Fasilitas bagi masyarakat untuk mengirimkan pesan atau pertanyaan umum (Contact Messages).
- **Desain Responsif:** Tampilan yang dioptimalkan untuk berbagai ukuran layar (Desktop, Tablet, Mobile) dengan estetika modern.

### ⚙️ Sistem Manajemen (Admin Filament Panel)
- **Manajemen Pengaduan (Complaint Management):** Review, verifikasi, dan tindak lanjut aduan masyarakat beserta perubahan status (*Pending, Processing, Resolved, Rejected*).
- **Manajemen Surat (Letter Management):** Pencatatan dan pengelolaan permohonan informasi/surat-menyurat secara digital menggunakan sistem *template*.
- **Manajemen Konten (Posts/Berita):** Pengelolaan penuh (CRUD) untuk artikel dan berita instansi yang akan tampil di portal.
- **Manajemen Halaman & Banner:** Mengontrol tampilan visual website termasuk *slider/banner* dan pengaturan elemen situs.
- **Manajemen Pesan Kontak:** Inbox terpusat untuk membaca dan membalas pesan dari halaman *Contact Us*.
- **Role & Permission System (RBAC):** Kontrol akses hierarkis yang ketat (Super Admin, Admin, Staff, dll.) menggunakan *Spatie Permission*, memastikan setiap user hanya mengakses fitur sesuai wewenangnya.
- **Pengaturan Sistem (Settings):** Konfigurasi dinamis untuk variabel aplikasi tanpa perlu mengubah kode.

---

## 🛠️ Teknologi yang Digunakan (Tech Stack)

Sistem ini dibangun menggunakan teknologi web modern dan teruji:

- **Framework:** [Laravel 11.x](https://laravel.com/)
- **Admin Panel:** [Filament PHP 3.x](https://filamentphp.com/) (TALL Stack)
- **Frontend Interactivity:** [Livewire 3.x](https://livewire.laravel.com/) & [Alpine.js](https://alpinejs.dev/)
- **Styling:** [Tailwind CSS 3.x](https://tailwindcss.com/)
- **Database:** MySQL / PostgreSQL
- **Role Management:** [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)

---

## 📋 Persyaratan Sistem (Requirements)

Pastikan lingkungan server lokal Anda memenuhi spesifikasi berikut:
- PHP ^8.5
- Composer
- MySQL 8.0+ atau PostgreSQL 14+
- Node.js & NPM (untuk *compile assets*)

---

## 🚀 Panduan Instalasi (Installation Guide)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek secara lokal:

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd ppid
   ```

2. **Install Dependensi PHP (Composer)**
   ```bash
   composer install
   ```

3. **Install Dependensi Node (NPM)**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Duplikat file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi Database, Mailer (untuk notifikasi email), dan URL.
   ```bash
   cp .env.example .env
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database & Seeding**
   Jalankan migrasi untuk membuat tabel dan jalankan *seeder* untuk mengisi data awal (Role, Permission, Akun Admin, Template, dll).
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Link Storage**
   (Penting untuk menampilkan gambar unggahan pada artikel/banner).
   ```bash
   php artisan storage:link
   ```

8. **Build Assets Frontend**
   ```bash
   npm run build
   # atau untuk mode development:
   npm run dev
   ```

9. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Aplikasi publik dapat diakses di `http://localhost:8000`
   Admin panel dapat diakses di `http://localhost:8000/admin` (atau *path* custom yang dikonfigurasi).

---

## 🔐 Kredensial Default

Setelah menjalankan `php artisan migrate:fresh --seed`, gunakan kredensial berikut untuk login ke panel admin (sesuaikan jika diubah pada `DatabaseSeeder`):

- **Email:** `admin@admin.com` (atau cek di *seeder*)
- **Password:** `password`

---

## 📂 Struktur Utama Proyek

- `app/Filament/Resources/`: Konfigurasi halaman dan antarmuka manajemen untuk panel admin Filament (Posts, Complaints, Letters, Users, dll).
- `app/Livewire/`: Komponen interaktif frontend (contoh: `ComplaintTracker.php`).
- `app/Models/`: Definisi Eloquent ORM untuk tabel database (`Complaint.php`, `Letter.php`, `Category.php`, dll).
- `app/Policies/`: Aturan otorisasi hak akses (*Policy*) untuk modul-modul Filament.
- `database/migrations/`: Skema struktur database.
- `database/seeders/`: Data bawaan untuk sistem (Roles, Permissions, Dummy Content).
- `resources/views/`: Layout dan halaman untuk antarmuka publik (`pages/ppid/tugas-fungsi.blade.php`, email *templates*, dll).

---

## 🤝 Kontribusi (Contributing)

Jika Anda developer yang ditugaskan dalam proyek ini:
1. Pastikan selalu membuat *branch* baru untuk fitur atau perbaikan *bug*.
2. Patuhi standar pengkodean (PSR-12).
3. Buat *Commit Message* yang jelas dan terstruktur.

---

## 📄 Lisensi

Hak cipta dilindungi undang-undang. Sistem ini dikembangkan secara spesifik untuk instansi terkait.
