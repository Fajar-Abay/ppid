<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Complaint;
use Illuminate\Support\Collection;

interface ComplaintRepositoryInterface
{
    public function findByTrackingCode(string $code): ?Complaint;
    public function create(array $data): Complaint;
    public function updateStatus(Complaint $complaint, string $status, ?int $processorId = null): Complaint;
    public function getPendingCount(): int;
    public function getStatsByPeriod(\DateTime $start, \DateTime $end): Collection;
}
