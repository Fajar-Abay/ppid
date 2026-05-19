<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\LetterTemplateResource\Pages;
use App\Models\LetterTemplate;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class LetterTemplateResource extends Resource
{
    protected static ?string $model = LetterTemplate::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Template Surat';
    protected static ?string $pluralModelLabel = 'Template Surat';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-document-duplicate';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan Sistem';
    }


    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Template Surat')
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Nama Template')->required()->maxLength(255),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    Forms\Components\TextInput::make('subject_template')->label('Template Subjek')->required()->columnSpanFull(),
                    Forms\Components\Textarea::make('header_html')->label('HTML Header')->rows(5)->columnSpanFull(),
                    Forms\Components\RichEditor::make('body_template')->label('Template Isi Surat')->required()->columnSpanFull(),
                    Forms\Components\Textarea::make('footer_html')->label('HTML Footer')->rows(5)->columnSpanFull(),
                    Forms\Components\Textarea::make('css_styles')->label('CSS Custom')->rows(5)->columnSpanFull(),
                ])->columns(1)->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('letters_count')->label('Surat')->counts('letters'),
                Tables\Columns\TextColumn::make('updated_at')->label('Diperbarui')->date('d M Y')->sortable(),
            ])
            ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLetterTemplates::route('/'),
            'create' => Pages\CreateLetterTemplate::route('/create'),
            'edit'   => Pages\EditLetterTemplate::route('/{record}/edit'),
        ];
    }
}
