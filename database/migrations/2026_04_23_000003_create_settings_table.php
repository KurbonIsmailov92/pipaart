<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'PIPAA CMS', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'hero_title', 'value' => 'Professional accounting and audit education.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'hero_subtitle', 'value' => 'Manage pages, courses, schedules, news, and contact details from the admin panel.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_email', 'value' => 'info@pipaa.tj', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_backup_email', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_phone', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_address', 'value' => 'Dushanbe, Tajikistan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
