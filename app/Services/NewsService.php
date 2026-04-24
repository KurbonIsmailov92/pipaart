<?php

namespace App\Services;

use App\Models\NewsPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class NewsService
{
    /**
     * @var list<string>
     */
    protected array $reservedSlugs = [
        'list',
    ];

    public function __construct(
        protected MediaService $mediaService,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): NewsPost
    {
        if (isset($data['image']) && $data['image'] !== null) {
            $data['image'] = $this->mediaService->storeImage($data['image'], 'news');
        }

        $data['content'] = $data['content'] ?? $data['text'] ?? '';
        $data['text'] = $data['content'];
        $data['is_published'] = $this->normalizePublicationFlag($data['is_published'] ?? null, true);
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        $data['published_at'] = $this->normalizePublishedAtForCreate(
            $data['published_at'] ?? null,
            $data['is_published'],
        );

        return NewsPost::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(NewsPost $newsPost, array $data): NewsPost
    {
        $data['image'] = $this->mediaService->replaceImage(
            $newsPost->image,
            $data['image'] ?? null,
            'news',
        );

        if (
            isset($data['title'])
            && $this->resolveSlugSource($data['title']) !== $this->resolveSlugSource($newsPost->getTranslations('title'))
        ) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $newsPost);
        }

        $data['content'] = $data['content'] ?? $data['text'] ?? $newsPost->content ?? $newsPost->text;
        $data['text'] = $data['content'];
        $data['is_published'] = $this->normalizePublicationFlag(
            $data['is_published'] ?? null,
            $newsPost->is_published,
        );

        if (array_key_exists('published_at', $data)) {
            $data['published_at'] = $this->normalizePublishedAtForUpdate(
                $data['published_at'],
                $newsPost,
                $data['is_published'],
            );
        } else {
            $data['published_at'] = $data['is_published']
                ? ($newsPost->published_at ?? now())
                : $newsPost->published_at;
        }

        $newsPost->update($data);

        return $newsPost->refresh();
    }

    public function delete(NewsPost $newsPost): void
    {
        $this->mediaService->delete($newsPost->image);
        $newsPost->delete();
    }

    protected function generateUniqueSlug(string|array $title, ?NewsPost $newsPost = null): string
    {
        $baseSlug = Str::slug($this->resolveSlugSource($title));
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'news';
        $slug = $baseSlug;
        $suffix = 2;

        while ($this->slugExists($slug, $newsPost)) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    protected function resolveSlugSource(string|array $title): string
    {
        if (is_string($title)) {
            return $title;
        }

        $preferredLocales = array_unique([
            app()->getLocale(),
            config('app.fallback_locale', 'ru'),
            'ru',
            'en',
            'tj',
            'tg',
        ]);

        foreach ($preferredLocales as $locale) {
            if (filled($title[$locale] ?? null)) {
                return trim((string) $title[$locale]);
            }
        }

        foreach ($title as $translation) {
            if (filled($translation)) {
                return trim((string) $translation);
            }
        }

        return 'news';
    }

    protected function normalizePublishedAtForCreate(mixed $publishedAt, bool $isPublished): ?Carbon
    {
        if (blank($publishedAt)) {
            return $isPublished ? now() : null;
        }

        return $this->parsePublishedAt($publishedAt);
    }

    protected function normalizePublishedAtForUpdate(
        mixed $publishedAt,
        NewsPost $newsPost,
        bool $isPublished
    ): ?Carbon {
        if (blank($publishedAt)) {
            return $isPublished
                ? ($newsPost->published_at ?? now())
                : $newsPost->published_at;
        }

        return $this->parsePublishedAt($publishedAt);
    }

    protected function parsePublishedAt(mixed $publishedAt): Carbon
    {
        return match (true) {
            $publishedAt instanceof Carbon => $publishedAt,
            $publishedAt instanceof \DateTimeInterface => Carbon::instance($publishedAt),
            default => Carbon::parse((string) $publishedAt, config('app.timezone', 'UTC')),
        };
    }

    protected function normalizePublicationFlag(mixed $value, bool $default): bool
    {
        if ($value === null) {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    protected function slugExists(string $slug, ?NewsPost $newsPost = null): bool
    {
        if (in_array($slug, $this->reservedSlugs, true)) {
            return true;
        }

        return NewsPost::query()
            ->where('slug', $slug)
            ->when($newsPost !== null, static fn ($query) => $query->whereKeyNot($newsPost->getKey()))
            ->exists();
    }
}
