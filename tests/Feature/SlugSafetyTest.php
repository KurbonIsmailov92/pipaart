<?php

use App\Models\Course;
use App\Models\NewsPost;
use App\Models\User;

it('avoids reserved slugs for public news routes', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), [
            'title' => [
                'ru' => 'List',
                'tg' => 'List',
                'en' => 'List',
            ],
            'content' => [
                'ru' => 'Reserved slug news content',
                'tg' => 'Reserved slug news content',
                'en' => 'Reserved slug news content',
            ],
        ])
        ->assertRedirect(route('admin.news.index'));

    expect(NewsPost::query()->latest('id')->value('slug'))
        ->not->toBe('list');
});

it('avoids reserved slugs for public course routes', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.courses.store'), [
            'title' => [
                'ru' => 'Schedule',
                'tg' => 'Schedule',
                'en' => 'Schedule',
            ],
            'description' => [
                'ru' => 'Reserved slug course description',
                'tg' => 'Reserved slug course description',
                'en' => 'Reserved slug course description',
            ],
            'duration' => '12 hours',
            'hours' => 12,
            'price' => 100,
        ])
        ->assertRedirect(route('admin.courses.index'));

    expect(Course::query()->latest('id')->value('slug'))
        ->not->toBe('schedule');
});
