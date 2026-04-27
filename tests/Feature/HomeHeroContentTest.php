<?php

use App\Models\HomeHero;
use App\Models\User;

it('renders cms managed localized homepage hero content', function (): void {
    HomeHero::query()->updateOrCreate(
        ['locale' => 'en'],
        [
            'title' => 'CMS managed hero title',
            'subtitle' => 'CMS managed hero subtitle',
            'cta_text' => 'Start here',
            'cta_url' => '/courses',
            'is_active' => true,
        ],
    );

    $this->get('/en')
        ->assertOk()
        ->assertSee('CMS managed hero title')
        ->assertSee('CMS managed hero subtitle')
        ->assertSee('Start here')
        ->assertSee('/en/courses');
});

it('falls back to the default active hero when locale hero is inactive', function (): void {
    HomeHero::query()->updateOrCreate(
        ['locale' => 'ru'],
        [
            'title' => 'Fallback hero title',
            'subtitle' => 'Fallback hero subtitle',
            'cta_text' => 'Fallback CTA',
            'cta_url' => '/courses',
            'is_active' => true,
        ],
    );

    HomeHero::query()->updateOrCreate(
        ['locale' => 'tg'],
        [
            'title' => 'Inactive TG hero title',
            'subtitle' => 'Inactive TG hero subtitle',
            'cta_text' => 'Inactive CTA',
            'cta_url' => '/courses',
            'is_active' => false,
        ],
    );

    $this->get('/tg')
        ->assertOk()
        ->assertSee('Fallback hero title')
        ->assertDontSee('Inactive TG hero title');
});

it('allows admin to update homepage hero content', function (): void {
    $admin = User::factory()->admin()->create();
    $hero = HomeHero::query()->firstOrFail();

    $this->actingAs($admin)
        ->put(route('admin.home-heroes.update', $hero), [
            'locale' => $hero->locale,
            'title' => 'Updated admin hero',
            'subtitle' => 'Updated subtitle',
            'cta_text' => 'Updated CTA',
            'cta_url' => '/contacts',
            'is_active' => 1,
        ])
        ->assertRedirect(route('admin.home-heroes.index'));

    expect($hero->fresh()->title)->toBe('Updated admin hero');
});
