<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-users';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan Sistem';
    }


    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Informasi Pengguna')
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Nama')->required(),
                    Forms\Components\TextInput::make('email')->label('Email')->email()->required()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('password')->label('Password')->password()->dehydrateStateUsing(fn ($state) => bcrypt($state))->dehydrated(fn ($state) => filled($state))->required(fn (string $context) => $context === 'create'),
                    Forms\Components\TextInput::make('nip')->label('NIP')->nullable(),
                    Forms\Components\TextInput::make('jabatan')->label('Jabatan')->nullable(),
                    Forms\Components\TextInput::make('phone')->label('Telepon')->nullable(),
                    Forms\Components\ViewField::make('signature_path')
                        ->label('Tanda Tangan Pejabat Resmi')
                        ->view('filament.forms.components.signature-pad')
                        ->dehydrateStateUsing(function ($state) {
                            if (empty($state)) return null;

                            // Jika state sudah berupa path file yang tersimpan di storage, langsung return
                            if (!str_starts_with($state, 'data:image/png;base64,')) {
                                return $state;
                            }

                            // Decode base64 dan simpan menjadi file PNG transparan resmi
                            $data = explode(',', $state);
                            $decoded = base64_decode($data[1]);

                            $filename = 'signatures/' . uniqid() . '.png';
                            \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $decoded);

                            return $filename;
                        }),
                    Forms\Components\Select::make('roles')->label('Role')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->preload()
                        ->columnSpanFull(),
                ])->columns(1)->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')->badge()->color('primary'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->date('d M Y')->sortable(),
            ])
            ->filters([Tables\Filters\TrashedFilter::make()])
            ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
            ->defaultSort('name')
            ->striped();
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
