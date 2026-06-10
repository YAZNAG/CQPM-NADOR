<?php

namespace Database\Seeders;

use App\Models\MediaItem;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title_fr' => 'Atelier de formation maritime',
                'title_ar' => 'ورشة التكوين البحري',
                'slug' => 'atelier-formation-maritime',
                'description_fr' => 'Aperçu des ateliers pratiques du centre.',
                'description_ar' => 'لمحة عن الورشات التطبيقية بالمركز.',
                'category_fr' => 'Formation',
                'category_ar' => 'التكوين',
                'position' => 1,
            ],
            [
                'title_fr' => 'Espaces pédagogiques',
                'title_ar' => 'فضاءات بيداغوجية',
                'slug' => 'espaces-pedagogiques',
                'description_fr' => 'Espaces dédiés à l’apprentissage et à l’encadrement des stagiaires.',
                'description_ar' => 'فضاءات مخصصة للتعلم ومواكبة المتدربين.',
                'category_fr' => 'Centre',
                'category_ar' => 'المركز',
                'position' => 2,
            ],
            [
                'title_fr' => 'Vidéo de présentation',
                'title_ar' => 'فيديو تقديمي',
                'slug' => 'video-presentation',
                'description_fr' => 'Vidéo de présentation du CQPM Nador.',
                'description_ar' => 'فيديو تعريفي بمركز الناظور.',
                'media_type' => 'video',
                'video_url' => 'https://www.youtube.com/',
                'category_fr' => 'Vidéo',
                'category_ar' => 'فيديو',
                'position' => 3,
            ],
        ];

        foreach ($items as $item) {
            MediaItem::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge([
                    'media_type' => 'image',
                    'image_path' => null,
                    'video_url' => null,
                    'alt_fr' => $item['title_fr'],
                    'alt_ar' => $item['title_ar'],
                    'meta_title_fr' => $item['title_fr'] . ' - CQPM Nador',
                    'meta_title_ar' => $item['title_ar'] . ' - CQPM Nador',
                    'meta_description_fr' => $item['description_fr'],
                    'meta_description_ar' => $item['description_ar'],
                    'is_active' => true,
                ], $item)
            );
        }

        MediaItem::clearMediaCache();
    }
}
