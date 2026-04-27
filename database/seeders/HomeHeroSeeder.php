<?php

namespace Database\Seeders;

use App\Models\HomeHero;
use Illuminate\Database\Seeder;

class HomeHeroSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->defaults() as $locale => $data) {
            $hero = HomeHero::query()->firstOrNew(['locale' => $locale]);

            if ($hero->exists && ! $this->looksLikeMojibake((string) $hero->title)) {
                continue;
            }

            $hero->fill($data);
            $hero->save();
        }
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    protected function defaults(): array
    {
        return [
            'ru' => [
                'title' => 'Профессиональное бухгалтерское образование и сертификация',
                'subtitle' => 'Курсы, сертификаты, новости и обучение управляются из единой CMS.',
                'cta_text' => 'Смотреть курсы',
                'cta_url' => '/courses',
                'is_active' => true,
            ],
            'tg' => [
                'title' => 'Таҳсилоти касбии муҳосибӣ ва сертификатсия',
                'subtitle' => 'Курсҳо, сертификатсия, хабарҳо ва омӯзиш аз як CMS идора мешаванд.',
                'cta_text' => 'Дидани курсҳо',
                'cta_url' => '/courses',
                'is_active' => true,
            ],
            'en' => [
                'title' => 'Professional accounting education and certification',
                'subtitle' => 'Courses, certifications, news, and training managed from one CMS.',
                'cta_text' => 'Browse courses',
                'cta_url' => '/courses',
                'is_active' => true,
            ],
        ];
    }

    protected function looksLikeMojibake(string $value): bool
    {
        return str_contains($value, 'Рџ')
            || str_contains($value, 'Рў')
            || str_contains($value, 'Рљ')
            || str_contains($value, 'СЃ');
    }
}
