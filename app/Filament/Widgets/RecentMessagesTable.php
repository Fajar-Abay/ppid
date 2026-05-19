<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentMessagesTable extends BaseWidget
{
    protected static ?string $heading = 'Pesan Cepat & Masukan Terbaru';
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->can('ViewAny:ContactMessage') ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->limit(25),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->limit(30),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('message')
                    ->label('Cuplikan Pesan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()
                    ->slideOver()
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->placeholder('-')
                            ->disabled(),
                        Forms\Components\Textarea::make('message')
                            ->label('Isi Pesan')
                            ->rows(6)
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Dikirim Pada')
                            ->disabled(),
                    ]),
            ]);
    }
}
