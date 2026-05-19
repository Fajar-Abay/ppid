<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;

class CustomProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getCurrentPasswordFormComponent(),
                
                TextInput::make('nip')
                    ->label('NIP')
                    ->maxLength(255),
                    
                TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->maxLength(255),
                    
                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->maxLength(255),
                    
                \Filament\Forms\Components\ViewField::make('signature_path')
                    ->label('Tanda Tangan Pejabat Resmi (Digambar)')
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
                    })
                    ->helperText('Gambar tanda tangan Anda secara langsung di atas, atau biarkan jika tidak ingin mengubah.'),
            ]);
    }
}
