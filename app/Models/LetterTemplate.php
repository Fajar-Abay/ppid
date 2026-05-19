<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class LetterTemplate extends Model
{
    use HasUlids;
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'subject_template',
        'body_template',
        'header_html',
        'footer_html',
        'css_styles',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function letters(): HasMany
    {
        return $this->hasMany(Letter::class, 'template_id');
    }
}
