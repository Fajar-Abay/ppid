<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DocumentCategoryType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasUlids;
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'type'      => DocumentCategoryType::class,
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
