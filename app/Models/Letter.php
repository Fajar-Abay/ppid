<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LetterStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'complaint_id',
        'template_id',
        'letter_number',
        'subject',
        'body',
        'signature_id',
        'signed_at',
        'pdf_path',
        'attachments',
        'status',
        'created_by',
    ];

    protected $casts = [
        'status'    => LetterStatus::class,
        'signed_at' => 'datetime',
        'attachments' => 'array',
    ];

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(LetterTemplate::class, 'template_id');
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signature_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
