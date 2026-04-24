<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'slug' => 'accounting-basics',
                'title' => [
                    'ru' => 'Основы бухгалтерского учета',
                    'tg' => 'Асосҳои баҳисобгирии муҳосибӣ',
                    'en' => 'Accounting Basics',
                ],
                'description' => [
                    'ru' => 'Базовый курс по бухгалтерскому учету для начинающих специалистов и студентов.',
                    'tg' => 'Курси ибтидоӣ барои донишҷӯён ва мутахассисони навкор дар соҳаи муҳосибӣ.',
                    'en' => 'An introductory accounting course for students and entry-level professionals.',
                ],
                'hours' => 40,
                'duration' => '40 hours',
                'price' => 0,
            ],
            [
                'slug' => 'one-c-enterprise',
                'title' => [
                    'ru' => '1С: Предприятие',
                    'tg' => '1С: Корхона',
                    'en' => '1C: Enterprise',
                ],
                'description' => [
                    'ru' => 'Практический курс по работе с системой 1С: Предприятие для бухгалтеров и операторов.',
                    'tg' => 'Курси амалӣ барои кор бо низоми 1С: Корхона барои муҳосибон ва операторон.',
                    'en' => 'A practical course on using 1C: Enterprise for accountants and operations teams.',
                ],
                'hours' => 40,
                'duration' => '40 hours',
                'price' => 0,
            ],
            [
                'slug' => 'financial-accounting-1',
                'title' => [
                    'ru' => 'Финансовый учет 1',
                    'tg' => 'Баҳисобгирии молиявӣ 1',
                    'en' => 'Financial Accounting 1',
                ],
                'description' => [
                    'ru' => 'Курс по подготовке и анализу базовой финансовой отчетности в соответствии с международными стандартами.',
                    'tg' => 'Курс оид ба таҳия ва таҳлили ҳисоботи асосии молиявӣ мувофиқи стандартҳои байналмилалӣ.',
                    'en' => 'A course on preparing and analyzing core financial statements in line with international standards.',
                ],
                'hours' => 60,
                'duration' => '60 hours',
                'price' => 0,
            ],
        ];

        foreach ($courses as $course) {
            Course::query()->updateOrCreate(
                ['slug' => $course['slug']],
                $course,
            );
        }
    }
}
