<?php

use App\Models\Setting;
use App\Models\User;

it('updates settings through cms with timestamps available', function (): void {
    $admin = User::factory()->admin()->create();
    $setting = Setting::query()->where('key', 'site_name')->firstOrFail();

    $this->actingAs($admin)
        ->put(route('admin.settings.update'), [
            'settings' => [
                'site_name' => 'PIPAA Updated',
            ],
        ])
        ->assertRedirect(route('admin.settings.index'));

    $setting->refresh();

    expect($setting->value)->toBe('PIPAA Updated')
        ->and($setting->created_at)->not->toBeNull()
        ->and($setting->updated_at)->not->toBeNull();
});
