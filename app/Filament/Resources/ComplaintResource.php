<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ComplaintStatus;
use App\Filament\Resources\ComplaintResource\Pages;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Pengaduan';
    protected static ?string $pluralModelLabel = 'Pengaduan';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-chat-bubble-left-ellipsis';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Layanan PPID';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Identitas Pengadu')
                ->schema([
                    Forms\Components\TextInput::make('complainant_name')->label('Nama')->required()->maxLength(100),
                    Forms\Components\TextInput::make('complainant_email')->label('Email')->email()->required(),
                    Forms\Components\TextInput::make('complainant_phone')->label('Telepon')->required(),
                    Forms\Components\Textarea::make('complainant_address')->label('Alamat')->required()->columnSpanFull(),
                ])->columns(1)->columnSpan('full'),

            \Filament\Schemas\Components\Section::make('Detail Pengaduan')
                ->schema([
                    Forms\Components\Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'permohonan_informasi' => 'Permohonan Informasi',
                            'pengaduan'            => 'Pengaduan',
                            'saran'                => 'Saran',
                        ])->required(),
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options(collect(ComplaintStatus::cases())->mapWithKeys(
                            fn ($case) => [$case->value => $case->label()]
                        ))->required(),
                    Forms\Components\TextInput::make('subject')->label('Subjek')->required()->maxLength(200)->columnSpanFull(),
                    Forms\Components\Textarea::make('description')->label('Deskripsi')->required()->minLength(50)->maxLength(5000)->columnSpanFull(),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('attachments')
                        ->label('Lampiran (KTP/Dokumen)')
                        ->collection('attachments')
                        ->multiple()
                        ->columnSpanFull(),
                ])->columns(1)->columnSpan('full'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Kode Lacak')
                ->schema([
                    Infolists\Components\TextEntry::make('tracking_code')->label('Kode Lacak')->badge()->color('primary'),
                    Infolists\Components\TextEntry::make('status')->label('Status')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->label())
                        ->color(fn ($state): string => $state->color()),
                    Infolists\Components\TextEntry::make('submitted_at')->label('Diterima')->dateTime('d M Y H:i'),
                ])->columns(3),

            \Filament\Schemas\Components\Section::make('Identitas Pengadu')
                ->schema([
                    Infolists\Components\TextEntry::make('complainant_name')->label('Nama'),
                    Infolists\Components\TextEntry::make('complainant_email')->label('Email'),
                    Infolists\Components\TextEntry::make('complainant_phone')->label('Telepon'),
                    Infolists\Components\TextEntry::make('complainant_address')->label('Alamat')->columnSpanFull(),
                ])->columns(3),

            \Filament\Schemas\Components\Section::make('Detail')
                ->schema([
                    Infolists\Components\TextEntry::make('subject')->label('Subjek')->columnSpanFull(),
                    Infolists\Components\TextEntry::make('description')->label('Deskripsi')->columnSpanFull(),
                    Infolists\Components\RepeatableEntry::make('media')
                        ->label('Lampiran Dokumen (Upload)')
                        ->schema([
                            Infolists\Components\TextEntry::make('file_name')
                                ->label('Nama File')
                                ->suffixAction(
                                    \Filament\Actions\Action::make('download')
                                        ->label('Download/Lihat')
                                        ->icon('heroicon-o-document-arrow-down')
                                        ->action(function ($record) {
                                            return response()->download($record->getPath(), $record->file_name);
                                        })
                                )
                                ->color('primary'),
                            Infolists\Components\TextEntry::make('human_readable_size')
                                ->label('Ukuran'),
                        ])
                        ->columns(2)
                        ->visible(fn ($record) => $record->media->count() > 0),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tracking_code')->label('Kode Lacak')->searchable()->badge()->color('primary'),
                Tables\Columns\TextColumn::make('complainant_name')->label('Nama Pengadu')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->badge(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->color(fn ($state): string => $state->color()),
                Tables\Columns\TextColumn::make('submitted_at')->label('Tanggal')->date('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Status')
                    ->options(collect(ComplaintStatus::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
                Tables\Filters\SelectFilter::make('category')->label('Kategori')
                    ->options(['permohonan_informasi' => 'Permohonan Informasi', 'pengaduan' => 'Pengaduan', 'saran' => 'Saran']),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('createLetter')
                    ->label('Buat Balasan')
                    ->icon('heroicon-o-pencil-square')
                    ->color('success')
                    ->url(fn (Complaint $record): string => LetterResource::getUrl('create', ['complaint_id' => $record->id]))
                    ->visible(fn (Complaint $record): bool => $record->status !== ComplaintStatus::Completed),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()]),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->striped();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListComplaints::route('/'),
            'view'   => Pages\ViewComplaint::route('/{record}'),
            'edit'   => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
