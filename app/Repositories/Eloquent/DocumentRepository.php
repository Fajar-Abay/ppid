<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Document;
use App\Repositories\Contracts\DocumentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DocumentRepository implements DocumentRepositoryInterface
{
    public function __construct(private readonly Document $model) {}

    public function findBySlug(string $slug): ?Document
    {
        return $this->model
            ->with('category')
            ->published()
            ->where('slug', $slug)
            ->first();
    }

    public function getPublishedByCategory(string $categoryId, int $perPage = 12): LengthAwarePaginator
    {
        return $this->model
            ->with('category')
            ->published()
            ->where('category_id', $categoryId)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    public function search(string $keyword, int $perPage = 12): LengthAwarePaginator
    {
        return $this->model
            ->with('category')
            ->published()
            ->whereFullText(['title', 'description'], $keyword)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    public function incrementDownload(Document $document): void
    {
        $document->increment('download_count');
    }
}
