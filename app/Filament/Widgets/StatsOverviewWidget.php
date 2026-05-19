<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Complaint;
use App\Models\Document;
use App\Models\ContactMessage;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user?->can('ViewAny:Complaint') 
            || $user?->can('ViewAny:ContactMessage') 
            || $user?->can('ViewAny:Document') 
            || $user?->can('ViewAny:Post') 
            ?? false;
    }

    protected function getStats(): array
    {
        $stats = [];
        $user = auth()->user();

        if ($user?->can('ViewAny:Complaint')) {
            $totalComplaints = Complaint::count();
            $pendingComplaints = Complaint::where('status', 'pending')->count();

            $stats[] = Stat::make('Pengaduan/Permohonan', $totalComplaints)
                ->description('Semua pengaduan masuk')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary');

            $stats[] = Stat::make('Pengaduan Baru (Menunggu)', $pendingComplaints)
                ->description($pendingComplaints > 0 ? 'Perlu respon segera' : 'Bersih dari antrean')
                ->descriptionIcon($pendingComplaints > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($pendingComplaints > 0 ? 'warning' : 'success');
        }

        if ($user?->can('ViewAny:ContactMessage')) {
            $quickMessages = ContactMessage::count();
            $stats[] = Stat::make('Pesan Cepat Baru', $quickMessages)
                ->description('Masukan/pertanyaan ringan')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('info');
        }

        if ($user?->can('ViewAny:Document')) {
            $stats[] = Stat::make('Dokumen Publik', Document::published()->count())
                ->description('Tersedia untuk publik')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('success');
        }

        if ($user?->can('ViewAny:Post')) {
            $stats[] = Stat::make('Berita & Artikel', Post::count())
                ->description('Telah diterbitkan ke publik')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary');
        }

        return $stats;
    }
}
