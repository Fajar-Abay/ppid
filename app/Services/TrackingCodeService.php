<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class TrackingCodeService
{
    private const PREFIX = 'PPID';
    private const SEGMENT_LENGTH = 4;

    /**
     * Generate a cryptographically secure tracking code.
     * Format: PPID-XXXX-XXXX (alphanumeric uppercase)
     */
    public function generate(): string
    {
        do {
            $code = self::PREFIX . '-'
                . $this->randomSegment()
                . '-'
                . $this->randomSegment();
        } while (\App\Models\Complaint::where('tracking_code', $code)->exists());

        return $code;
    }

    private function randomSegment(): string
    {
        return strtoupper(Str::random(self::SEGMENT_LENGTH));
    }
}
