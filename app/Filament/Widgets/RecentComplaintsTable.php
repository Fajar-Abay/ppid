<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Complaint;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentComplaintsTable extends BaseWidget
{
    protected static ?string $heading = 'Pengaduan & Permohonan Terbaru (Menunggu Respon)';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 1;

    public static function canView(): bool
    {
        return auth()->user()?->can('ViewAny:Complaint') ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Complaint::where('status', 'pending')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('tracking_code')
                    ->label('Kode Lacak')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('complainant_name')
                    ->label('Nama Pengadu')
                    ->limit(25),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Subjek')
                    ->limit(40),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'permohonan_informasi' => 'Permohonan Informasi',
                        'pengaduan' => 'Pengaduan',
                        'saran' => 'Saran',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                \Filament\Actions\Action::make('view')
                    ->label('Proses')
                    ->icon('heroicon-m-arrow-right')
                    ->url(fn (Complaint $record): string => \App\Filament\Resources\ComplaintResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
