<?php

namespace Database\Seeders;

use App\Models\NewsPost;
use Illuminate\Database\Seeder;

class NewsPostSeeder extends Seeder
{
    public function run(): void
    {
        $newsPosts = [
            [
                'slug' => 'welcome-to-pipaart',
                'title' => [
                    'ru' => 'Добро пожаловать в PIPAA',
                    'tg' => 'Хуш омадед ба PIPAA',
                    'en' => 'Welcome to PIPAA',
                ],
                'content' => [
                    'ru' => 'Следите за новостями института, программами обучения и объявлениями о сертификациях.',
                    'tg' => 'Ахбори институт, барномаҳои омӯзишӣ ва эълонҳои сертификатсияро пайгирӣ кунед.',
                    'en' => 'Follow institute updates, course announcements, and certification news.',
                ],
                'text' => [
                    'ru' => 'Следите за новостями института, программами обучения и объявлениями о сертификациях.',
                    'tg' => 'Ахбори институт, барномаҳои омӯзишӣ ва эълонҳои сертификатсияро пайгирӣ кунед.',
                    'en' => 'Follow institute updates, course announcements, and certification news.',
                ],
                'image' => null,
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'slug' => 'new-course-groups-open',
                'title' => [
                    'ru' => 'Открыт набор в новые учебные группы',
                    'tg' => 'Қабул ба гурӯҳҳои нави омӯзишӣ оғоз шуд',
                    'en' => 'Enrollment Open for New Study Groups',
                ],
                'content' => [
                    'ru' => 'Администрация института открыла регистрацию на ближайшие группы по курсам бухгалтерского и финансового учета.',
                    'tg' => 'Маъмурияти институт сабти номро барои гурӯҳҳои наздиктарини курсҳои муҳосибӣ ва молиявӣ оғоз намуд.',
                    'en' => 'The institute has opened registration for upcoming accounting and financial reporting study groups.',
                ],
                'text' => [
                    'ru' => 'Администрация института открыла регистрацию на ближайшие группы по курсам бухгалтерского и финансового учета.',
                    'tg' => 'Маъмурияти институт сабти номро барои гурӯҳҳои наздиктарини курсҳои муҳосибӣ ва молиявӣ оғоз намуд.',
                    'en' => 'The institute has opened registration for upcoming accounting and financial reporting study groups.',
                ],
                'image' => null,
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'slug' => 'library-materials-updated',
                'title' => [
                    'ru' => 'Обновлены учебные материалы библиотеки',
                    'tg' => 'Маводҳои омӯзишии китобхона нав шуданд',
                    'en' => 'Library Study Materials Updated',
                ],
                'content' => [
                    'ru' => 'В библиотечном разделе опубликованы новые материалы для подготовки к занятиям и сертификационным экзаменам.',
                    'tg' => 'Дар бахши китобхона маводҳои нав барои омодагӣ ба дарсҳо ва имтиҳонҳои сертификатсионӣ нашр шуданд.',
                    'en' => 'New study resources have been published in the library section for classes and certification exam preparation.',
                ],
                'text' => [
                    'ru' => 'В библиотечном разделе опубликованы новые материалы для подготовки к занятиям и сертификационным экзаменам.',
                    'tg' => 'Дар бахши китобхона маводҳои нав барои омодагӣ ба дарсҳо ва имтиҳонҳои сертификатсионӣ нашр шуданд.',
                    'en' => 'New study resources have been published in the library section for classes and certification exam preparation.',
                ],
                'image' => null,
                'is_published' => true,
                'published_at' => now()->subDay(),
            ],
        ];

        foreach ($newsPosts as $newsPost) {
            NewsPost::query()->updateOrCreate(
                ['slug' => $newsPost['slug']],
                $newsPost,
            );
        }
    }
}
