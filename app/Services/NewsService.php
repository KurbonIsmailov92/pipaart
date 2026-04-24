<?php

namespace App\Services;

use App\Models\NewsPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class NewsService
{
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
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        $data['published_at'] = $this->normalizePublishedAtForCreate($data['published_at'] ?? null);

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

        if (isset($data['title']) && $this->resolveSlugSource($data['title']) !== $newsPost->getTranslation('title')) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $newsPost);
        }

        $data['content'] = $data['content'] ?? $data['text'] ?? $newsPost->content ?? $newsPost->text;
        $data['text'] = $data['content'];

        if (array_key_exists('published_at', $data)) {
            $data['published_at'] = $this->normalizePublishedAtForUpdate($data['published_at'], $newsPost);
        } else {
            $data['published_at'] = $newsPost->published_at ?? now();
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

        while (
            NewsPost::query()
                ->where('slug', $slug)
                ->when($newsPost !== null, static fn ($query) => $query->whereKeyNot($newsPost->getKey()))
                ->exists()
        ) {
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

        return (string) ($title[config('app.fallback_locale', 'ru')]
            ?? $title['en']
            ?? $title['tg']
            ?? reset($title)
            ?: 'news');
    }

    protected function normalizePublishedAtForCreate(mixed $publishedAt): Carbon
    {
        if (blank($publishedAt)) {
            return now();
        }

        return $this->parsePublishedAt($publishedAt);
    }

    protected function normalizePublishedAtForUpdate(mixed $publishedAt, NewsPost $newsPost): Carbon
    {
        if (blank($publishedAt)) {
            return $newsPost->published_at ?? now();
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
}
