<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ── Parent menus ──────────────────────────────────────────────────────────
        $parents = [
            ['slug' => 'accueil',       'title_fr' => 'Accueil',            'title_ar' => 'الرئيسية',             'url' => '/',               'position' => 1, 'footer' => true],
            ['slug' => 'le-centre',     'title_fr' => 'Le Centre',          'title_ar' => 'المركز',               'url' => '/centre',         'position' => 2, 'footer' => true],
            ['slug' => 'formations',    'title_fr' => 'Formations',         'title_ar' => 'التكوينات',            'url' => '/formations',     'position' => 3, 'footer' => true],
            ['slug' => 'admission',     'title_fr' => 'Admission',          'title_ar' => 'التسجيل',             'url' => '/admission',      'position' => 4, 'footer' => true],
            ['slug' => 'actualites',    'title_fr' => 'Actualités',         'title_ar' => 'الأخبار',              'url' => '/news',           'position' => 5, 'footer' => true],
            ['slug' => 'avis-resultats','title_fr' => 'Avis & Résultats',   'title_ar' => 'الإعلانات والنتائج',  'url' => '/documents',      'position' => 6, 'footer' => false],
            ['slug' => 'galerie',       'title_fr' => 'Galerie',            'title_ar' => 'المعرض',               'url' => '/galerie',        'position' => 7, 'footer' => false],
            ['slug' => 'contact',       'title_fr' => 'Contact',            'title_ar' => 'اتصل بنا',             'url' => '/contact',        'position' => 8, 'footer' => true],
        ];

        foreach ($parents as $m) {
            Menu::updateOrCreate(['slug' => $m['slug']], [
                'parent_id'      => null,
                'title_fr'       => $m['title_fr'],
                'title_ar'       => $m['title_ar'],
                'url'            => $m['url'],
                'type'           => 'internal',
                'target'         => '_self',
                'position'       => $m['position'],
                'is_active'      => true,
                'show_in_header' => true,
                'show_in_footer' => $m['footer'],
            ]);
        }

        // ── Sub-menus ─────────────────────────────────────────────────────────────
        $subMenus = [
            // Le Centre
            'le-centre' => [
                ['slug' => 'centre-presentation',   'title_fr' => 'Présentation',         'title_ar' => 'تقديم المركز',       'url' => '/centre/presentation',    'pos' => 1],
                ['slug' => 'centre-mot-directeur',   'title_fr' => 'Mot du Directeur',     'title_ar' => 'كلمة المدير',        'url' => '/centre/mot-directeur',   'pos' => 2],
                ['slug' => 'centre-historique',      'title_fr' => 'Historique',           'title_ar' => 'التاريخ',            'url' => '/centre/historique',      'pos' => 3],
                ['slug' => 'centre-mission-vision',  'title_fr' => 'Mission & Vision',     'title_ar' => 'المهمة والرؤية',     'url' => '/centre/mission-vision',  'pos' => 4],
                ['slug' => 'centre-organigramme',    'title_fr' => 'Organigramme',         'title_ar' => 'الهيكل التنظيمي',   'url' => '/centre/organigramme',    'pos' => 5],
                ['slug' => 'centre-infrastructures', 'title_fr' => 'Infrastructures',      'title_ar' => 'البنيات التحتية',    'url' => '/centre/infrastructures', 'pos' => 6],
                ['slug' => 'centre-partenaires',     'title_fr' => 'Partenaires',          'title_ar' => 'الشركاء',            'url' => '/centre/partenaires',     'pos' => 7],
            ],
            // Formations
            'formations' => [
                ['slug' => 'formations-initiale',       'title_fr' => 'Formation Initiale',      'title_ar' => 'التكوين الأساسي',       'url' => '/formations/initiale',      'pos' => 1],
                ['slug' => 'formations-qualification',  'title_fr' => 'Formation Qualification', 'title_ar' => 'تكوين التأهيل',         'url' => '/formations/qualification', 'pos' => 2],
                ['slug' => 'formations-specialisation', 'title_fr' => 'Spécialisation',          'title_ar' => 'التخصص',                'url' => '/formations/specialisation','pos' => 3],
                ['slug' => 'formations-continue',       'title_fr' => 'Formation Continue',      'title_ar' => 'التكوين المستمر',       'url' => '/formations/continue',      'pos' => 4],
                ['slug' => 'formations-filieres',       'title_fr' => 'Toutes les Filières',     'title_ar' => 'جميع المسالك',          'url' => '/formations/filieres',      'pos' => 5],
            ],
            // Admission
            'admission' => [
                ['slug' => 'admission-conditions',  'title_fr' => 'Conditions d\'accès',      'title_ar' => 'شروط الالتحاق',       'url' => '/admission/conditions',  'pos' => 1],
                ['slug' => 'admission-pieces',      'title_fr' => 'Pièces à fournir',         'title_ar' => 'الوثائق المطلوبة',     'url' => '/admission/pieces',      'pos' => 2],
                ['slug' => 'admission-calendrier',  'title_fr' => 'Calendrier',               'title_ar' => 'الروزنامة',            'url' => '/admission/calendrier',  'pos' => 3],
                ['slug' => 'admission-faq',         'title_fr' => 'FAQ',                      'title_ar' => 'الأسئلة الشائعة',     'url' => '/admission/faq',         'pos' => 4],
                ['slug' => 'candidature',           'title_fr' => 'Inscription / التسجيل',    'title_ar' => 'التسجيل / Inscription','url' => '/candidature',           'pos' => 5],
            ],
            // Actualités
            'actualites' => [
                ['slug' => 'actualites-news',        'title_fr' => 'Actualités',     'title_ar' => 'الأخبار',    'url' => '/news',    'pos' => 1],
                ['slug' => 'actualites-events',      'title_fr' => 'Événements',     'title_ar' => 'الفعاليات',  'url' => '/events',  'pos' => 2],
                ['slug' => 'actualites-communiques', 'title_fr' => 'Communiqués',    'title_ar' => 'بلاغات',     'url' => '/communiques', 'pos' => 3],
            ],
            // Avis & Résultats
            'avis-resultats' => [
                ['slug' => 'docs-avis',           'title_fr' => 'Avis & Annonces',  'title_ar' => 'الإعلانات',        'url' => '/documents/avis',           'pos' => 1],
                ['slug' => 'docs-resultats',      'title_fr' => 'Résultats',        'title_ar' => 'النتائج',          'url' => '/documents/resultats',      'pos' => 2],
                ['slug' => 'docs-admis',          'title_fr' => 'Listes des admis', 'title_ar' => 'قوائم المقبولين',  'url' => '/documents/admis',          'pos' => 3],
                ['slug' => 'docs-telechargements','title_fr' => 'Téléchargements',  'title_ar' => 'التحميلات',        'url' => '/documents/telechargements','pos' => 4],
            ],
            // Galerie
            'galerie' => [
                ['slug' => 'galerie-photos',   'title_fr' => 'Photos',          'title_ar' => 'الصور',       'url' => '/galerie/photos',          'pos' => 1],
                ['slug' => 'galerie-videos',   'title_fr' => 'Vidéos',          'title_ar' => 'الفيديوهات',  'url' => '/galerie/videos',          'pos' => 2],
                ['slug' => 'galerie-events',   'title_fr' => 'Événements',      'title_ar' => 'الفعاليات',   'url' => '/galerie/evenements',      'pos' => 3],
                ['slug' => 'galerie-visite',   'title_fr' => 'Visite Virtuelle', 'title_ar' => 'جولة افتراضية','url' => '/galerie/visite-virtuelle','pos' => 4],
            ],
            // Contact
            'contact' => [
                ['slug' => 'contact-contact',      'title_fr' => 'Nous contacter',     'title_ar' => 'اتصل بنا',        'url' => '/contact',             'pos' => 1],
                ['slug' => 'contact-reclamation',  'title_fr' => 'Réclamation',         'title_ar' => 'شكوى',            'url' => '/reclamation',         'pos' => 2],
                ['slug' => 'contact-renseignement','title_fr' => 'Renseignement',       'title_ar' => 'استفسار',         'url' => '/renseignement',       'pos' => 3],
                ['slug' => 'contact-localisation', 'title_fr' => 'Localisation',        'title_ar' => 'الموقع الجغرافي', 'url' => '/contact/localisation','pos' => 4],
            ],
        ];

        foreach ($subMenus as $parentSlug => $children) {
            $parent = Menu::where('slug', $parentSlug)->first();
            if (!$parent) continue;

            foreach ($children as $child) {
                Menu::updateOrCreate(['slug' => $child['slug']], [
                    'parent_id'      => $parent->id,
                    'title_fr'       => $child['title_fr'],
                    'title_ar'       => $child['title_ar'],
                    'url'            => $child['url'],
                    'type'           => 'internal',
                    'target'         => '_self',
                    'position'       => $child['pos'],
                    'is_active'      => true,
                    'show_in_header' => true,
                    'show_in_footer' => false,
                ]);
            }
        }

        Menu::clearMenuCache();
    }
}
