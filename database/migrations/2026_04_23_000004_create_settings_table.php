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
            $table->longText('value')->nullable();
        });

        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'PIPAA'],
            ['key' => 'contact_email', 'value' => 'info@pipaa.tj'],
            ['key' => 'contact_backup_email', 'value' => 'pipaart@mail.ru'],
            ['key' => 'contact_phone', 'value' => '+992 935 60 33 38'],
            ['key' => 'contact_address', 'value' => 'Dushanbe, Tajikistan'],
            ['key' => 'hero_title', 'value' => 'Professional accounting education and certification'],
            ['key' => 'hero_subtitle', 'value' => 'Courses, certifications, news, and training managed from one CMS.'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
