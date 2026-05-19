<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Complaint;
use App\Services\ComplaintService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class PublicComplaintForm extends Component implements HasForms
{
    use InteractsWithForms;
    use WithFileUploads;

    public ?array $data = [];
    public ?string $trackingCode = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->components([
                \Filament\Schemas\Components\Grid::make(2)
                    ->schema([
                        \Filament\Schemas\Components\Section::make('Data Identitas')
                            ->description('Mohon isi data identitas Anda dengan benar sesuai KTP.')
                            ->schema([
                                Forms\Components\TextInput::make('complainant_name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('complainant_email')
                                    ->label('Email Aktif')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('complainant_phone')
                                    ->label('Nomor Telepon/WA')
                                    ->tel()
                                    ->required(),
                                Forms\Components\Textarea::make('complainant_address')
                                    ->label('Alamat Lengkap')
                                    ->required()
                                    ->columnSpanFull(),
                            ])->columnSpan(1),

                        \Filament\Schemas\Components\Section::make('Isi Pengaduan')
                            ->description('Sampaikan keluhan atau permohonan informasi Anda secara detail.')
                            ->schema([
                                Forms\Components\Select::make('category')
                                    ->label('Kategori')
                                    ->options([
                                        'permohonan_informasi' => 'Permohonan Informasi',
                                        'pengaduan'            => 'Pengaduan',
                                        'saran'                => 'Saran',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('subject')
                                    ->label('Subjek/Perihal')
                                    ->required()
                                    ->maxLength(200),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Lengkap')
                                    ->required()
                                    ->minLength(50)
                                    ->maxLength(5000)
                                    ->rows(6),
                                Forms\Components\FileUpload::make('attachments')
                                    ->label('Lampiran Pendukung')
                                    ->multiple()
                                    ->maxSize(5120) // 5MB
                                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                                    ->helperText('Unggah foto KTP atau dokumen pendukung lainnya (PDF/Gambar).'),
                            ])->columnSpan(1),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(ComplaintService $service): void
    {
        $formData = $this->form->getState();
        
        // Handle attachments separately as Spatie MediaLibrary is used in service
        $attachments = $formData['attachments'] ?? [];
        unset($formData['attachments']);

        $complaint = $service->submit($formData, $attachments);
        
        $this->trackingCode = $complaint->tracking_code;
        
        $this->form->fill();
        
        $this->dispatch('complaint-submitted');
    }

    public function render(): View
    {
        return view('livewire.public-complaint-form');
    }
}
