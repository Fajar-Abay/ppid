<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Berita / Artikel';
    protected static ?string $pluralModelLabel = 'Berita';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-newspaper';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Publikasi & Informasi';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Informasi Berita')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Berita')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state ?? '')) : null)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('content')
                        ->label('Isi Berita')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                        ->label('Gambar Utama (Cover)')
                        ->collection('posts')
                        ->image()
                        ->disk('public')
                        ->columnSpanFull(),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Tanggal Terbit')
                        ->default(now())
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('is_published')
                        ->label('Tampilkan ke Publik')
                        ->default(true)
                        ->columnSpanFull(),
                ])->columns(1)->columnSpan('full'),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('posts')
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Terbit Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Status Publikasi'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
