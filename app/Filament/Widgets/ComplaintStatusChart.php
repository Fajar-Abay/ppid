<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Complaint;
use App\Enums\ComplaintStatus;
use Filament\Widgets\ChartWidget;

class ComplaintStatusChart extends ChartWidget
{
    protected ?string $heading = 'Status Pengaduan & Permohonan';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 1;

    public static function canView(): bool
    {
        return auth()->user()?->can('ViewAny:Complaint') ?? false;
    }

    protected function getData(): array
    {
        $statuses = ComplaintStatus::cases();
        $labels = [];
        $data = [];
        $backgroundColors = [
            '#eab308', // warning / yellow (Pending)
            '#06b6d4', // info / cyan (Processing)
            '#10b981', // success / emerald (Approved)
            '#ef4444', // danger / red (Rejected)
            '#3b82f6', // primary / blue (Completed)
        ];

        foreach ($statuses as $status) {
            $labels[] = $status->label();
            $data[] = Complaint::where('status', $status->value)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengaduan',
                    'data' => $data,
                    'backgroundColor' => array_slice($backgroundColors, 0, count($statuses)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
