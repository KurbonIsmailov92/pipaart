<?php

it('registers reusable submit lock behavior for non get forms', function (): void {
    $script = file_get_contents(resource_path('js/app.js'));

    expect($script)->toContain('data-submit-lock')
        ->and($script)->toContain('lockSubmitButtons')
        ->and($script)->toContain('form[method]:not([method="GET"])');
});

it('exposes localized processing text to the frontend', function (): void {
    $this->get('/ru')
        ->assertOk()
        ->assertSee('data-loading-text', false);
});

it('renders and wires the mobile navigation menu', function (): void {
    $this->get('/ru')
        ->assertOk()
        ->assertSee('data-mobile-nav', false)
        ->assertSee('data-mobile-nav-toggle', false)
        ->assertSee('/ru/courses', false)
        ->assertSee('/ru/news/list', false);

    $script = file_get_contents(resource_path('js/app.js'));

    expect($script)->toContain('[data-mobile-nav]')
        ->and($script)->toContain('HTMLDetailsElement')
        ->and($script)->toContain('Escape');
});
