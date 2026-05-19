<?php

declare(strict_types=1);

namespace App\Enums;

enum ComplaintStatus: string
{
    case Pending    = 'pending';
    case Processing = 'processing';
    case Approved   = 'approved';
    case Rejected   = 'rejected';
    case Completed  = 'completed';

    public function label(): string
    {
        return match($this) {
            self::Pending    => 'Menunggu',
            self::Processing => 'Diproses',
            self::Approved   => 'Disetujui',
            self::Rejected   => 'Ditolak',
            self::Completed  => 'Selesai',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending    => 'warning',
            self::Processing => 'info',
            self::Approved   => 'success',
            self::Rejected   => 'danger',
            self::Completed  => 'success',
        };
    }
}
