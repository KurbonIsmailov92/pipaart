<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');
});

function newsPayload(array $overrides = []): array
{
    return array_replace_recursive([
        'title' => [
            'ru' => 'Новая новость',
            'tg' => 'Хабари нав',
            'en' => 'Fresh news',
        ],
        'content' => [
            'ru' => 'Контент новости для проверки публикации',
            'tg' => 'Матни хабар барои санҷиши нашр',
            'en' => 'News body for publication checks',
        ],
        'image' => UploadedFile::fake()->image('news.jpg'),
    ], $overrides);
}

it('publishes news immediately when published_at is omitted', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), newsPayload())
        ->assertRedirect(route('admin.news.index'));

    $this->get('/ru/news')
        ->assertOk()
        ->assertSee('Новая новость');
});

it('shows news on the public page when published_at is in the past', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), newsPayload([
            'published_at' => now()->subHour()->format('Y-m-d\TH:i'),
        ]))
        ->assertRedirect(route('admin.news.index'));

    $this->get('/ru/news')
        ->assertOk()
        ->assertSee('Новая новость');
});

it('keeps scheduled future news hidden from the public page', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), newsPayload([
            'title' => [
                'ru' => 'Будущая новость',
                'tg' => 'Хабари оянда',
                'en' => 'Future news',
            ],
            'published_at' => now()->addDay()->format('Y-m-d\TH:i'),
        ]))
        ->assertRedirect(route('admin.news.index'));

    $this->get('/ru/news')
        ->assertOk()
        ->assertDontSee('Будущая новость');
});

it('publishes news immediately when published_at is submitted as an empty string', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), newsPayload([
            'title' => [
                'ru' => 'Публикация сразу',
                'tg' => 'Нашри фаврӣ',
                'en' => 'Publish now',
            ],
            'published_at' => '',
        ]))
        ->assertRedirect(route('admin.news.index'));

    $this->get('/ru/news')
        ->assertOk()
        ->assertSee('Публикация сразу');
});
