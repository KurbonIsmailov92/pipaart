<?php

it('renders the dark mode bootstrap script and toggle without breaking the home page', function (): void {
    $this->get('/ru')
        ->assertOk()
        ->assertSee('prefers-color-scheme: dark', false)
        ->assertSee('theme-dark', false)
        ->assertSee('data-theme-toggle', false);
});
