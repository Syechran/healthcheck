<?php

namespace App\Models;

use App\Enums\Severity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One illness-detection record — the "Riwayat" (history) item. Belongs to a
 * user. The detection result itself is dummy data (no real ML): the disease
 * name, severity, and confidence are simply stored as given.
 */
#[Fillable([
    'user_id',
    'disease_name',
    'severity',
    'confidence',
    'detected_area',
    'image_path',
    'notes',
    'detected_at',
])]
class Detection extends Model
{
    /** @use HasFactory<\Database\Factories\DetectionFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'severity' => Severity::class,
            'confidence' => 'integer',
            'detected_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
