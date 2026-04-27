<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    public const STATUS_ISSUED = 'issued';

    public const STATUS_REVOKED = 'revoked';

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'title',
        'issued_at',
        'file_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
        ];
    }

    /**
     * @return list<string>
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_ISSUED,
            self::STATUS_REVOKED,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeIssued(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ISSUED);
    }
}
