<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_heroes', function (Blueprint $table): void {
            $table->id();
            $table->string('locale', 5)->unique();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('cta_url')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        DB::table('home_heroes')->insert([
            [
                'locale' => 'ru',
                'title' => 'Профессиональное бухгалтерское образование и сертификация',
                'subtitle' => 'Курсы, сертификаты, новости и обучение управляются из единой CMS.',
                'cta_text' => 'Смотреть курсы',
                'cta_url' => '/courses',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'locale' => 'tg',
                'title' => 'Таҳсилоти касбии муҳосибӣ ва сертификатсия',
                'subtitle' => 'Курсҳо, сертификатсия, хабарҳо ва омӯзиш аз як CMS идора мешаванд.',
                'cta_text' => 'Дидани курсҳо',
                'cta_url' => '/courses',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'locale' => 'en',
                'title' => 'Professional accounting education and certification',
                'subtitle' => 'Courses, certifications, news, and training managed from one CMS.',
                'cta_text' => 'Browse courses',
                'cta_url' => '/courses',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_heroes');
    }
};
