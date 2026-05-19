<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Complaint;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send a complaint confirmation email with tracking code.
     */
    public function sendComplaintConfirmation(Complaint $complaint): void
    {
        try {
            Mail::to($complaint->complainant_email)
                ->send(new \App\Mail\ComplaintConfirmationMail($complaint));

            Log::info('Complaint confirmation queued', [
                'tracking_code' => $complaint->tracking_code,
                'email'         => $complaint->complainant_email,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send complaint confirmation', [
                'tracking_code' => $complaint->tracking_code,
                'error'         => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send letter PDF to complainant via email.
     */
    public function sendLetterToComplainant(Complaint $complaint): void
    {
        try {
            Mail::to($complaint->complainant_email)
                ->send(new \App\Mail\ComplaintResponseMail($complaint));

            Log::info('Letter sent to complainant', [
                'tracking_code' => $complaint->tracking_code,
                'email'         => $complaint->complainant_email,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send letter to complainant', [
                'tracking_code' => $complaint->tracking_code,
                'error'         => $e->getMessage(),
            ]);
        }
    }
}
