<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasUlids;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    /**
     * Get setting value, cast to appropriate type.
     */
    public function getTypedValueAttribute(): mixed
    {
        return match($this->type) {
            'boolean' => (bool) $this->value,
            'json'    => json_decode((string) $this->value, true),
            default   => $this->value,
        };
    }

    protected static function booted(): void
    {
        static::saved(function (Setting $setting) {
            \Illuminate\Support\Facades\Cache::forget('setting.' . $setting->key);
        });

        static::deleted(function (Setting $setting) {
            \Illuminate\Support\Facades\Cache::forget('setting.' . $setting->key);
        });
    }
}
