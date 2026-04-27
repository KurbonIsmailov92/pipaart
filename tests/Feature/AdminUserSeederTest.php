<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\HomeHero;
use App\Models\NewsPost;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;

it('creates or updates the default admin user idempotently', function (): void {
    config([
        'admin.email' => 'admin@pipaa.tj',
        'admin.name' => 'PIPAA Admin',
        'admin.password' => 'Mirzoal!ev123',
    ]);

    User::factory()->create([
        'name' => 'Old Admin',
        'email' => 'admin@pipaa.tj',
        'password' => Hash::make('old-password'),
        'role' => UserRole::Student->value,
        'email_verified_at' => null,
    ]);

    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    $admin = User::query()->where('email', 'admin@pipaa.tj')->first();

    expect($admin)->not->toBeNull()
        ->and(User::query()->where('email', 'admin@pipaa.tj')->count())->toBe(1)
        ->and($admin->name)->toBe('PIPAA Admin')
        ->and($admin->role?->value ?? $admin->role)->toBe(UserRole::Admin->value)
        ->and(Hash::check('Mirzoal!ev123', (string) $admin->password))->toBeTrue()
        ->and($admin->password)->not->toBe('Mirzoal!ev123')
        ->and($admin->email_verified_at)->not->toBeNull();
});

it('allows the seeded admin to log in', function (): void {
    config([
        'admin.email' => 'admin@pipaa.tj',
        'admin.name' => 'PIPAA Admin',
        'admin.password' => 'Mirzoal!ev123',
    ]);

    $this->seed(DatabaseSeeder::class);

    $this->post(route('auth.login.store'), [
        'email' => 'admin@pipaa.tj',
        'password' => 'Mirzoal!ev123',
    ])->assertRedirect(route('home', ['locale' => 'ru']));
});

it('does not seed sample content in production', function (): void {
    $this->app->detectEnvironment(static fn (): string => 'production');

    $this->artisan('db:seed', [
        '--class' => DatabaseSeeder::class,
        '--force' => true,
    ])->assertSuccessful();

    expect(User::query()->where('email', 'admin@pipaa.tj')->count())->toBe(1)
        ->and(Course::query()->count())->toBe(0)
        ->and(NewsPost::query()->count())->toBe(0)
        ->and(Setting::query()->where('key', 'site_name')->exists())->toBeTrue()
        ->and(HomeHero::query()->whereIn('locale', ['ru', 'tg', 'en'])->count())->toBe(3);
});

it('keeps required settings and homepage heroes idempotent', function (): void {
    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    expect(Setting::query()->where('key', 'site_name')->count())->toBe(1)
        ->and(HomeHero::query()->where('locale', 'ru')->count())->toBe(1)
        ->and(HomeHero::query()->where('locale', 'tg')->count())->toBe(1)
        ->and(HomeHero::query()->where('locale', 'en')->count())->toBe(1);
});
