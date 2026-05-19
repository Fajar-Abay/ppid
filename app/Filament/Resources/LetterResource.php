<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\LetterStatus;
use App\Filament\Resources\LetterResource\Pages;
use App\Models\Letter;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LetterResource extends Resource
{
    protected static ?string $model = Letter::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Surat Balasan';
    protected static ?string $pluralModelLabel = 'Surat Balasan';

    public static function getNavigationIcon(): string|\BackedEnum|\Illuminate\Contracts\Support\Htmlable|null
    {
        return 'heroicon-o-envelope';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Layanan PPID';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Detail Surat')
                ->schema([
                    Forms\Components\Select::make('complaint_id')
                        ->label('Pengaduan')
                        ->relationship('complaint', 'tracking_code')
                        ->required()
                        ->searchable()
                        ->default(fn () => request()->query('complaint_id'))
                        ->live()
                        ->afterStateUpdated(function ($get, $set, ?string $state) {
                            if (!$state) return;
                            
                            $templateId = $get('template_id');
                            if (!$templateId) return;

                            $template = \App\Models\LetterTemplate::find($templateId);
                            $complaint = \App\Models\Complaint::find($state);
                            if (!$template || !$complaint) return;

                            $placeholders = [
                                '{tracking_code}' => $complaint->tracking_code,
                                '{ticket_number}' => $complaint->tracking_code,
                                '{complainant_name}' => $complaint->complainant_name,
                                '{applicant_name}' => $complaint->complainant_name,
                                '{complainant_email}' => $complaint->complainant_email,
                                '{complainant_phone}' => $complaint->complainant_phone,
                                '{complainant_address}' => $complaint->complainant_address,
                                '{subject}' => $complaint->subject,
                                '{complaint_subject}' => $complaint->subject,
                                '{category}' => ucwords(str_replace('_', ' ', $complaint->category)),
                                '{submitted_at}' => $complaint->submitted_at ? $complaint->submitted_at->format('d F Y') : now()->format('d F Y'),
                                '{response_text}' => '(Silakan tulis detail tanggapan atau dasar keputusan dinas di sini)',
                            ];

                            $set('subject', str_replace(array_keys($placeholders), array_values($placeholders), $template->subject_template));
                            $set('body', str_replace(array_keys($placeholders), array_values($placeholders), $template->body_template));
                        }),
                    Forms\Components\Select::make('template_id')
                        ->label('Template')
                        ->options(fn () => \App\Models\LetterTemplate::where('is_active', true)->pluck('name', 'id'))
                        ->nullable()
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function ($get, $set, ?string $state) {
                            if (!$state) return;

                            $template = \App\Models\LetterTemplate::find($state);
                            $complaintId = $get('complaint_id');
                            if (!$complaintId) return;

                            $complaint = \App\Models\Complaint::find($complaintId);
                            if (!$template || !$complaint) return;

                            $placeholders = [
                                '{tracking_code}' => $complaint->tracking_code,
                                '{ticket_number}' => $complaint->tracking_code,
                                '{complainant_name}' => $complaint->complainant_name,
                                '{applicant_name}' => $complaint->complainant_name,
                                '{complainant_email}' => $complaint->complainant_email,
                                '{complainant_phone}' => $complaint->complainant_phone,
                                '{complainant_address}' => $complaint->complainant_address,
                                '{subject}' => $complaint->subject,
                                '{complaint_subject}' => $complaint->subject,
                                '{category}' => ucwords(str_replace('_', ' ', $complaint->category)),
                                '{submitted_at}' => $complaint->submitted_at ? $complaint->submitted_at->format('d F Y') : now()->format('d F Y'),
                                '{response_text}' => '(Silakan tulis detail tanggapan atau dasar keputusan dinas di sini)',
                            ];

                            $set('subject', str_replace(array_keys($placeholders), array_values($placeholders), $template->subject_template));
                            $set('body', str_replace(array_keys($placeholders), array_values($placeholders), $template->body_template));
                        }),
                    Forms\Components\Placeholder::make('template_variables_hint')
                        ->label('Panduan Variabel Surat')
                        ->content(new \Illuminate\Support\HtmlString('
                            <div class="p-3 text-xs bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                                <span class="font-bold text-gray-700 dark:text-gray-300">💡 Variabel Pintasan (Placeholders) yang bisa disematkan di Template:</span>
                                <div class="grid grid-cols-2 gap-2 mt-2 font-mono text-primary-600 dark:text-primary-400">
                                    <div>{ticket_number} / {tracking_code} : No. Tiket / Kode Lacak</div>
                                    <div>{applicant_name} / {complainant_name} : Nama Pengadu</div>
                                    <div>{complaint_subject} / {subject} : Perihal Laporan</div>
                                    <div>{response_text} : Kolom Tanggapan Khusus</div>
                                    <div>{complainant_email} : Email Pengadu</div>
                                    <div>{complainant_phone} : Telepon Pengadu</div>
                                    <div>{complainant_address} : Alamat Pengadu</div>
                                    <div>{submitted_at} : Tanggal Masuk</div>
                                </div>
                            </div>
                        '))
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('letter_number')
                        ->label('Nomor Surat')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->live(debounce: 500),
                    Forms\Components\Select::make('status')->label('Status')
                        ->options(collect(LetterStatus::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))
                        ->default(LetterStatus::Draft->value)->required(),
                    Forms\Components\TextInput::make('subject')
                        ->label('Subjek')
                        ->required()
                        ->columnSpanFull()
                        ->live(debounce: 500),
                    Forms\Components\RichEditor::make('body')
                        ->label('Isi Surat')
                        ->required()
                        ->columnSpanFull()
                        ->live(debounce: 500),
                    Forms\Components\FileUpload::make('attachments')
                        ->label('Lampiran Surat')
                        ->multiple()
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->directory('letter-attachments')
                        ->maxSize(5120)
                        ->columnSpanFull()
                        ->helperText('Unggah file lampiran jika ada (maks. 5MB per file).'),

                    // Panel Pratinjau Live Kertas Surat Resmi A4
                    Forms\Components\Placeholder::make('letter_preview')
                        ->label('Pratinjau Live Surat Dinas Resmi (A4 Layout)')
                        ->content(function ($get, ?Letter $record) {
                            $templateId = $get('template_id');
                            $subject = $get('subject') ?: '<span class="italic text-gray-400">(Belum diisi)</span>';
                            $body = $get('body') ?: '<p class="italic text-gray-400">(Silakan isi badan surat balasan untuk melihat pratinjau teks)</p>';
                            $letterNumber = $get('letter_number') ?: '.../PPID/PEMDA/' . now()->format('Y');

                            $headerHtml = '';
                            $footerHtml = '';

                            if ($templateId) {
                                $template = \App\Models\LetterTemplate::find($templateId);
                                if ($template) {
                                    $headerHtml = $template->header_html;
                                    $footerHtml = $template->footer_html;
                                }
                            }

                            if (empty($headerHtml)) {
                                $headerHtml = '
                                <div style="text-align: center; border-bottom: 3px double #0f172a; padding-bottom: 12px; margin-bottom: 20px;">
                                    <h2 style="margin: 0; font-size: 13px; font-weight: bold; text-transform: uppercase; color: #000;">PEMERINTAH DAERAH PROVINSI / KOTA</h2>
                                    <h1 style="margin: 4px 0 0 0; font-size: 16px; font-weight: bold; text-transform: uppercase; color: #1e3a8a;">PEJABAT PENGELOLA INFORMASI DAN DOKUMENTASI (PPID)</h1>
                                    <p style="margin: 4px 0 0 0; font-size: 9px; color: #475569; font-style: italic;">Pusat Layanan Keterbukaan Informasi Publik Satu Pintu</p>
                                </div>';
                            }

                            if (empty($footerHtml)) {
                                $footerHtml = '
                                <div style="margin-top: 30px; padding-top: 12px; border-top: 1px solid #cbd5e1; text-align: center; font-size: 10px; color: #64748b;">
                                    Keterbukaan Informasi Publik adalah Pilar Utama Demokrasi
                                </div>';
                            }

                            // 1. Dapatkan Profil Penandatangan Secara Dinamis
                            $signerName = 'NAMA PEJABAT PPID';
                            $signerNip = '--------------------';
                            $signerJabatan = 'PPID UTAMA PELAKSANA';
                            $signedAt = null;

                            if ($record && $record->signer) {
                                $signerName = $record->signer->name;
                                $signerNip = $record->signer->nip ?: '--------------------';
                                $signerJabatan = $record->signer->jabatan ?: 'PPID UTAMA PELAKSANA';
                                $signedAt = $record->signed_at;
                            } else {
                                // Jika draf / baru dibuat, arahkan ke data pejabat yang sedang aktif login
                                $user = auth()->user();
                                if ($user) {
                                    $signerName = $user->name;
                                    $signerNip = $user->nip ?: '--------------------';
                                    $signerJabatan = $user->jabatan ?: 'PPID UTAMA PELAKSANA';
                                }
                            }

                            // 2. Rendel Stempel Tanda Tangan Elektronik (TTE) Hijau jika sudah ditandatangani
                            $tteBlockHtml = '';
                            if ($signedAt || ($record && $record->status === LetterStatus::Signed) || ($record && $record->status === LetterStatus::Sent)) {
                                $displayTime = $signedAt ? $signedAt->format('d-m-Y H:i') : now()->format('d-m-Y H:i');
                                
                                $signatureImageHtml = '';
                                $signer = ($record && $record->signer) ? $record->signer : auth()->user();
                                if ($signer && $signer->signature_path) {
                                    $signatureImageHtml = '
                                    <div style="text-align: center; margin-top: -15px; margin-bottom: -5px;">
                                        <img src="/storage/' . $signer->signature_path . '" style="height: 60px; max-width: 160px; object-fit: contain; display: inline-block;" alt="Scan Tanda Tangan">
                                    </div>';
                                }

                                $tteBlockHtml = '
                                <div style="margin: 10px 0; width: 220px; border: 2px dashed #008000; padding: 8px; background-color: #f6fff6; border-radius: 6px; font-family: monospace; font-size: 10.5px;">
                                    <span style="color: #008000; font-weight: bold; display: block; text-transform: uppercase;">
                                        TANDA TANGAN ELEKTRONIK
                                    </span>
                                    <span style="color: #333; display: block; margin-top: 4px; font-family: sans-serif; font-size: 9.5px; line-height: 1.3;">
                                        Ditandatangani oleh:<br>
                                        <strong>' . $signerName . '</strong><br>
                                        Pada: ' . $displayTime . ' WIB
                                    </span>
                                </div>' . $signatureImageHtml;
                            } else {
                                $tteBlockHtml = '
                                <div style="height: 40px; border: 1.5px dashed #cbd5e1; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 10.5px; margin: 10px 0; font-family: sans-serif; font-style: italic; width: 220px; background-color: #fafafa;">
                                    [Belum Ditandatangani secara TTE]
                                </div>';
                            }

                            return new \Illuminate\Support\HtmlString('
                                <div class="w-full p-8 bg-white border border-gray-200 rounded-lg shadow-md max-w-3xl mx-auto dark:bg-slate-900 dark:border-slate-800" style="font-family: \'Times New Roman\', Times, serif; color: #0f172a; min-height: 480px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); margin-top: 16px;">
                                    <!-- Kop Surat -->
                                    <div class="mb-4">' . $headerHtml . '</div>
                                    
                                    <!-- Metadata Kop -->
                                    <div class="mb-6" style="font-size: 13.5px; line-height: 1.5; color: #000;">
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 90px; font-weight: bold; vertical-align: top;">Nomor</td>
                                                <td style="width: 15px; vertical-align: top;">:</td>
                                                <td style="vertical-align: top;">' . $letterNumber . '</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; vertical-align: top;">Sifat</td>
                                                <td style="vertical-align: top;">:</td>
                                                <td style="vertical-align: top;">Segera / Terbatas</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; vertical-align: top;">Hal</td>
                                                <td style="vertical-align: top;">:</td>
                                                <td style="vertical-align: top; font-weight: bold; color: #1e3a8a;">' . $subject . '</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <!-- Tubuh Surat -->
                                    <div class="prose max-w-none text-justify mt-4 dark:text-gray-900" style="font-size: 14px; line-height: 1.6; color: #000;">
                                        ' . $body . '
                                    </div>
                                    
                                    <!-- Tanda Tangan -->
                                    <div class="mt-10 flex justify-end" style="font-size: 13.5px; color: #000;">
                                        <div style="width: 250px; text-align: left;">
                                            <p style="margin-bottom: 5px; margin-top: 0;"><strong>A.n. PEJABAT PENGELOLA INFORMASI</strong></p>
                                            <p style="font-weight: bold; margin: 0; text-transform: uppercase;">' . $signerJabatan . '</p>
                                            
                                            ' . $tteBlockHtml . '
                                            
                                            <p style="margin-top: 10px; line-height: 1.4;">
                                                <u><strong>' . $signerName . '</strong></u><br>
                                                NIP. ' . $signerNip . '
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="mt-8">' . $footerHtml . '</div>
                                </div>
                            ');
                        })
                        ->columnSpanFull(),
                ])->columns(1)->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('letter_number')->label('Nomor Surat')->searchable(),
                Tables\Columns\TextColumn::make('complaint.tracking_code')->label('Kode Pengaduan')->badge()->color('primary'),
                Tables\Columns\TextColumn::make('subject')->label('Subjek')->limit(50),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()
                    ->formatStateUsing(fn ($state) => $state->label()),
                Tables\Columns\TextColumn::make('signed_at')->label('Ditandatangani')->date('d M Y'),
            ])
            ->filters([Tables\Filters\TrashedFilter::make()])
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('signLetter')
                    ->label('Tanda Tangan')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Tanda Tangani Surat secara Elektronik?')
                    ->modalDescription('Apakah Anda yakin ingin menandatangani surat tanggapan ini secara resmi menggunakan Tanda Tangan Elektronik (TTE) akun Anda?')
                    ->action(function (Letter $record, \App\Services\LetterPdfService $service) {
                        $user = auth()->user();
                        
                        // Periksa apakah pengguna sudah memiliki tanda tangan
                        if (empty($user->signature_path)) {
                            \Filament\Notifications\Notification::make()
                                ->title('Tanda Tangan Gagal!')
                                ->body('Anda belum memiliki tanda tangan elektronik yang tersimpan. Silakan unggah tanda tangan terlebih dahulu pada profil/pengaturan Anda.')
                                ->danger()
                                ->send();
                            return;
                        }

                        // Terapkan tanda tangan elektronik pejabat yang login
                        $service->stampSignature($record, $user);
                        
                        // Hasilkan ulang berkas PDF terbaru yang memuat stempel TTE
                        $service->generate($record);

                        \Filament\Notifications\Notification::make()
                            ->title('Surat Berhasil Ditandatangani!')
                            ->body('Dokumen resmi surat tanggapan telah berhasil ditandatangani secara elektronik (TTE) atas nama Anda.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Letter $record): bool => $record->status === LetterStatus::Draft),
                \Filament\Actions\Action::make('sendEmail')
                    ->label('Kirim Email')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Surat Balasan ke Pemohon?')
                    ->modalDescription('Apakah Anda yakin ingin secara resmi mengirimkan surat tanggapan ini langsung ke alamat email pemohon? Tindakan ini juga akan otomatis mengubah status pengaduan menjadi Selesai.')
                    ->action(function (Letter $record, \App\Services\NotificationService $service, \App\Services\LetterPdfService $pdfService) {
                        // 1. Otomatis buat PDF resmi jika belum digenerate sebelumnya
                        if (!$record->pdf_path) {
                            $pdfService->generate($record);
                        }

                        // 2. Hubungkan surat tanggapan ke pengaduan dan tandai status selesai
                        $complaint = $record->complaint;
                        $complaint->update([
                            'response_letter_id' => $record->id,
                            'status'             => \App\Enums\ComplaintStatus::Completed,
                        ]);

                        // 3. Picu pengiriman email resmi lengkap dengan lampiran PDF Kop Surat ganda
                        $service->sendLetterToComplainant($complaint);

                        // 4. Perbarui status surat menjadi Sent (Dikirim)
                        $record->update(['status' => LetterStatus::Sent]);

                        \Filament\Notifications\Notification::make()
                            ->title('Surat Resmi Berhasil Dikirim!')
                            ->body("Surat tanggapan telah sukses dikirim ke alamat email pemohon: {$complaint->complainant_email}")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Letter $record): bool => $record->status === LetterStatus::Draft || $record->status === LetterStatus::Signed),
                \Filament\Actions\Action::make('downloadPdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->action(function (Letter $record, \App\Services\LetterPdfService $service) {
                        // Hasilkan / perbarui berkas PDF versi terbaru di server
                        $path = $service->generate($record);
                        
                        // Buat nama berkas unduhan yang aman dari karakter path / dan \
                        $safeFilename = str_replace(['/', '\\'], '_', $record->letter_number);
                        
                        // Kembalikan respons unduhan resmi Laravel untuk diunduh langsung oleh browser
                        return \Illuminate\Support\Facades\Storage::disk('public')->download($path, "Surat_Balasan_{$safeFilename}.pdf");
                    })
                    ->visible(fn (Letter $record): bool => $record->status === LetterStatus::Signed || $record->status === LetterStatus::Sent),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLetters::route('/'),
            'create' => Pages\CreateLetter::route('/create'),
            'edit'   => Pages\EditLetter::route('/{record}/edit'),
        ];
    }
}
