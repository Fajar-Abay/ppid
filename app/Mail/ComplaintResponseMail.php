<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public \App\Models\Complaint $complaint) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tanggapan Pengaduan: ' . $this->complaint->tracking_code,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.complaint.response',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        $letter = $this->complaint->responseLetter;
        if ($letter) {
            if ($letter->pdf_path) {
                $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorage($letter->pdf_path)
                    ->as('Surat_Tanggapan_' . $this->complaint->tracking_code . '.pdf')
                    ->withMime('application/pdf');
            }
            
            if (is_array($letter->attachments)) {
                foreach ($letter->attachments as $index => $path) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $name = 'Lampiran_' . ($index + 1) . '_' . $this->complaint->tracking_code . '.' . $ext;
                    $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorage($path)
                        ->as($name);
                }
            }
        }

        return $attachments;
    }
}
