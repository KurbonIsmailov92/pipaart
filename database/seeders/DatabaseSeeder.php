<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingsSeeder::class,
            HomeHeroSeeder::class,
        ]);

        if (! app()->environment('production')) {
            $this->call([
                CoursesSeeder::class,
                NewsPostSeeder::class,
                DemoCabinetSeeder::class,
            ]);
        }
    }
}
