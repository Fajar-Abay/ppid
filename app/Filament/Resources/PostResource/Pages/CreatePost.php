<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }
}
