<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Support\TranslationQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    use HasTranslatableAttributes;

    /**
     * @var list<string>
     */
    protected array $translatable = [
        'title',
        'description',
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'duration',
        'hours',
        'price',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'hours' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return TranslationQuery::orderByTranslated($query, 'title');
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (blank($search)) {
            return $query;
        }

        return TranslationQuery::whereAnyTranslatedLike($query, ['title', 'description'], $search)
            ->orWhere('duration', 'like', '%'.$search.'%');
    }

    public function getDurationLabelAttribute(): string
    {
        return $this->duration ?: (($this->hours ?? 0) > 0 ? $this->hours.' hours' : __('ui.courses.duration_on_request'));
    }
}
