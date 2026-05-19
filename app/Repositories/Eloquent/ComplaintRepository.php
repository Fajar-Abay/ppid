<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Repositories\Contracts\ComplaintRepositoryInterface;
use Illuminate\Support\Collection;

class ComplaintRepository implements ComplaintRepositoryInterface
{
    public function __construct(private readonly Complaint $model) {}

    public function findByTrackingCode(string $code): ?Complaint
    {
        return $this->model
            ->where('tracking_code', $code)
            ->first();
    }

    public function create(array $data): Complaint
    {
        return $this->model->create($data);
    }

    public function updateStatus(Complaint $complaint, string $status, ?int $processorId = null): Complaint
    {
        $complaint->update([
            'status'       => $status,
            'processed_by' => $processorId ?? $complaint->processed_by,
            'processed_at' => now(),
        ]);

        return $complaint->fresh();
    }

    public function getPendingCount(): int
    {
        return $this->model->where('status', ComplaintStatus::Pending)->count();
    }

    public function getStatsByPeriod(\DateTime $start, \DateTime $end): Collection
    {
        return $this->model
            ->whereBetween('submitted_at', [$start, $end])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();
    }
}
