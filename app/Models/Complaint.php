<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Complaint extends Model implements HasMedia
{
    use HasUlids;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'tracking_code',
        'complainant_name',
        'complainant_email',
        'complainant_phone',
        'complainant_address',
        'subject',
        'description',
        'category',
        'status',
        'attachment_media_ids',
        'submitted_at',
        'processed_at',
        'processed_by',
        'response_letter_id',
    ];

    protected $casts = [
        'status'               => ComplaintStatus::class,
        'attachment_media_ids' => 'array',
        'submitted_at'         => 'datetime',
        'processed_at'         => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ktp')
            ->singleFile()
            ->useDisk('private');

        $this->addMediaCollection('attachments')
            ->useDisk('private');
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function letter(): HasOne
    {
        return $this->hasOne(Letter::class);
    }

    public function responseLetter(): BelongsTo
    {
        return $this->belongsTo(Letter::class, 'response_letter_id');
    }

    /**
     * Get the status timeline for public display.
     */
    public function getStatusTimelineAttribute(): array
    {
        return [
            ['status' => 'pending',    'label' => 'Diterima',           'done' => true],
            ['status' => 'processing', 'label' => 'Sedang Diproses',    'done' => in_array($this->status->value, ['processing', 'approved', 'rejected', 'completed'])],
            ['status' => 'completed',  'label' => 'Selesai / Respons',  'done' => in_array($this->status->value, ['approved', 'rejected', 'completed'])],
        ];
    }
}
