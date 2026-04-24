<?php

it('renders the public gallery page when there are no photos', function (): void {
    $this->get('/ru/gallery')
        ->assertOk();
});
