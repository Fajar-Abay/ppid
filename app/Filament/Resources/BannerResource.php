<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Banner';
    protected static ?string $pluralModelLabel = 'Banner';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-photo';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen Konten';
    }


    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Banner')
                ->schema([
                    Forms\Components\TextInput::make('title')->label('Judul')->required(),
                    Forms\Components\TextInput::make('subtitle')->label('Sub Judul')->nullable(),
                    Forms\Components\Select::make('display_location')->label('Posisi')
                        ->options(['homepage' => 'Beranda', 'sidebar' => 'Sidebar', 'footer' => 'Footer'])
                        ->default('homepage')->required(),
                    Forms\Components\TextInput::make('link_url')->label('URL Link')->nullable(),
                    Forms\Components\TextInput::make('button_text')->label('Teks Tombol')->nullable(),
                    Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('banner_image')
                        ->label('Gambar Banner')
                        ->collection('banner_image')
                        ->image()
                        ->columnSpanFull(),
                ])->columns(1)->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('banner_image')->label('Gambar')->collection('banner_image'),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('display_location')->label('Posisi')->badge(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Urutan')->sortable(),
            ])
            ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
            ->defaultSort('sort_order')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit'   => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
