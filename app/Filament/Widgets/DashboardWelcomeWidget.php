<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardWelcomeWidget extends Widget
{
    protected static ?int $sort = 0; // Tampil di baris pertama paling atas
    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.dashboard-welcome';

    public function getShortcuts(): array
    {
        $shortcuts = [];
        $user = auth()->user();

        if ($user?->can('ViewAny:Complaint')) {
            $shortcuts[] = [
                'title' => 'Pengaduan & Permohonan',
                'description' => 'Kelola laporan masuk dan permohonan informasi publik.',
                'icon' => 'complaint',
                'url' => \App\Filament\Resources\ComplaintResource::getUrl('index'),
                'color' => 'primary',
            ];
        }

        if ($user?->can('ViewAny:ContactMessage')) {
            $shortcuts[] = [
                'title' => 'Pesan Cepat',
                'description' => 'Baca masukan, saran, dan kontak cepat dari publik.',
                'icon' => 'message',
                'url' => \App\Filament\Resources\ContactMessageResource::getUrl('index'),
                'color' => 'info',
            ];
        }

        if ($user?->can('ViewAny:Post')) {
            $shortcuts[] = [
                'title' => 'Berita & Publikasi',
                'description' => 'Terbitkan kabar berita, agenda instansi, & pengumuman.',
                'icon' => 'news',
                'url' => \App\Filament\Resources\PostResource::getUrl('index'),
                'color' => 'warning',
            ];
        }

        if ($user?->can('ViewAny:Document')) {
            $shortcuts[] = [
                'title' => 'Pusat Dokumen',
                'description' => 'Unggah, klasifikasi, dan kelola dokumen publik.',
                'icon' => 'document',
                'url' => \App\Filament\Resources\DocumentResource::getUrl('index'),
                'color' => 'success',
            ];
        }

        if ($user?->can('ViewAny:Letter')) {
            $shortcuts[] = [
                'title' => 'Manajemen Surat',
                'description' => 'Cetak surat resmi keputusan PPID secara sistematis.',
                'icon' => 'letter',
                'url' => \App\Filament\Resources\LetterResource::getUrl('index'),
                'color' => 'primary',
            ];
        }

        if ($user?->can('ViewAny:User')) {
            $shortcuts[] = [
                'title' => 'Kelola Staff & Akses',
                'description' => 'Mengatur akun staff, kewenangan, dan hak akses sistem.',
                'icon' => 'user',
                'url' => \App\Filament\Resources\UserResource::getUrl('index'),
                'color' => 'danger',
            ];
        }

        if ($user?->can('ViewAny:Setting')) {
            $shortcuts[] = [
                'title' => 'Konfigurasi Portal',
                'description' => 'Kelola alamat, telepon, maps embed, dan informasi dasar.',
                'icon' => 'setting',
                'url' => \App\Filament\Resources\SettingResource::getUrl('index'),
                'color' => 'success',
            ];
        }

        return $shortcuts;
    }
}
