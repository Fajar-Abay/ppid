<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\ComplaintRepositoryInterface;
use App\Repositories\Contracts\DocumentRepositoryInterface;
use App\Repositories\Eloquent\ComplaintRepository;
use App\Repositories\Eloquent\DocumentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ComplaintRepositoryInterface::class, ComplaintRepository::class);
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);
    }
}
