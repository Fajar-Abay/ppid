<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Complaint;
use App\Models\Letter;
use App\Repositories\Contracts\ComplaintRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComplaintService
{
    public function __construct(
        private readonly ComplaintRepositoryInterface $repository,
        private readonly NotificationService $notificationService,
        private readonly TrackingCodeService $trackingCodeService,
    ) {}

    public function submit(array $data, array $attachments = []): Complaint
    {
        return DB::transaction(function () use ($data, $attachments) {
            $trackingCode = $this->trackingCodeService->generate();

            $complaint = $this->repository->create([
                'tracking_code'       => $trackingCode,
                'complainant_name'    => $data['complainant_name'],
                'complainant_email'   => $data['complainant_email'],
                'complainant_phone'   => $data['complainant_phone'],
                'complainant_address' => $data['complainant_address'],
                'category'            => $data['category'],
                'subject'             => $data['subject'],
                'description'         => $data['description'],
                'status'              => 'pending',
                'submitted_at'        => now(),
            ]);

            // Store attachments securely
            foreach ($attachments as $attachment) {
                if (is_string($attachment)) {
                    // It's a path on the default disk (public) returned by Filament FileUpload
                    $extension = pathinfo($attachment, PATHINFO_EXTENSION);
                    $complaint->addMediaFromDisk($attachment, 'public')
                        ->usingFileName(Str::uuid()->toString() . ($extension ? '.' . $extension : ''))
                        ->toMediaCollection('attachments', 'private');
                        
                    // Remove the file from the public disk since it's now in private media library
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($attachment);
                } else {
                    // If it's a TemporaryUploadedFile from Livewire
                    $path = method_exists($attachment, 'getRealPath') ? $attachment->getRealPath() : $attachment;
                    $extension = method_exists($attachment, 'getClientOriginalExtension') ? $attachment->getClientOriginalExtension() : '';
                    
                    $complaint->addMedia($path)
                        ->usingFileName(Str::uuid()->toString() . ($extension ? '.' . $extension : ''))
                        ->toMediaCollection('attachments', 'private');
                }
            }

            // Trigger notification
            $this->notificationService->sendComplaintConfirmation($complaint);

            return $complaint;
        });
    }

    public function create(array $data, mixed $ktpFile, array $attachments = []): Complaint
    {
        return DB::transaction(function () use ($data, $ktpFile, $attachments) {
            $trackingCode = $this->trackingCodeService->generate();

            $complaint = $this->repository->create([
                'tracking_code'      => $trackingCode,
                'complainant_name'   => $data['complainantName'],
                'complainant_email'  => $data['complainantEmail'],
                'complainant_phone'  => $data['complainantPhone'],
                'complainant_address' => $data['complainantAddress'],
                'category'           => $data['category'],
                'subject'            => $data['subject'],
                'description'        => $data['description'],
                'status'             => 'pending',
                'submitted_at'       => now(),
            ]);

            // Store KTP securely via Spatie Media Library
            $complaint->addMedia($ktpFile->getRealPath())
                ->usingFileName(Str::uuid()->toString() . '.' . $ktpFile->getClientOriginalExtension())
                ->toMediaCollection('ktp', 'private');

            // Store optional attachments
            foreach ($attachments as $attachment) {
                $complaint->addMedia($attachment->getRealPath())
                    ->usingFileName(Str::uuid()->toString() . '.' . $attachment->getClientOriginalExtension())
                    ->toMediaCollection('attachments', 'private');
            }

            // Trigger confirmation notification
            $this->notificationService->sendComplaintConfirmation($complaint);

            return $complaint;
        });
    }

    public function updateStatus(Complaint $complaint, string $status, ?string $processorId = null): Complaint
    {
        return DB::transaction(function () use ($complaint, $status, $processorId) {
            $updated = $this->repository->updateStatus($complaint, $status, $processorId);

            activity()
                ->performedOn($updated)
                ->causedBy(auth()->user())
                ->withProperties(['status' => $status, 'ip' => request()->ip()])
                ->log("Status complaint diubah menjadi: {$status}");

            return $updated;
        });
    }
}
