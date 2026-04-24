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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $request = request();
        $supportedLocales = config('app.supported_locales', ['ru', 'tg', 'en']);
        $defaultLocale = config('app.locale', 'ru');
        $routeLocale = $request->route('locale');
        $sessionLocale = $request->hasSession() ? $request->session()->get('locale') : null;
        $locale = is_string($routeLocale) ? $routeLocale : $sessionLocale;

        if (! is_string($locale) || ! in_array($locale, $supportedLocales, true)) {
            $locale = $defaultLocale;
        }

        URL::defaults(['locale' => $locale]);

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

        View::composer(['layouts.app', 'components.header', 'components.footer'], static function ($view): void {
            $defaultSettings = [
                'site_name' => 'PIPAA CMS',
                'hero_title' => __('ui.home.hero_title'),
                'hero_subtitle' => __('ui.home.hero_subtitle'),
                'contact_email' => 'info@pipaa.tj',
                'contact_backup_email' => '',
                'contact_phone' => '',
                'contact_address' => __('ui.contact.default_address'),
            ];

            $settings = $defaultSettings;

            try {
                if (Schema::hasTable('settings')) {
                    $settings = array_replace(
                        $defaultSettings,
                        Setting::query()->pluck('value', 'key')->all(),
                    );
                }
            } catch (Throwable) {
                $settings = $defaultSettings;
            }

            $view->with('siteSettings', $settings);
        });
    }
}
