<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title_fr' => 'Accueil',
                'title_ar' => 'الرئيسية',
                'slug' => 'accueil',
                'content_fr' => 'Page d’accueil du Centre de Qualification Professionnelle Maritime de Nador.',
                'content_ar' => 'الصفحة الرئيسية لمركز التأهيل المهني البحري بالناظور.',
                'meta_title_fr' => 'CQPM Nador - Formation professionnelle maritime',
                'meta_title_ar' => 'مركز التأهيل المهني البحري بالناظور',
                'meta_description_fr' => 'Découvrez les formations, avis, actualités et services du CQPM Nador.',
                'meta_description_ar' => 'اكتشف التكوينات والإعلانات والأخبار وخدمات مركز التأهيل المهني البحري بالناظور.',
                'position' => 1,
                'show_in_menu' => true,
            ],
            ['title_fr' => 'Le Centre', 'title_ar' => 'المركز', 'slug' => 'centre', 'position' => 2, 'show_in_menu' => true],
            ['title_fr' => 'Formations', 'title_ar' => 'التكوينات', 'slug' => 'formations', 'position' => 3, 'show_in_menu' => true],
            ['title_fr' => 'Admission', 'title_ar' => 'التسجيل', 'slug' => 'admission', 'position' => 4, 'show_in_menu' => true],
            ['title_fr' => 'Actualités', 'title_ar' => 'الأخبار', 'slug' => 'actualites', 'position' => 5, 'show_in_menu' => true],
            ['title_fr' => 'Avis & Résultats', 'title_ar' => 'الإعلانات والنتائج', 'slug' => 'documents', 'position' => 6, 'show_in_menu' => true],
            ['title_fr' => 'Galerie', 'title_ar' => 'المعرض', 'slug' => 'galerie', 'position' => 7, 'show_in_menu' => true],
            ['title_fr' => 'Contact', 'title_ar' => 'اتصل بنا', 'slug' => 'contact', 'position' => 8, 'show_in_menu' => true],
        ];

        foreach ($pages as $data) {
            Page::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge([
                    'content_fr' => null,
                    'content_ar' => null,
                    'image_path' => null,
                    'meta_title_fr' => $data['title_fr'] . ' - CQPM Nador',
                    'meta_title_ar' => $data['title_ar'] . ' - CQPM Nador',
                    'meta_description_fr' => null,
                    'meta_description_ar' => null,
                    'is_active' => true,
                    'show_in_menu' => false,
                ], $data)
            );
        }

        $home = Page::where('slug', 'accueil')->firstOrFail();

        $sections = [
            [
                'section_key' => 'hero',
                'section_type' => 'hero',
                'title_fr' => 'Centre de Qualification Professionnelle Maritime de Nador',
                'title_ar' => 'مركز التأهيل المهني البحري بالناظور',
                'subtitle_fr' => 'Inscriptions 2024 / 2025',
                'subtitle_ar' => 'التسجيلات 2024 / 2025',
                'content_fr' => 'Formez-vous aux métiers de la mer dans un cadre agréé par le Département de la Pêche Maritime. Excellence, rigueur et insertion professionnelle.',
                'content_ar' => 'تكوّن في مهن البحر داخل مؤسسة معتمدة من طرف قطاع الصيد البحري، مع تكوين مهني جاد وفرص إدماج واعدة.',
                'button_text_fr' => 'S’inscrire au concours',
                'button_text_ar' => 'التسجيل في المباراة',
                'button_url' => '/candidature',
                'second_button_text_fr' => 'Voir les avis',
                'second_button_text_ar' => 'عرض الإعلانات',
                'second_button_url' => '#avis',
                'position' => 1,
            ],
            [
                'section_key' => 'statistiques',
                'section_type' => 'stats',
                'title_fr' => 'Le CQPM Nador en chiffres',
                'title_ar' => 'مركز الناظور بالأرقام',
                'subtitle_fr' => 'Des indicateurs au service de la formation maritime.',
                'subtitle_ar' => 'مؤشرات تعكس جودة التكوين البحري.',
                'extra_data' => [
                    ['label_fr' => 'Diplômés', 'label_ar' => 'الخريجون', 'value' => '1500+'],
                    ['label_fr' => 'Filières', 'label_ar' => 'التكوينات', 'value' => '8'],
                    ['label_fr' => 'Insertion', 'label_ar' => 'الإدماج', 'value' => '85%'],
                    ['label_fr' => 'Années d’expérience', 'label_ar' => 'سنوات الخبرة', 'value' => '15+'],
                ],
                'position' => 2,
            ],
            [
                'section_key' => 'presentation_centre',
                'section_type' => 'text_image',
                'title_fr' => 'Présentation du Centre',
                'title_ar' => 'تقديم المركز',
                'subtitle_fr' => 'Un établissement public dédié aux métiers de la mer.',
                'subtitle_ar' => 'مؤسسة عمومية متخصصة في مهن البحر.',
                'content_fr' => 'Le CQPM Nador assure des formations professionnelles maritimes adaptées aux besoins du secteur. Le centre accompagne les stagiaires avec des programmes pratiques, une pédagogie orientée métier et des équipements conformes aux standards de sécurité maritime.',
                'content_ar' => 'يوفر مركز التأهيل المهني البحري بالناظور تكوينات مهنية بحرية تستجيب لحاجيات القطاع، مع برامج تطبيقية ومواكبة تربوية وتجهيزات منسجمة مع معايير السلامة البحرية.',
                'button_text_fr' => 'Découvrir le centre',
                'button_text_ar' => 'اكتشف المركز',
                'button_url' => '/centre',
                'position' => 3,
            ],
            [
                'section_key' => 'mot_directeur',
                'section_type' => 'text_image',
                'title_fr' => 'Mot du Directeur',
                'title_ar' => 'كلمة المدير',
                'subtitle_fr' => 'Former des professionnels compétents et engagés.',
                'subtitle_ar' => 'تكوين مهنيين أكفاء وملتزمين.',
                'content_fr' => 'Notre mission est de préparer des profils capables d’intégrer le secteur maritime avec rigueur, responsabilité et esprit professionnel. Le CQPM Nador reste engagé pour une formation de qualité au service de l’économie maritime.',
                'content_ar' => 'مهمتنا إعداد كفاءات قادرة على الاندماج في القطاع البحري بجدية ومسؤولية وروح مهنية. يظل المركز ملتزما بتكوين ذي جودة في خدمة الاقتصاد البحري.',
                'position' => 4,
            ],
            [
                'section_key' => 'formations',
                'section_type' => 'cards',
                'title_fr' => 'Filières de formation',
                'title_ar' => 'مسالك التكوين',
                'subtitle_fr' => 'Des formations agréées pour les métiers maritimes.',
                'subtitle_ar' => 'تكوينات معتمدة في المهن البحرية.',
                'button_text_fr' => 'Déposer ma candidature',
                'button_text_ar' => 'إيداع الترشيح',
                'button_url' => '/candidature',
                'position' => 5,
            ],
            [
                'section_key' => 'actualites',
                'section_type' => 'news',
                'title_fr' => 'Actualités & événements',
                'title_ar' => 'الأخبار والأنشطة',
                'subtitle_fr' => 'Suivez les dernières nouvelles du centre.',
                'subtitle_ar' => 'تابع آخر أخبار المركز.',
                'position' => 6,
            ],
            [
                'section_key' => 'documents',
                'section_type' => 'documents',
                'title_fr' => 'Avis & Résultats',
                'title_ar' => 'الإعلانات والنتائج',
                'subtitle_fr' => 'Consultez les avis, résultats et formulaires officiels.',
                'subtitle_ar' => 'اطلع على الإعلانات والنتائج والاستمارات الرسمية.',
                'position' => 7,
            ],
            [
                'section_key' => 'galerie',
                'section_type' => 'gallery',
                'title_fr' => 'Galerie',
                'title_ar' => 'المعرض',
                'subtitle_fr' => 'Aperçu des espaces et activités du centre.',
                'subtitle_ar' => 'لمحات من فضاءات وأنشطة المركز.',
                'extra_data' => [
                    ['title_fr' => 'Ateliers pratiques', 'title_ar' => 'ورشات تطبيقية'],
                    ['title_fr' => 'Formation maritime', 'title_ar' => 'تكوين بحري'],
                    ['title_fr' => 'Vie du centre', 'title_ar' => 'حياة المركز'],
                ],
                'position' => 8,
            ],
            [
                'section_key' => 'appel_action',
                'section_type' => 'cta',
                'title_fr' => 'Prêt à rejoindre la famille CQPM ?',
                'title_ar' => 'هل أنت مستعد للانضمام إلى أسرة المركز؟',
                'content_fr' => 'Les inscriptions sont ouvertes. Déposez votre candidature ou contactez l’administration pour plus d’informations.',
                'content_ar' => 'التسجيلات مفتوحة. أودع ترشيحك أو تواصل مع الإدارة لمزيد من المعلومات.',
                'button_text_fr' => 'S’inscrire maintenant',
                'button_text_ar' => 'سجل الآن',
                'button_url' => '/candidature',
                'second_button_text_fr' => 'Nous contacter',
                'second_button_text_ar' => 'اتصل بنا',
                'second_button_url' => '/reclamation',
                'position' => 9,
            ],
        ];

        foreach ($sections as $data) {
            PageSection::updateOrCreate(
                ['page_id' => $home->id, 'section_key' => $data['section_key']],
                array_merge([
                    'title_fr' => null,
                    'title_ar' => null,
                    'subtitle_fr' => null,
                    'subtitle_ar' => null,
                    'content_fr' => null,
                    'content_ar' => null,
                    'image_path' => null,
                    'video_url' => null,
                    'button_text_fr' => null,
                    'button_text_ar' => null,
                    'button_url' => null,
                    'second_button_text_fr' => null,
                    'second_button_text_ar' => null,
                    'second_button_url' => null,
                    'extra_data' => null,
                    'is_active' => true,
                ], $data)
            );
        }

        Page::clearCmsCache();
    }
}
