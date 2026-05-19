<?php

declare(strict_types=1);

if (! function_exists('settings')) {
    /**
     * Get a site setting value by key, cached for 24 hours.
     * Sesuai skill.md section 4.1
     */
    function settings(string $key, mixed $default = null): mixed
    {
        return cache()->remember('setting.' . $key, 86400, fn () =>
            \App\Models\Setting::where('key', $key)->first()?->value ?? $default
        );
    }
}

if (! function_exists('settings_clear')) {
    /**
     * Clear the cached value for a given setting key.
     */
    function settings_clear(string $key): void
    {
        cache()->forget('setting.' . $key);
    }
}
