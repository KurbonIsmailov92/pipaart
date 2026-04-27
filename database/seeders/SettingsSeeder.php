<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'site_name' => env('CMS_SITE_NAME', 'PIPAA'),
            'contact_email' => env('CONTACT_RECIPIENT_EMAIL', 'info@pipaa.tj'),
            'contact_backup_email' => env('CONTACT_BACKUP_EMAIL', 'pipaart@mail.ru'),
            'contact_phone' => env('CONTACT_PHONE', '+992 935 60 33 38'),
            'contact_address' => env('CONTACT_ADDRESS', 'Dushanbe, Tajikistan'),
            'hero_title' => 'Professional accounting education and certification',
            'hero_subtitle' => 'Courses, certifications, news, and training managed from one CMS.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::query()->firstOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
    }
}
