<?php

namespace App\Services;

use App\Models\NewsPost;
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
        $data['published_at'] = $data['published_at'] ?? now();

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
        $data['published_at'] = $data['published_at'] ?? $newsPost->published_at ?? now();

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
}
