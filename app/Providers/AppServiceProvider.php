<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Gallery;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\User;
use App\Policies\CoursePolicy;
use App\Policies\GalleryPolicy;
use App\Policies\NewsPostPolicy;
use App\Policies\PagePolicy;
use App\Policies\SchedulePolicy;
use App\Policies\SettingPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(NewsPost::class, NewsPostPolicy::class);
        Gate::policy(Gallery::class, GalleryPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Page::class, PagePolicy::class);
        Gate::policy(Schedule::class, SchedulePolicy::class);
        Gate::policy(Setting::class, SettingPolicy::class);

        Gate::before(static function (User $user): ?bool {
            return $user->isAdmin() ? true : null;
        });

        $defaultSettings = [
            'site_name' => 'PIPAA CMS',
            'hero_title' => 'Professional accounting and audit education in Tajikistan.',
            'hero_subtitle' => 'A production-ready Laravel CMS for institute pages, courses, schedules, news, gallery, and contacts.',
            'contact_email' => 'info@pipaa.tj',
            'contact_backup_email' => '',
            'contact_phone' => '',
            'contact_address' => 'Dushanbe, Tajikistan',
        ];

        View::composer(['layouts.app', 'components.header', 'components.footer'], static function ($view) use ($defaultSettings): void {
            $settings = $defaultSettings;

            if (Schema::hasTable('settings')) {
                $settings = array_replace(
                    $defaultSettings,
                    Setting::query()->pluck('value', 'key')->all(),
                );
            }

            $view->with('siteSettings', $settings);
        });
    }
}
