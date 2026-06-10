<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title_fr' => 'Ouverture des inscriptions au concours',
                'title_ar' => 'فتح باب التسجيل في المباراة',
                'slug' => 'ouverture-inscriptions-concours',
                'excerpt_fr' => 'Le CQPM Nador annonce l’ouverture des inscriptions pour la nouvelle année de formation.',
                'excerpt_ar' => 'يعلن مركز التأهيل المهني البحري بالناظور عن فتح باب التسجيل للسنة التكوينية الجديدة.',
                'content_fr' => 'Le Centre de Qualification Professionnelle Maritime de Nador informe les candidats que les inscriptions au concours d’accès sont ouvertes. Les candidats sont invités à préparer leur dossier et à suivre les annonces officielles publiées sur le site.',
                'content_ar' => 'يخبر مركز التأهيل المهني البحري بالناظور المترشحين بأن باب التسجيل في مباراة الولوج مفتوح. يرجى إعداد ملف الترشيح وتتبع الإعلانات الرسمية المنشورة على الموقع.',
                'position' => 1,
            ],
            [
                'title_fr' => 'Journée d’information sur les métiers maritimes',
                'title_ar' => 'يوم تواصلي حول المهن البحرية',
                'slug' => 'journee-information-metiers-maritimes',
                'excerpt_fr' => 'Une rencontre dédiée aux opportunités de formation et d’insertion dans le secteur maritime.',
                'excerpt_ar' => 'لقاء مخصص لفرص التكوين والإدماج في القطاع البحري.',
                'content_fr' => 'Cette journée d’information présente les filières proposées par le centre, les conditions d’accès et les débouchés professionnels. Elle vise à rapprocher les jeunes des métiers de la mer.',
                'content_ar' => 'يقدم هذا اليوم التواصلي المسالك المتوفرة بالمركز وشروط الولوج والآفاق المهنية، بهدف تقريب الشباب من مهن البحر.',
                'position' => 2,
            ],
        ];

        foreach ($items as $item) {
            Article::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge([
                    'title' => $item['title_fr'],
                    'content' => $item['content_fr'],
                    'file_path' => null,
                    'image_path' => null,
                    'meta_title_fr' => $item['title_fr'] . ' - CQPM Nador',
                    'meta_title_ar' => $item['title_ar'] . ' - CQPM Nador',
                    'meta_description_fr' => $item['excerpt_fr'],
                    'meta_description_ar' => $item['excerpt_ar'],
                    'published_at' => now(),
                    'is_active' => true,
                ], $item)
            );
        }

        Article::clearNewsCache();
    }
}
