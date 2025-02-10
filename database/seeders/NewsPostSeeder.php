<?php

namespace Database\Seeders;

use App\Models\NewsPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsPost::factory()->create([
            'title'=>'Добро пожаловать в PIPAART',
            'text'=>'Ваш верный партнер в мире бухгалтерского и финансового учета',
            'image'=>'https://picsum.photos/500/400',
        ]);

        NewsPost::factory()->create([
            'title'=>'Курсы',
            'text'=>'Ознакомьтесь со списком наших курсов по финансовому учету',
            'image'=>'https://picsum.photos/500/400',
        ]);

        NewsPost::factory()->create([
            'title'=>'Материалы',
            'text'=>'Получите доступ к учебным материалам и гайдам для вашего обучения',
            'image'=>'https://picsum.photos/500/400',
        ]);
    }
}
