<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title_fr' => 'Session d’orientation des candidats',
                'title_ar' => 'حصة توجيهية للمترشحين',
                'slug' => 'session-orientation-candidats',
                'excerpt_fr' => 'Présentation des filières, conditions d’accès et calendrier de candidature.',
                'excerpt_ar' => 'تقديم المسالك وشروط الولوج وجدولة الترشيح.',
                'content_fr' => 'Le CQPM Nador organise une session d’orientation destinée aux candidats souhaitant rejoindre les formations maritimes. L’équipe pédagogique répondra aux questions liées aux parcours et aux conditions d’accès.',
                'content_ar' => 'ينظم مركز الناظور حصة توجيهية لفائدة المترشحين الراغبين في الالتحاق بالتكوينات البحرية. سيجيب الفريق التربوي عن الأسئلة المرتبطة بالمسارات وشروط الولوج.',
                'location_fr' => 'CQPM Nador',
                'location_ar' => 'مركز الناظور',
                'starts_at' => now()->addDays(10)->setTime(10, 0),
                'ends_at' => now()->addDays(10)->setTime(12, 0),
                'position' => 1,
            ],
            [
                'title_fr' => 'Atelier sécurité maritime',
                'title_ar' => 'ورشة السلامة البحرية',
                'slug' => 'atelier-securite-maritime',
                'excerpt_fr' => 'Atelier pratique autour des règles essentielles de sécurité à bord.',
                'excerpt_ar' => 'ورشة تطبيقية حول القواعد الأساسية للسلامة على متن السفن.',
                'content_fr' => 'Cet atelier sensibilise les stagiaires aux procédures de sécurité maritime et aux bons réflexes à adopter dans un environnement professionnel.',
                'content_ar' => 'تهدف هذه الورشة إلى تحسيس المتدربين بإجراءات السلامة البحرية والسلوكيات المهنية الواجب اعتمادها.',
                'location_fr' => 'Salle polyvalente',
                'location_ar' => 'القاعة متعددة الاستعمالات',
                'starts_at' => now()->addDays(20)->setTime(9, 30),
                'ends_at' => now()->addDays(20)->setTime(11, 30),
                'position' => 2,
            ],
        ];

        foreach ($items as $item) {
            Event::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge([
                    'image_path' => null,
                    'meta_title_fr' => $item['title_fr'] . ' - CQPM Nador',
                    'meta_title_ar' => $item['title_ar'] . ' - CQPM Nador',
                    'meta_description_fr' => $item['excerpt_fr'],
                    'meta_description_ar' => $item['excerpt_ar'],
                    'is_active' => true,
                ], $item)
            );
        }

        Event::clearEventCache();
    }
}
