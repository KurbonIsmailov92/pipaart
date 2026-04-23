<?php

namespace App\Services;

use App\Models\Page;

class PageService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Page
    {
        return Page::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Page $page, array $data): Page
    {
        $page->update($data);

        return $page->refresh();
    }

    public function delete(Page $page): void
    {
        $page->delete();
    }

    public function getPublishedPageBySlug(string $slug): ?Page
    {
        return Page::query()
            ->published()
            ->where('slug', $slug)
            ->first();
    }
}
