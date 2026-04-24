<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Models\Concerns\ResolvesPublicMediaUrls;
use App\Support\TranslationQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class NewsPost extends Model
{
    /** @use HasFactory<\Database\Factories\NewsPostFactory> */
    use HasFactory;
    use HasTranslatableAttributes;
    use ResolvesPublicMediaUrls;

    /**
     * @var list<string>
     */
    protected array $translatable = [
        'title',
        'content',
        'text',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'text',
        'image',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'content' => 'array',
            'text' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderByDesc('published_at')
            ->orderByDesc('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function (Builder $builder): void {
            $builder
                ->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        });
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (blank($search)) {
            return $query;
        }

        return TranslationQuery::whereAnyTranslatedLike($query, ['title', 'content'], $search);
    }

    public function getBodyAttribute(): string
    {
        return (string) ($this->content ?: $this->text);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->resolvePublicMediaUrl($this->image);
    }
}
