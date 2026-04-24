<?php

use App\Models\Page;

it('redirects root to the default locale home page', function (): void {
    $this->get('/')
        ->assertRedirect('/ru');
});

it('renders localized public pages without missing locale errors', function (): void {
    Page::query()->firstOrCreate(
        ['slug' => 'about'],
        [
            'title' => ['ru' => 'About', 'tg' => 'About', 'en' => 'About'],
            'content' => ['ru' => 'About content', 'tg' => 'About content', 'en' => 'About content'],
            'meta_title' => ['ru' => 'About', 'tg' => 'About', 'en' => 'About'],
            'meta_description' => ['ru' => 'About content', 'tg' => 'About content', 'en' => 'About content'],
            'is_published' => true,
        ]
    );

    Page::query()->firstOrCreate(
        ['slug' => 'certifications'],
        [
            'title' => ['ru' => 'Certifications', 'tg' => 'Certifications', 'en' => 'Certifications'],
            'content' => ['ru' => 'Certification content', 'tg' => 'Certification content', 'en' => 'Certification content'],
            'meta_title' => ['ru' => 'Certifications', 'tg' => 'Certifications', 'en' => 'Certifications'],
            'meta_description' => ['ru' => 'Certification content', 'tg' => 'Certification content', 'en' => 'Certification content'],
            'is_published' => true,
        ]
    );

    $this->get('/ru')->assertOk();
    $this->get('/tg')->assertOk();
    $this->get('/en')->assertOk();
    $this->get('/ru/courses')->assertOk();
    $this->get('/ru/news')->assertOk();
    $this->get('/ru/gallery')->assertOk();
});

it('renders home links with the current locale prefix', function (): void {
    $response = $this->get('/ru');

    $response->assertOk();
    $response->assertSee(route('courses.index', ['locale' => 'ru']), false);
    $response->assertSee(route('schedule.index', ['locale' => 'ru']), false);
    $response->assertSee(route('news.index', ['locale' => 'ru']), false);
    $response->assertSee(route('gallery.index', ['locale' => 'ru']), false);
    $response->assertSee(route('contact', ['locale' => 'ru']), false);
});
