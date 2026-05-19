<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPostsTable extends BaseWidget
{
    protected static ?string $heading = 'Berita & Publikasi Terbaru';
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->can('ViewAny:Post') ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Berita')
                    ->limit(55)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status Rilis')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Belum dirilis'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                \Filament\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-m-pencil')
                    ->url(fn (Post $record): string => \App\Filament\Resources\PostResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
