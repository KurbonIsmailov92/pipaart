<?php

namespace Database\Factories;

use App\Models\NewsPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsPost>
 */
class NewsPostFactory extends Factory
{
    protected $model = NewsPost::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);
        $content = fake()->paragraphs(4, true);

        return [
            'title' => [
                'ru' => $title,
                'tg' => $title,
                'en' => $title,
            ],
            'slug' => Str::slug($title),
            'content' => [
                'ru' => $content,
                'tg' => $content,
                'en' => $content,
            ],
            'text' => [
                'ru' => $content,
                'tg' => $content,
                'en' => $content,
            ],
            'image' => null,
            'is_published' => true,
            'published_at' => now()->subDay(),
        ];
    }
}
