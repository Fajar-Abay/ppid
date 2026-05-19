<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Pengaturan';
    protected static ?string $pluralModelLabel = 'Pengaturan Situs';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan Sistem';
    }


    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Pengaturan')
                ->schema([
                    Forms\Components\TextInput::make('key')->label('Key')->required()->unique(ignoreRecord: true)->maxLength(100),
                    Forms\Components\Select::make('group')->label('Grup')
                        ->options(['general' => 'Umum', 'contact' => 'Kontak', 'social' => 'Media Sosial', 'appearance' => 'Tampilan', 'legal' => 'Legal'])
                        ->default('general')->required(),
                    Forms\Components\Select::make('type')->label('Tipe')
                        ->options(['string' => 'String', 'text' => 'Rich Text', 'image' => 'Image', 'boolean' => 'Boolean', 'json' => 'JSON'])
                        ->default('string')
                        ->required()
                        ->live(),
                    Forms\Components\FileUpload::make('value_image')
                        ->label('Unggah Gambar')
                        ->image()
                        ->disk('public')
                        ->directory('settings')
                        ->visible(fn ($get) => $get('type') === 'image')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('value_text')
                        ->label('Nilai Konten')
                        ->visible(fn ($get) => $get('type') === 'text')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('value_string')
                        ->label('Nilai String/Teks')
                        ->visible(fn ($get) => !in_array($get('type'), ['image', 'text']))
                        ->columnSpanFull(),
                ])->columns(1)->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->label('Key')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('group')->label('Grup')->badge(),
                Tables\Columns\TextColumn::make('type')->label('Tipe')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('value')->label('Nilai')->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')->label('Grup')
                    ->options(['general' => 'Umum', 'contact' => 'Kontak', 'social' => 'Media Sosial', 'appearance' => 'Tampilan', 'legal' => 'Legal']),
            ])
            ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
            ->defaultSort('group')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit'   => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
