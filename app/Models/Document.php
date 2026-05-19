<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DocumentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Document extends Model implements HasMedia
{
    use HasUlids;
    use HasSlug;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'download_count',
        'published_at',
        'expired_at',
        'status',
        'meta_keywords',
        'created_by',
    ];

    protected $casts = [
        'status'         => DocumentStatus::class,
        'download_count' => 'integer',
        'published_at'   => 'datetime',
        'expired_at'     => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')
            ->singleFile();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: only published documents.
     */
    public function scopePublished($query)
    {
        return $query->where('status', DocumentStatus::Published)
            ->where('published_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            });
    }
}
