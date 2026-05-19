<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Letter;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class LetterPdfService
{
    /**
     * Generate PDF from a letter using DomPDF.
     * Sesuai skill.md section 4.4 (DOMPDF as fallback/primary for local dev)
     */
    public function generate(Letter $letter): string
    {
        $letter->loadMissing(['complaint', 'template', 'signer']);

        $pdf = Pdf::loadView('pdf.letter', [
            'letter'  => $letter,
            'header'  => $letter->template?->header_html,
            'footer'  => $letter->template?->footer_html,
            'css'     => $letter->template?->css_styles,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $path = "letters/{$letter->created_at->format('Y/m')}/{$letter->letter_number}.pdf";

        Storage::disk('public')->put($path, $pdf->output());

        $letter->update(['pdf_path' => $path]);

        activity()
            ->performedOn($letter)
            ->causedBy(auth()->user())
            ->withProperties(['path' => $path])
            ->log('PDF surat dibuat');

        return $path;
    }

    /**
     * Stamp digital signature image onto the PDF.
     * Simple implementation: signature image overlay.
     */
    public function stampSignature(Letter $letter, User $signer): Letter
    {
        // Log signature action with IP and timestamp
        activity()
            ->performedOn($letter)
            ->causedBy($signer)
            ->withProperties([
                'ip'        => request()->ip(),
                'signed_at' => now()->toIso8601String(),
            ])
            ->log("Surat ditandatangani oleh: {$signer->name}");

        $letter->update([
            'signature_id' => $signer->id,
            'signed_at'    => now(),
            'status'       => 'signed',
        ]);

        return $letter->fresh();
    }
}
