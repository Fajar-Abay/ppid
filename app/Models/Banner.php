<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements HasMedia
{
    use HasUlids;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'subtitle',
        'link_url',
        'button_text',
        'sort_order',
        'is_active',
        'display_location',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner_image')->singleFile();
    }
}
