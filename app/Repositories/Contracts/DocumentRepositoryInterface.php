<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Document;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DocumentRepositoryInterface
{
    public function findBySlug(string $slug): ?Document;
    public function getPublishedByCategory(string $categoryId, int $perPage = 12): LengthAwarePaginator;
    public function search(string $keyword, int $perPage = 12): LengthAwarePaginator;
    public function incrementDownload(Document $document): void;
}
