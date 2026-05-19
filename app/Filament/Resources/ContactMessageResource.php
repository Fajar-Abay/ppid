<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Pesan Cepat';
    protected static ?string $pluralModelLabel = 'Pesan Cepat (Kontak)';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-chat-bubble-left';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Layanan PPID';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Detail Pesan Cepat')
                ->schema([
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
                ])->columns(2)->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('Cuplikan Pesan')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->message),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()->slideOver(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
        ];
    }
}
