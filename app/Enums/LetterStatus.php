<?php

declare(strict_types=1);

namespace App\Enums;

enum LetterStatus: string
{
    case Draft  = 'draft';
    case Signed = 'signed';
    case Sent   = 'sent';

    public function label(): string
    {
        return match($this) {
            self::Draft  => 'Draft',
            self::Signed => 'Ditandatangani',
            self::Sent   => 'Dikirim',
        };
    }
}
