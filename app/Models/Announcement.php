<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'file_attachment',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
