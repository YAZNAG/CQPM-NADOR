<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // ──────────────────────────────────────────────────────────────────────
        // 1. TOUTES LES PAGES (upsert)
        // ──────────────────────────────────────────────────────────────────────
        $pages = [
            // Core
            ['slug' => 'accueil',                  'title_fr' => 'Accueil',                         'title_ar' => 'الرئيسية',               'pos' => 1],
            ['slug' => 'centre',                   'title_fr' => 'Le Centre',                       'title_ar' => 'المركز',                 'pos' => 2],
            ['slug' => 'centre-presentation',      'title_fr' => 'Présentation du Centre',          'title_ar' => 'تقديم المركز',           'pos' => 3],
            ['slug' => 'centre-mot-directeur',     'title_fr' => 'Mot du Directeur',                'title_ar' => 'كلمة المدير',            'pos' => 4],
            ['slug' => 'centre-historique',        'title_fr' => 'Historique',                      'title_ar' => 'التاريخ',                'pos' => 5],
            ['slug' => 'centre-mission-vision',    'title_fr' => 'Mission & Vision',                'title_ar' => 'المهمة والرؤية',         'pos' => 6],
            ['slug' => 'centre-organigramme',      'title_fr' => 'Organigramme',                    'title_ar' => 'الهيكل التنظيمي',       'pos' => 7],
            ['slug' => 'centre-infrastructures',   'title_fr' => 'Infrastructures',                 'title_ar' => 'البنيات التحتية',       'pos' => 8],
            ['slug' => 'centre-partenaires',       'title_fr' => 'Partenaires',                     'title_ar' => 'الشركاء',                'pos' => 9],
            // Formations
            ['slug' => 'formations',               'title_fr' => 'Nos Formations',                  'title_ar' => 'تكويناتنا',             'pos' => 10],
            ['slug' => 'formations-initiale',      'title_fr' => 'Formation Initiale',              'title_ar' => 'التكوين الأولي',        'pos' => 11],
            ['slug' => 'formations-qualification', 'title_fr' => 'Formation de Qualification',      'title_ar' => 'تكوين التأهيل',         'pos' => 12],
            ['slug' => 'formations-specialisation','title_fr' => 'Formation de Spécialisation',     'title_ar' => 'تكوين التخصص',          'pos' => 13],
            ['slug' => 'formations-continue',      'title_fr' => 'Formation Continue',              'title_ar' => 'التكوين المستمر',       'pos' => 14],
            // Admission
            ['slug' => 'admission',                'title_fr' => 'Admission',                       'title_ar' => 'القبول',                 'pos' => 15],
            ['slug' => 'admission-conditions',     'title_fr' => "Conditions d'Admission",          'title_ar' => 'شروط القبول',           'pos' => 16],
            ['slug' => 'admission-pieces',         'title_fr' => 'Pièces à Fournir',                'title_ar' => 'الوثائق المطلوبة',      'pos' => 17],
            ['slug' => 'admission-calendrier',     'title_fr' => 'Calendrier des Admissions',       'title_ar' => 'تقويم القبولات',        'pos' => 18],
            ['slug' => 'admission-faq',            'title_fr' => 'Questions Fréquentes',            'title_ar' => 'الأسئلة الشائعة',       'pos' => 19],
            // Actualités & docs
            ['slug' => 'actualites',               'title_fr' => 'Actualités',                      'title_ar' => 'الأخبار',                'pos' => 20],
            ['slug' => 'documents',                'title_fr' => 'Documents & Téléchargements',     'title_ar' => 'الوثائق والتحميلات',    'pos' => 21],
            // Vie estudiantine
            ['slug' => 'vie-estudiantine',         'title_fr' => 'Vie Estudiantine',                'title_ar' => 'الحياة الطلابية',       'pos' => 22],
            ['slug' => 'vie-clubs',                'title_fr' => 'Clubs',                           'title_ar' => 'الأندية',                'pos' => 23],
            ['slug' => 'vie-activites',            'title_fr' => 'Activités',                       'title_ar' => 'الأنشطة',                'pos' => 24],
            ['slug' => 'vie-sorties',              'title_fr' => 'Sorties Pédagogiques',            'title_ar' => 'الرحلات التربوية',      'pos' => 25],
            ['slug' => 'vie-temoignages',          'title_fr' => 'Témoignages',                     'title_ar' => 'شهادات الخريجين',       'pos' => 26],
            // Galerie & contact
            ['slug' => 'galerie',                  'title_fr' => 'Galerie',                         'title_ar' => 'المعرض',                 'pos' => 27],
            ['slug' => 'contact',                  'title_fr' => 'Contactez-nous',                  'title_ar' => 'اتصل بنا',               'pos' => 28],
            ['slug' => 'contact-localisation',     'title_fr' => 'Localisation',                    'title_ar' => 'الموقع الجغرافي',       'pos' => 29],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], [
                'title_fr'            => $p['title_fr'],
                'title_ar'            => $p['title_ar'],
                'meta_title_fr'       => $p['title_fr'] . ' — CQPM Nador',
                'meta_title_ar'       => $p['title_ar'] . ' — CQPM الناظور',
                'meta_description_fr' => 'Centre de Qualification Professionnelle Maritime de Nador — ' . $p['title_fr'],
                'meta_description_ar' => 'مركز التأهيل المهني البحري بالناظور — ' . $p['title_ar'],
                'is_active'           => true,
                'show_in_menu'        => true,
                'position'            => $p['pos'],
            ]);
        }

        // ──────────────────────────────────────────────────────────────────────
        // 2. HELPER : insère les sections d'une page (supprime les anciennes)
        // ──────────────────────────────────────────────────────────────────────
        $ins = function (string $slug, array $secs) {
            $page = Page::where('slug', $slug)->first();
            if (! $page) {
                return;
            }
            PageSection::where('page_id', $page->id)->delete();
            foreach ($secs as $s) {
                if (isset($s['extra_data']) && is_array($s['extra_data'])) {
                    $s['extra_data'] = json_encode($s['extra_data'], JSON_UNESCAPED_UNICODE);
                }
                PageSection::create(array_merge([
                    'page_id'               => $page->id,
                    'is_active'             => true,
                    'image_path'            => null,
                    'video_url'             => null,
                    'subtitle_fr'           => null,
                    'subtitle_ar'           => null,
                    'content_fr'            => null,
                    'content_ar'            => null,
                    'button_text_fr'        => null,
                    'button_text_ar'        => null,
                    'button_url'            => null,
                    'second_button_text_fr' => null,
                    'second_button_text_ar' => null,
                    'second_button_url'     => null,
                    'extra_data'            => null,
                ], $s));
            }
        };

        // ──────────────────────────────────────────────────────────────────────
        // 3. ACCUEIL
        // ──────────────────────────────────────────────────────────────────────
        $ins('accueil', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Centre de Qualification Professionnelle Maritime de Nador',
             'title_ar' => 'مركز التأهيل المهني البحري بالناظور',
             'subtitle_fr' => 'CQPM Nador — Formez-vous aux métiers de la mer',
             'subtitle_ar' => 'CQPM الناظور — تكوّن في مهن البحر',
             'content_fr' => "Établissement public de formation maritime reconnu nationalement, le CQPM Nador prépare depuis 15 ans des techniciens et cadres compétents pour le secteur halieutique de la région de l'Oriental.",
             'content_ar' => "مؤسسة عمومية للتكوين البحري معترف بها وطنياً، يُعدّ CQPM الناظور منذ 15 سنة تقنيين وأطراً كفؤة للقطاع السمكي في جهة الشرق.",
             'button_text_fr' => 'Déposer ma candidature', 'button_text_ar' => 'تقديم ترشيحي', 'button_url' => '/candidature',
             'second_button_text_fr' => 'Découvrir les formations', 'second_button_text_ar' => 'اكتشف التكوينات', 'second_button_url' => '/formations',
             'extra_data' => [
                 ['label_fr' => 'Diplômés formés', 'label_ar' => 'الخريجون المتكوّنون', 'value' => '1500+'],
                 ['label_fr' => 'Filières actives', 'label_ar' => 'مسارات التكوين',      'value' => '6'],
                 ['label_fr' => "Taux d'insertion",  'label_ar' => 'معدل الإدماج',        'value' => '85%'],
                 ['label_fr' => "Années d'expérience",'label_ar' => 'سنوات الخبرة',       'value' => '15+'],
             ]],

            ['section_key' => 'stats', 'section_type' => 'stats', 'position' => 2,
             'title_fr' => 'Le CQPM Nador en chiffres', 'title_ar' => 'CQPM الناظور بالأرقام',
             'subtitle_fr' => "L'excellence maritime depuis 2008", 'subtitle_ar' => 'التميز البحري منذ 2008',
             'extra_data' => [
                 ['label_fr' => 'Diplômés depuis 2008', 'label_ar' => 'خريج منذ 2008',          'value' => '1500'],
                 ['label_fr' => 'Filières de formation', 'label_ar' => 'مسارات التكوين',          'value' => '6'],
                 ['label_fr' => "Taux d'insertion prof.",'label_ar' => 'نسبة الإدماج المهني',     'value' => '85'],
                 ['label_fr' => 'Partenaires sectoriels','label_ar' => 'شركاء قطاعيون',           'value' => '20'],
             ]],

            ['section_key' => 'presentation_centre', 'section_type' => 'text_image', 'position' => 3,
             'title_fr' => 'Notre Centre Maritime',  'title_ar' => 'مركزنا البحري',
             'subtitle_fr' => 'Présentation',         'subtitle_ar' => 'تقديم',
             'content_fr' => "Le Centre de Qualification Professionnelle Maritime de Nador est un établissement public placé sous la tutelle du Département de la Pêche Maritime du Maroc.\n\nFondé pour répondre aux besoins en ressources humaines qualifiées du secteur halieutique de l'Oriental, le CQPM Nador dispense des formations reconnues permettant aux diplômés d'exercer des métiers de la mer en toute compétence et sécurité.",
             'content_ar' => "مركز التأهيل المهني البحري بالناظور مؤسسة عمومية تابعة لقطاع الصيد البحري بالمغرب.\n\nتأسس للاستجابة لاحتياجات القطاع السمكي في جهة الشرق، ويوفر تكوينات معترفاً بها تمكّن الخريجين من ممارسة مهن البحر بكفاءة وأمان.",
             'button_text_fr' => 'En savoir plus', 'button_text_ar' => 'معرفة المزيد', 'button_url' => '/centre'],

            ['section_key' => 'filieres_cards', 'section_type' => 'cards', 'position' => 4,
             'title_fr' => 'Nos Filières de Formation', 'title_ar' => 'مساراتنا التكوينية',
             'subtitle_fr' => 'Choisissez votre voie maritime', 'subtitle_ar' => 'اختر مسارك في البحر',
             'button_text_fr' => 'Voir toutes les filières', 'button_text_ar' => 'مشاهدة جميع المسارات', 'button_url' => '/formations/filieres'],

            ['section_key' => 'actualites_news', 'section_type' => 'news', 'position' => 5,
             'title_fr' => 'Dernières Actualités', 'title_ar' => 'آخر الأخبار',
             'subtitle_fr' => 'Restez informé des nouvelles du CQPM', 'subtitle_ar' => 'ابقَ على اطلاع بأخبار CQPM',
             'button_text_fr' => 'Toutes les actualités', 'button_text_ar' => 'جميع الأخبار', 'button_url' => '/news'],

            ['section_key' => 'avis_documents', 'section_type' => 'documents', 'position' => 6,
             'title_fr' => 'Avis & Résultats', 'title_ar' => 'الإعلانات والنتائج',
             'subtitle_fr' => 'Consultez les dernières publications officielles', 'subtitle_ar' => 'اطلع على آخر المنشورات الرسمية',
             'button_text_fr' => 'Tous les documents', 'button_text_ar' => 'جميع الوثائق', 'button_url' => '/documents'],

            ['section_key' => 'galerie_home', 'section_type' => 'gallery', 'position' => 7,
             'title_fr' => 'Notre Galerie', 'title_ar' => 'معرضنا',
             'subtitle_fr' => 'La vie au CQPM en images', 'subtitle_ar' => 'الحياة في CQPM بالصور',
             'button_text_fr' => 'Voir la galerie complète', 'button_text_ar' => 'مشاهدة المعرض كاملًا', 'button_url' => '/galerie'],

            ['section_key' => 'cta_inscription', 'section_type' => 'cta', 'position' => 8,
             'title_fr' => 'Rejoignez la prochaine promotion du CQPM Nador !',
             'title_ar' => 'انضم إلى الدفعة القادمة لـCQPM الناظور!',
             'content_fr' => "Les candidatures pour l'année de formation 2025-2026 sont ouvertes. Ne manquez pas cette opportunité de vous former aux métiers de la mer.",
             'content_ar' => "ترشيحات السنة التكوينية 2025-2026 مفتوحة. لا تفوت فرصة التكوين في مهن البحر.",
             'button_text_fr' => 'Déposer ma candidature maintenant', 'button_text_ar' => 'تقديم ترشيحي الآن', 'button_url' => '/candidature',
             'second_button_text_fr' => "Conditions d'accès", 'second_button_text_ar' => 'شروط القبول', 'second_button_url' => '/admission/conditions'],
        ]);

        // ──────────────────────────────────────────────────────────────────────
        // 4. CENTRE (page principale)
        // ──────────────────────────────────────────────────────────────────────
        $ins('centre', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Centre de Qualification Professionnelle Maritime de Nador',
             'title_ar' => 'مركز التأهيل المهني البحري بالناظور',
             'subtitle_fr' => 'CQPM Nador — Depuis 2008',
             'subtitle_ar' => 'CQPM الناظور — منذ 2008',
             'content_fr' => "Établissement de référence pour la formation maritime dans la région de l'Oriental.",
             'content_ar' => "مؤسسة مرجعية للتكوين البحري في جهة الشرق.",
             'button_text_fr' => 'Déposer ma candidature', 'button_text_ar' => 'تقديم ترشيحي', 'button_url' => '/candidature',
             'extra_data' => [
                 ['label_fr' => 'Diplômés', 'label_ar' => 'الخريجون', 'value' => '1500+'],
                 ['label_fr' => 'Filières', 'label_ar' => 'المسارات',  'value' => '6'],
                 ['label_fr' => 'Insertion','label_ar' => 'الإدماج',   'value' => '85%'],
                 ['label_fr' => 'Années',   'label_ar' => 'سنوات',     'value' => '15+'],
             ]],

            ['section_key' => 'presentation', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Notre Mission', 'title_ar' => 'مهمتنا',
             'subtitle_fr' => 'À propos du CQPM', 'subtitle_ar' => 'حول CQPM',
             'content_fr' => "Le CQPM Nador est un établissement public de formation professionnelle placé sous la tutelle du Département de la Pêche Maritime du Maroc. Sa mission est de former des techniciens et des cadres compétents dans les domaines de la navigation maritime, des machines marines, de la pêche artisanale, de la sécurité en mer et de l'aquaculture.\n\nSitué au cœur du Port de Nador, le centre bénéficie d'une situation géographique privilégiée qui lui permet de dispenser des formations pratiques directement sur le terrain.",
             'content_ar' => "CQPM الناظور مؤسسة عمومية للتكوين المهني تابعة لقطاع الصيد البحري بالمغرب. مهمته تكوين تقنيين وأطر كفؤة في مجالات الملاحة البحرية والآلات البحرية والصيد الحرفي والسلامة في البحر وتربية الأحياء المائية.\n\nيقع المركز في قلب ميناء الناظور مما يمنحه موقعاً جغرافياً متميزاً يسمح له بتقديم تكوينات تطبيقية مباشرة في الميدان.",
             'button_text_fr' => 'Nos formations', 'button_text_ar' => 'تكويناتنا', 'button_url' => '/formations'],

            ['section_key' => 'valeurs', 'section_type' => 'text_image', 'position' => 3,
             'title_fr' => 'Nos Valeurs', 'title_ar' => 'قيمنا',
             'subtitle_fr' => 'Ce qui nous définit', 'subtitle_ar' => 'ما يُعرّفنا',
             'content_fr' => "• Excellence : Nous visons l'excellence dans chaque formation dispensée\n• Sécurité : La sécurité maritime est au cœur de notre enseignement\n• Responsabilité : Former des professionnels responsables et éthiques\n• Innovation : Adapter constamment nos programmes aux évolutions du secteur\n• Ouverture : Favoriser les échanges et les partenariats nationaux et internationaux",
             'content_ar' => "• التميز: نسعى للتميز في كل تكوين نقدمه\n• السلامة: السلامة البحرية في صميم تعليمنا\n• المسؤولية: تكوين مهنيين مسؤولين وأخلاقيين\n• الابتكار: التكيف المستمر مع تطورات القطاع\n• الانفتاح: تعزيز التبادلات والشراكات الوطنية والدولية",
             'button_text_fr' => 'Rejoindre le CQPM', 'button_text_ar' => 'الانضمام إلى CQPM', 'button_url' => '/admission'],

            ['section_key' => 'cta', 'section_type' => 'cta', 'position' => 4,
             'title_fr' => 'Prêt à construire votre avenir maritime ?',
             'title_ar' => 'مستعد لبناء مستقبلك البحري؟',
             'content_fr' => "Rejoignez le CQPM Nador et bénéficiez d'une formation de qualité reconnue nationalement.",
             'content_ar' => "انضم إلى CQPM الناظور واستفد من تكوين عالي الجودة معترف به وطنياً.",
             'button_text_fr' => 'Déposer ma candidature', 'button_text_ar' => 'تقديم الترشيح', 'button_url' => '/candidature'],
        ]);

        // ──────────────────────────────────────────────────────────────────────
        // 5. CENTRE — sous-pages
        // ──────────────────────────────────────────────────────────────────────
        $ins('centre-presentation', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Présentation du Centre', 'title_ar' => 'تقديم المركز',
             'subtitle_fr' => 'CQPM Nador', 'subtitle_ar' => 'CQPM الناظور',
             'content_fr' => "Découvrez l'histoire, la mission et les valeurs du Centre de Qualification Professionnelle Maritime de Nador.",
             'content_ar' => "اكتشف تاريخ ومهمة وقيم مركز التأهيل المهني البحري بالناظور.",
             'button_text_fr' => 'Voir nos formations', 'button_text_ar' => 'مشاهدة تكويناتنا', 'button_url' => '/formations'],
            ['section_key' => 'desc', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Un Centre Maritime de Référence', 'title_ar' => 'مركز بحري مرجعي',
             'subtitle_fr' => 'Notre identité', 'subtitle_ar' => 'هويتنا',
             'content_fr' => "Le Centre de Qualification Professionnelle Maritime de Nador (CQPM) est un établissement public de formation professionnelle maritime, créé dans le cadre de la stratégie nationale de développement du secteur halieutique.\n\nInstallé dans le complexe portuaire de Nador, le CQPM dispose de plateaux techniques modernes, de bassins de simulation et de salles de cours bien équipées.\n\nSes formations s'étendent de la navigation maritime aux techniques de transformation des produits de la mer, en passant par la mécanique navale, la pêche artisanale, la sécurité maritime et l'aquaculture.",
             'content_ar' => "مركز التأهيل المهني البحري بالناظور مؤسسة عمومية للتكوين المهني البحري أُنشئت في إطار الاستراتيجية الوطنية لتنمية القطاع السمكي.\n\nيتوفر CQPM على ورشات تقنية حديثة وأحواض محاكاة وقاعات دراسية مجهزة جيداً.\n\nتمتد برامجه من الملاحة البحرية إلى تقنيات تحويل منتجات البحر، مروراً بالميكانيكا البحرية والصيد الحرفي والسلامة البحرية وتربية الأحياء المائية.",
             'button_text_fr' => "S'inscrire", 'button_text_ar' => 'التسجيل', 'button_url' => '/candidature'],
        ]);

        $ins('centre-mot-directeur', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Mot du Directeur', 'title_ar' => 'كلمة المدير',
             'subtitle_fr' => 'Message de la direction', 'subtitle_ar' => 'رسالة الإدارة',
             'content_fr' => "Un message du directeur du CQPM Nador adressé aux candidats, aux familles et aux partenaires.",
             'content_ar' => "رسالة مدير CQPM الناظور إلى المرشحين والعائلات والشركاء.",
             'button_text_fr' => 'Postuler', 'button_text_ar' => 'تقديم الطلب', 'button_url' => '/candidature'],
            ['section_key' => 'message', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Message du Directeur', 'title_ar' => 'كلمة المدير',
             'subtitle_fr' => 'Vision & Engagement', 'subtitle_ar' => 'الرؤية والالتزام',
             'content_fr' => "Chers candidats, chères familles,\n\nC'est avec une grande fierté que je vous accueille au Centre de Qualification Professionnelle Maritime de Nador. Notre établissement s'est imposé comme une référence nationale dans le domaine de la formation maritime, en formant depuis plus de 15 ans des professionnels compétents et passionnés des métiers de la mer.\n\nNotre engagement est simple : vous offrir une formation d'excellence qui répond aux besoins réels du marché du travail maritime, tout en vous préparant à relever les défis d'un secteur en pleine mutation.\n\nJe vous invite à découvrir nos filières et à rejoindre notre communauté d'apprenants passionnés. Votre avenir maritime commence ici, à Nador.\n\nLe Directeur du CQPM Nador",
             'content_ar' => "المترشحون الأعزاء، العائلات الكريمة،\n\nيسعدني الترحيب بكم في مركز التأهيل المهني البحري بالناظور. فرض مركزنا نفسه مرجعاً وطنياً في مجال التكوين البحري، إذ يُكوّن منذ أكثر من 15 سنة مهنيين أكفاء ومتحمسين لمهن البحر.\n\nالتزامنا بسيط: تزويدكم بتكوين متميز يستجيب للاحتياجات الحقيقية لسوق الشغل البحري.\n\nأدعوكم لاكتشاف مساراتنا والانضمام إلى مجتمع متعلمينا. مستقبلكم البحري يبدأ هنا، في الناظور.\n\nمدير CQPM الناظور",
             'button_text_fr' => 'Découvrir nos formations', 'button_text_ar' => 'اكتشف تكويناتنا', 'button_url' => '/formations'],
        ]);

        $ins('centre-historique', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Notre Historique', 'title_ar' => 'تاريخنا',
             'subtitle_fr' => 'Plus de 15 ans de formation maritime', 'subtitle_ar' => 'أكثر من 15 سنة من التكوين البحري',
             'content_fr' => "Retracez le parcours du CQPM Nador depuis sa création jusqu'à aujourd'hui.",
             'content_ar' => "تتبع مسيرة CQPM الناظور من تأسيسه حتى اليوم.",
             'button_text_fr' => 'Voir les formations', 'button_text_ar' => 'مشاهدة التكوينات', 'button_url' => '/formations'],
            ['section_key' => 'timeline', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Une Décennie de Excellence Maritime', 'title_ar' => 'عقد من التميز البحري',
             'subtitle_fr' => 'Notre évolution', 'subtitle_ar' => 'مسيرتنا',
             'content_fr' => "2008 — Création du CQPM Nador\nOuverture officielle du centre avec les premières filières navigation et machine maritime.\n\n2010 — Développement des infrastructures\nExtension des ateliers techniques et acquisition de nouveaux équipements de simulation.\n\n2013 — Nouvelles filières\nLancement des filières Pêche Artisanale et Sécurité Maritime.\n\n2016 — Partenariats institutionnels\nSignature de conventions avec les principaux armateurs et entreprises du secteur.\n\n2019 — Modernisation\nMise en place de nouveaux programmes pédagogiques alignés sur les standards STCW.\n\n2022 — Filières innovantes\nLancement des filières Aquaculture et Transformation des Produits de la Mer.\n\n2024 — CQPM Today\nPlus de 1500 diplômés formés, 6 filières actives, taux d'insertion de 85%.",
             'content_ar' => "2008 — تأسيس CQPM الناظور\nالافتتاح الرسمي بمسارات الملاحة البحرية وآلات السفن.\n\n2010 — تطوير البنيات التحتية\nتوسيع الورشات التقنية واقتناء معدات محاكاة جديدة.\n\n2013 — مسارات جديدة\nإطلاق مسارات الصيد الحرفي والسلامة البحرية.\n\n2016 — شراكات مؤسسية\nتوقيع اتفاقيات مع ملاك السفن وشركات القطاع البحري في الجهة.\n\n2019 — التحديث\nوضع برامج تربوية جديدة متوافقة مع المعايير الدولية STCW.\n\n2022 — مسارات مبتكرة\nإطلاق مسارات تربية الأحياء المائية وتحويل منتجات البحر.\n\n2024 — CQPM اليوم\nأكثر من 1500 خريج، 6 مسارات نشطة، نسبة إدماج 85%.",
             'button_text_fr' => "S'inscrire", 'button_text_ar' => 'التسجيل', 'button_url' => '/candidature'],
        ]);

        $ins('centre-mission-vision', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Mission & Vision', 'title_ar' => 'المهمة والرؤية',
             'subtitle_fr' => "Notre raison d'être", 'subtitle_ar' => 'سبب وجودنا',
             'content_fr' => "Découvrez les missions et la vision stratégique qui guident le CQPM Nador.",
             'content_ar' => "اكتشف المهام والرؤية الاستراتيجية التي توجه CQPM الناظور.",
             'button_text_fr' => 'Nos formations', 'button_text_ar' => 'تكويناتنا', 'button_url' => '/formations'],
            ['section_key' => 'mission', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Notre Mission', 'title_ar' => 'مهمتنا',
             'subtitle_fr' => 'Former les professionnels de la mer', 'subtitle_ar' => 'تكوين مهنيي البحر',
             'content_fr' => "La mission du CQPM Nador s'articule autour de trois axes fondamentaux :\n\n1. FORMATION INITIALE — Préparer les jeunes candidats aux métiers de la mer grâce à des formations qualifiantes et diplômantes.\n\n2. FORMATION CONTINUE — Accompagner les professionnels en exercice dans la mise à niveau de leurs compétences.\n\n3. INSERTION PROFESSIONNELLE — Faciliter l'intégration des diplômés dans le marché du travail maritime.",
             'content_ar' => "تتمحور مهمة CQPM الناظور حول ثلاثة محاور أساسية:\n\n1. التكوين الأولي — إعداد المترشحين الشباب لمهن البحر عبر تكوينات مؤهِّلة ومثمِّنة.\n\n2. التكوين المستمر — مرافقة المهنيين لتحديث كفاءاتهم والامتثال للمعايير الدولية.\n\n3. الإدماج المهني — تسهيل اندماج الخريجين في سوق الشغل البحري.",
             'button_text_fr' => 'Notre vision', 'button_text_ar' => 'رؤيتنا', 'button_url' => '/centre'],
            ['section_key' => 'vision', 'section_type' => 'text_image', 'position' => 3,
             'title_fr' => 'Notre Vision', 'title_ar' => 'رؤيتنا',
             'subtitle_fr' => 'Horizon 2030', 'subtitle_ar' => 'أفق 2030',
             'content_fr' => "Le CQPM Nador aspire à devenir d'ici 2030 le centre de formation maritime de référence au Maroc, reconnu pour :\n\n• L'excellence de ses formations certifiées aux standards internationaux STCW\n• Son rayonnement régional et ses partenariats méditerranéens\n• Son rôle moteur dans le développement durable du secteur halieutique\n• Sa capacité à former des cadres face aux défis de la transition écologique",
             'content_ar' => "يطمح CQPM الناظور بحلول 2030 إلى أن يصبح مركز التكوين البحري المرجعي في المغرب، المعترف به:\n\n• بتميز تكويناته المعتمدة وفق المعايير الدولية STCW\n• بإشعاعه الجهوي وشراكاته المتوسطية\n• بدوره المحرك في التنمية المستدامة للقطاع السمكي\n• بقدرته على تكوين أطر لمواجهة تحديات التحول البيئي",
             'button_text_fr' => "S'inscrire", 'button_text_ar' => 'التسجيل', 'button_url' => '/candidature'],
        ]);

        $ins('centre-organigramme', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Organigramme du Centre', 'title_ar' => 'الهيكل التنظيمي للمركز',
             'subtitle_fr' => 'Notre organisation', 'subtitle_ar' => 'تنظيمنا',
             'content_fr' => "Découvrez la structure organisationnelle du CQPM Nador.",
             'content_ar' => "اكتشف الهيكل التنظيمي لـCQPM الناظور.",
             'button_text_fr' => 'Nous contacter', 'button_text_ar' => 'تواصل معنا', 'button_url' => '/contact'],
            ['section_key' => 'org', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Structure Organisationnelle', 'title_ar' => 'البنية التنظيمية',
             'subtitle_fr' => 'Notre équipe de direction', 'subtitle_ar' => 'فريق الإدارة',
             'content_fr' => "DIRECTION GÉNÉRALE\n│\n├── Direction Administrative et Financière\n│   ├── Service des Ressources Humaines\n│   └── Service Comptabilité\n│\n├── Direction Pédagogique\n│   ├── Département Navigation Maritime\n│   ├── Département Machine Maritime\n│   ├── Département Pêche et Aquaculture\n│   └── Département Sécurité Maritime\n│\n└── Service des Relations Extérieures\n    ├── Admission et Candidatures\n    └── Partenariats et Insertion",
             'content_ar' => "الإدارة العامة\n│\n├── المديرية الإدارية والمالية\n│   ├── مصلحة الموارد البشرية\n│   └── مصلحة المحاسبة\n│\n├── المديرية التربوية\n│   ├── قسم الملاحة البحرية\n│   ├── قسم آلات السفن\n│   ├── قسم الصيد والأحياء المائية\n│   └── قسم السلامة البحرية\n│\n└── مصلحة العلاقات الخارجية\n    ├── القبول والترشيحات\n    └── الشراكات والإدماج",
             'button_text_fr' => 'Contacter la direction', 'button_text_ar' => 'التواصل مع الإدارة', 'button_url' => '/contact'],
        ]);

        $ins('centre-infrastructures', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Nos Infrastructures', 'title_ar' => 'بنياتنا التحتية',
             'subtitle_fr' => 'Des équipements modernes au service de la formation', 'subtitle_ar' => 'معدات حديثة في خدمة التكوين',
             'content_fr' => "Le CQPM Nador dispose d'infrastructures modernes dédiées à la formation maritime.",
             'content_ar' => "يتوفر CQPM الناظور على بنيات تحتية حديثة مخصصة للتكوين البحري.",
             'button_text_fr' => 'Voir les formations', 'button_text_ar' => 'مشاهدة التكوينات', 'button_url' => '/formations'],
            ['section_key' => 'infra', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Nos Équipements', 'title_ar' => 'معداتنا',
             'subtitle_fr' => 'Pour une formation de qualité', 'subtitle_ar' => 'من أجل تكوين عالي الجودة',
             'content_fr' => "ATELIERS TECHNIQUES\n• Atelier moteurs diesel marins (6 postes de travail)\n• Atelier électricité navale\n• Atelier hydraulique et pneumatique\n• Chambre froide et ateliers de transformation\n\nSALLES SPÉCIALISÉES\n• Salle de simulation navigation ECDIS/Radar\n• Salle GMDSS (communication maritime)\n• Salle de cartographie marine\n• Laboratoire ichtyologie et aquaculture\n\nÉQUIPEMENTS DE SÉCURITÉ\n• Piscine de survie et formation aux techniques de sauvetage\n• Radeau de survie et matériel EPIRB\n• Combinaisons de survie et gilets de sauvetage\n\nAUTRES INFRASTRUCTURES\n• Bibliothèque maritime (3000+ ouvrages)\n• Cafétéria et espaces de détente\n• Parking sécurisé",
             'content_ar' => "الورشات التقنية\n• ورشة محركات الديزل البحرية (6 مناصب)\n• ورشة الكهرباء البحرية\n• ورشة الهيدروليك والهواء المضغوط\n• غرفة تبريد وورشات تحويل المنتجات\n\nقاعات متخصصة\n• قاعة محاكاة الملاحة ECDIS/رادار\n• قاعة GMDSS (الاتصالات البحرية)\n• قاعة الخرائط البحرية\n• مختبر علم الأسماك وتربية الأحياء المائية\n\nمعدات السلامة\n• مسبح النجاة والتدريب على تقنيات الإنقاذ\n• طوافة النجاة ومعدات EPIRB\n• بدلات النجاة وأحزمة الإنقاذ\n\nبنيات أخرى\n• مكتبة بحرية (+3000 كتاب)\n• مقهى وفضاءات للراحة\n• موقف سيارات مؤمّن",
             'button_text_fr' => 'Visiter le centre', 'button_text_ar' => 'زيارة المركز', 'button_url' => '/contact'],
        ]);

        $ins('centre-partenaires', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Nos Partenaires', 'title_ar' => 'شركاؤنا',
             'subtitle_fr' => 'Un réseau de partenaires solide', 'subtitle_ar' => 'شبكة شراكات متينة',
             'content_fr' => "Le CQPM Nador collabore avec les principaux acteurs du secteur maritime et halieutique.",
             'content_ar' => "يتعاون CQPM الناظور مع الفاعلين الرئيسيين في القطاع البحري والسمكي.",
             'button_text_fr' => 'Nous contacter', 'button_text_ar' => 'تواصل معنا', 'button_url' => '/contact'],
            ['section_key' => 'partenaires', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Nos Partenaires Institutionnels', 'title_ar' => 'شركاؤنا المؤسسيون',
             'subtitle_fr' => 'Secteur public et privé', 'subtitle_ar' => 'القطاع العام والخاص',
             'content_fr' => "PARTENAIRES INSTITUTIONNELS\n• Département de la Pêche Maritime (tutelle)\n• Office National des Pêches (ONP)\n• Agence Nationale des Ports (ANP)\n• Délégation Régionale de la Pêche Maritime de Nador\n• Chambre des Pêches Maritimes de la Méditerranée\n\nPARTENAIRES PRIVÉS\n• Armateurs de la région de l'Oriental\n• Coopératives de pêche de Nador et Ras El Ma\n• Unités de transformation du poisson de la région\n• Sociétés de services maritimes portuaires\n\nPARTENAIRES ACADÉMIQUES\n• Université Mohammed Premier d'Oujda\n• Institut des Pêches Maritimes d'Al Hoceima\n• Centres de formation maritime méditerranéens",
             'content_ar' => "الشركاء المؤسسيون\n• قطاع الصيد البحري (الوصاية)\n• المكتب الوطني للصيد (ONP)\n• الوكالة الوطنية للموانئ (ANP)\n• النيابة الجهوية لقطاع الصيد البحري بالناظور\n• غرفة الصيد البحري للبحر الأبيض المتوسط\n\nالشركاء الخواص\n• مالكو السفن في جهة الشرق\n• تعاونيات الصيد بالناظور ورأس الماء\n• وحدات تحويل السمك في الجهة\n• شركات الخدمات البحرية الميناوية\n\nالشركاء الأكاديميون\n• جامعة محمد الأول بوجدة\n• معهد الصيد البحري بالحسيمة\n• مراكز التكوين البحري المتوسطية",
             'button_text_fr' => 'Devenir partenaire', 'button_text_ar' => 'أصبح شريكاً', 'button_url' => '/contact'],
        ]);

        // ──────────────────────────────────────────────────────────────────────
        // 6. FORMATIONS
        // ──────────────────────────────────────────────────────────────────────
        $ins('formations', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Nos Formations Maritimes', 'title_ar' => 'تكويناتنا البحرية',
             'subtitle_fr' => 'CQPM Nador — Excellence maritime', 'subtitle_ar' => 'CQPM الناظور — التميز البحري',
             'content_fr' => "Le CQPM Nador propose une gamme complète de formations maritimes adaptées aux besoins du marché du travail halieutique, avec des programmes reconnus nationalement et conformes aux standards internationaux.",
             'content_ar' => "يقدم CQPM الناظور مجموعة متكاملة من التكوينات البحرية المتناسبة مع متطلبات سوق الشغل السمكي، ببرامج معترف بها وطنياً ومطابقة للمعايير الدولية.",
             'button_text_fr' => 'Voir les filières', 'button_text_ar' => 'مشاهدة المسارات', 'button_url' => '/formations/filieres',
             'second_button_text_fr' => 'Postuler', 'second_button_text_ar' => 'تقديم الطلب', 'second_button_url' => '/candidature'],
            ['section_key' => 'types', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Types de Formation', 'title_ar' => 'أنواع التكوين',
             'subtitle_fr' => 'Notre offre pédagogique', 'subtitle_ar' => 'عرضنا التربوي',
             'content_fr' => "FORMATION INITIALE\nPour les nouveaux entrants dans le secteur maritime. Durée : 12 à 24 mois. Diplôme reconnu par l'État.\n\nFORMATION DE QUALIFICATION\nPour obtenir des certifications professionnelles spécifiques. Durée : 6 à 12 mois.\n\nFORMATION DE SPÉCIALISATION\nPour approfondir une expertise dans un domaine précis. Durée : 3 à 6 mois.\n\nFORMATION CONTINUE\nPour les professionnels souhaitant se perfectionner. Durée variable.",
             'content_ar' => "التكوين الأولي\nللراغبين في دخول القطاع البحري لأول مرة. المدة: 12 إلى 24 شهراً.\n\nتكوين التأهيل\nللحصول على شهادات مهنية محددة. المدة: 6 إلى 12 شهراً.\n\nتكوين التخصص\nلتعميق الخبرة في مجال محدد. المدة: 3 إلى 6 أشهر.\n\nالتكوين المستمر\nللمهنيين الراغبين في التحسين. المدة متغيرة.",
             'button_text_fr' => "S'inscrire", 'button_text_ar' => 'التسجيل', 'button_url' => '/candidature'],
            ['section_key' => 'filieres', 'section_type' => 'cards', 'position' => 3,
             'title_fr' => 'Nos Filières', 'title_ar' => 'مساراتنا',
             'subtitle_fr' => 'Choisissez votre spécialité maritime', 'subtitle_ar' => 'اختر تخصصك البحري',
             'button_text_fr' => 'Postuler', 'button_text_ar' => 'تقديم الطلب', 'button_url' => '/candidature'],
            ['section_key' => 'cta', 'section_type' => 'cta', 'position' => 4,
             'title_fr' => 'Prêt à commencer votre carrière maritime ?',
             'title_ar' => 'مستعد لبدء مسيرتك المهنية البحرية؟',
             'content_fr' => "Déposez votre candidature en ligne et rejoignez la prochaine promotion du CQPM Nador.",
             'content_ar' => "قدّم ترشيحك عبر الإنترنت وانضم إلى الدفعة القادمة.",
             'button_text_fr' => 'Déposer ma candidature', 'button_text_ar' => 'تقديم الترشيح', 'button_url' => '/candidature'],
        ]);

        // ──────────────────────────────────────────────────────────────────────
        // 7. ADMISSION
        // ──────────────────────────────────────────────────────────────────────
        $ins('admission', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Admission au CQPM Nador', 'title_ar' => 'القبول في CQPM الناظور',
             'subtitle_fr' => 'Candidature en ligne ouverte', 'subtitle_ar' => 'الترشيح عبر الإنترنت مفتوح',
             'content_fr' => "Déposez votre candidature en ligne pour rejoindre la prochaine promotion. Consultez les conditions d'accès et préparez votre dossier.",
             'content_ar' => "قدّم ترشيحك عبر الإنترنت للانضمام إلى الدفعة القادمة. اطلع على شروط القبول وأعدّ ملفك.",
             'button_text_fr' => 'Candidater maintenant', 'button_text_ar' => 'تقديم الترشيح الآن', 'button_url' => '/candidature',
             'second_button_text_fr' => "Conditions d'accès", 'second_button_text_ar' => 'شروط القبول', 'second_button_url' => '/admission/conditions'],
            ['section_key' => 'procedure', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => "Procédure d'Admission", 'title_ar' => 'إجراءات القبول',
             'subtitle_fr' => "Comment s'inscrire ?", 'subtitle_ar' => 'كيف تسجل؟',
             'content_fr' => "L'admission au CQPM Nador se déroule en 6 étapes :\n\nÉtape 1 — Vérifier les conditions d'accès\nConsultez les conditions générales et spécifiques à la filière choisie.\n\nÉtape 2 — Constituer votre dossier\nRéunissez toutes les pièces justificatives requises.\n\nÉtape 3 — Déposer en ligne\nSoumettez votre dossier via notre formulaire en ligne sécurisé.\n\nÉtape 4 — Traitement du dossier\nVotre dossier est étudié par la commission sous 15 jours ouvrés.\n\nÉtape 5 — Résultat\nVous êtes notifié par e-mail et SMS.\n\nÉtape 6 — Inscription définitive\nEn cas d'admission, procédez à l'inscription administrative.",
             'content_ar' => "يتم القبول في 6 خطوات:\n\nالخطوة 1 — التحقق من شروط القبول\nاطلع على الشروط العامة والخاصة بالمسار.\n\nالخطوة 2 — إعداد الملف\nاجمع جميع الوثائق المطلوبة.\n\nالخطوة 3 — الإيداع عبر الإنترنت\nقدّم ملف ترشيحك عبر نموذجنا الإلكتروني.\n\nالخطوة 4 — معالجة الملف\nتدرس لجنة الانتقاء ملفك في 15 يوم عمل.\n\nالخطوة 5 — النتيجة\nتتلقى إشعاراً عبر البريد الإلكتروني والرسائل القصيرة.\n\nالخطوة 6 — التسجيل النهائي\nأجرِ التسجيل الإداري في الآجال المحددة.",
             'button_text_fr' => 'Voir les conditions', 'button_text_ar' => 'مشاهدة الشروط', 'button_url' => '/admission/conditions'],
            ['section_key' => 'cta', 'section_type' => 'cta', 'position' => 3,
             'title_fr' => 'Prêt à rejoindre le CQPM ?', 'title_ar' => 'مستعد للانضمام إلى CQPM؟',
             'content_fr' => "Constituez votre dossier et déposez votre candidature en ligne maintenant.",
             'content_ar' => "أعدّ ملفك وقدّم ترشيحك عبر الإنترنت الآن.",
             'button_text_fr' => 'Déposer ma candidature', 'button_text_ar' => 'تقديم الترشيح', 'button_url' => '/candidature'],
        ]);

        // ──────────────────────────────────────────────────────────────────────
        // 8. VIE ESTUDIANTINE
        // ──────────────────────────────────────────────────────────────────────
        $ins('vie-estudiantine', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Vie Estudiantine', 'title_ar' => 'الحياة الطلابية',
             'subtitle_fr' => "Plus qu'une formation — une expérience !", 'subtitle_ar' => 'أكثر من تكوين — تجربة!',
             'content_fr' => "Au CQPM Nador, la formation ne s'arrête pas à la salle de cours. Découvrez la richesse de la vie estudiantine au cœur de notre communauté maritime.",
             'content_ar' => "في CQPM الناظور، التكوين لا يتوقف عند باب القاعة الدراسية. اكتشف غنى الحياة الطلابية في قلب مجتمعنا البحري.",
             'button_text_fr' => 'Nos clubs', 'button_text_ar' => 'أنديتنا', 'button_url' => '/vie-estudiantine/clubs'],
            ['section_key' => 'activites', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Une Vie Riche et Épanouissante', 'title_ar' => 'حياة غنية ومزدهرة',
             'subtitle_fr' => 'Au-delà de la formation', 'subtitle_ar' => 'ما وراء التكوين',
             'content_fr' => "La vie estudiantine au CQPM Nador est marquée par une multitude d'activités :\n\n• Clubs nautiques et sports maritimes\n• Sorties pédagogiques en mer et dans les ports\n• Participation aux foires et salons maritimes\n• Activités culturelles et sportives\n• Journées portes ouvertes\n• Compétitions inter-filières\n• Témoignages et rencontres avec des professionnels",
             'content_ar' => "تتميز الحياة الطلابية في CQPM بأنشطة متعددة ومثرية:\n\n• أندية الإبحار والرياضات البحرية\n• رحلات تربوية في البحر وفي الموانئ\n• المشاركة في المعارض والصالونات البحرية\n• أنشطة ثقافية ورياضية\n• أيام الأبواب المفتوحة\n• مسابقات بين المسارات\n• شهادات ولقاءات مع المهنيين",
             'button_text_fr' => 'Voir les clubs', 'button_text_ar' => 'مشاهدة الأندية', 'button_url' => '/vie-estudiantine/clubs'],
            ['section_key' => 'gallery', 'section_type' => 'gallery', 'position' => 3,
             'title_fr' => 'La Vie en Images', 'title_ar' => 'الحياة بالصور',
             'subtitle_fr' => 'Aperçu de la vie au CQPM', 'subtitle_ar' => 'لمحة من الحياة في CQPM',
             'button_text_fr' => 'Voir la galerie', 'button_text_ar' => 'مشاهدة المعرض', 'button_url' => '/galerie'],
        ]);

        $ins('vie-clubs', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Clubs Étudiants', 'title_ar' => 'الأندية الطلابية',
             'subtitle_fr' => 'Rejoignez nos clubs', 'subtitle_ar' => 'انضم إلى أنديتنا',
             'content_fr' => "Nos clubs étudiants permettent à chaque étudiant de s'épanouir au-delà de la formation académique.",
             'content_ar' => "أنديتنا الطلابية تمكّن كل طالب من الازدهار خارج إطار التكوين الأكاديمي.",
             'button_text_fr' => 'Voir les activités', 'button_text_ar' => 'مشاهدة الأنشطة', 'button_url' => '/vie-estudiantine/activites'],
            ['section_key' => 'clubs', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Nos Clubs Actifs', 'title_ar' => 'أنديتنا النشطة',
             'subtitle_fr' => 'Activités parascolaires', 'subtitle_ar' => 'الأنشطة الموازية',
             'content_fr' => "CLUB VOILE & NAUTISME\nActivités de voile légère, kayak de mer, initiation à la planche à voile dans la baie de Nador.\n\nCLUB FOOTBALL\nChampionnat inter-filières, tournois régionaux, matchs contre d'autres établissements.\n\nCLUB THÉÂTRE & ARTS\nPièces de théâtre, expression artistique, festivals culturels universitaires.\n\nCLUB PHOTOGRAPHIE MARITIME\nCaptures des sorties en mer, expositions annuelles, concours photo.\n\nCLUB ENVIRONNEMENT MARIN\nSensibilisation à la préservation des écosystèmes marins, nettoyage des plages.\n\nCLUB TECHNOLOGIE & INNOVATION\nProjets de robotique marine, drones sous-marins, impression 3D appliquée à la mer.",
             'content_ar' => "نادي الشراع والإبحار\nأنشطة الشراع الخفيف، القارب المجدّف، التعرف على ركوب الأمواج في خليج الناظور.\n\nنادي كرة القدم\nبطولة بين المسارات، دوريات جهوية، مباريات ضد مؤسسات أخرى.\n\nنادي المسرح والفنون\nعروض مسرحية، تعبير فني، مهرجانات ثقافية جامعية.\n\nنادي التصوير البحري\nتصوير الرحلات البحرية، معارض سنوية، مسابقات تصوير.\n\nنادي البيئة البحرية\nتحسيس بالحفاظ على النظم البيئية البحرية، تنظيف الشواطئ.\n\nنادي التكنولوجيا والابتكار\nمشاريع الروبوتيك البحري، الطائرات المسيّرة تحت الماء، الطباعة ثلاثية الأبعاد.",
             'button_text_fr' => 'Voir les activités', 'button_text_ar' => 'مشاهدة الأنشطة', 'button_url' => '/vie-estudiantine/activites'],
        ]);

        $ins('vie-activites', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Activités Étudiantes', 'title_ar' => 'الأنشطة الطلابية',
             'subtitle_fr' => 'Sport, culture et mer', 'subtitle_ar' => 'الرياضة والثقافة والبحر',
             'content_fr' => "Découvrez le programme d'activités culturelles, sportives et pédagogiques du CQPM Nador.",
             'content_ar' => "اكتشف برنامج الأنشطة الثقافية والرياضية والتربوية لـCQPM الناظور.",
             'button_text_fr' => 'Voir la galerie', 'button_text_ar' => 'مشاهدة المعرض', 'button_url' => '/galerie'],
            ['section_key' => 'activites', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Notre Programme Annuel', 'title_ar' => 'برنامجنا السنوي',
             'subtitle_fr' => 'Calendrier des activités', 'subtitle_ar' => 'تقويم الأنشطة',
             'content_fr' => "SEPTEMBRE — Rentrée & Accueil des nouveaux étudiants\nJournée d'intégration, présentation des clubs, visite des installations.\n\nOCTOBRE-NOVEMBRE — Tournois sportifs\nChampionnat de football, volleyball et natation inter-filières.\n\nDÉCEMBRE — Fête de fin d'année\nSpectacle de fin d'année, remise de prix, soirée culturelle bilingue FR/AR.\n\nJANVIER-MARS — Sorties pédagogiques\nVisites de ports, embarquements sur chalutiers, visites d'unités de transformation.\n\nAVRIL — Semaine de l'environnement marin\nNettoyage des plages, ateliers de sensibilisation, plantation d'arbres.\n\nMAI-JUIN — Journées portes ouvertes\nAccueil des lycéens et familles, démonstrations pratiques.",
             'content_ar' => "سبتمبر — الدخول واستقبال الطلاب الجدد\nيوم الاندماج، تقديم الأندية، زيارة المنشآت.\n\nأكتوبر-نونبر — دوريات رياضية\nبطولة كرة القدم، الكرة الطائرة والسباحة بين المسارات.\n\nدجنبر — حفل نهاية السنة\nعرض نهاية السنة، توزيع الجوائز، سهرة ثقافية ثنائية اللغة.\n\nيناير-مارس — رحلات تربوية\nزيارات الموانئ، الإبحار على متن قوارب الصيد، زيارات وحدات التحويل.\n\nأبريل — أسبوع البيئة البحرية\nتنظيف الشواطئ، ورشات التحسيس، غرس الأشجار.\n\nماي-يونيو — أيام الأبواب المفتوحة\nاستقبال التلاميذ والعائلات، عروض تطبيقية.",
             'button_text_fr' => 'Voir la galerie', 'button_text_ar' => 'مشاهدة المعرض', 'button_url' => '/galerie'],
            ['section_key' => 'gallery', 'section_type' => 'gallery', 'position' => 3,
             'title_fr' => 'Nos Activités en Images', 'title_ar' => 'أنشطتنا بالصور',
             'subtitle_fr' => 'La vie au quotidien au CQPM', 'subtitle_ar' => 'الحياة اليومية في CQPM',
             'button_text_fr' => 'Voir toutes les photos', 'button_text_ar' => 'مشاهدة جميع الصور', 'button_url' => '/galerie/photos'],
        ]);

        $ins('vie-sorties', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Sorties Pédagogiques', 'title_ar' => 'الرحلات التربوية',
             'subtitle_fr' => 'Apprendre en mer', 'subtitle_ar' => 'التعلم في البحر',
             'content_fr' => "Nos sorties pédagogiques mettent en pratique les enseignements théoriques dans des conditions réelles de navigation et de pêche.",
             'content_ar' => "رحلاتنا التربوية تضع المعارف النظرية موضع التطبيق في ظروف حقيقية من الملاحة والصيد.",
             'button_text_fr' => 'Voir la galerie', 'button_text_ar' => 'مشاهدة المعرض', 'button_url' => '/galerie'],
            ['section_key' => 'sorties', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Nos Sorties en Mer', 'title_ar' => 'رحلاتنا في البحر',
             'subtitle_fr' => 'Formation pratique sur le terrain', 'subtitle_ar' => 'تكوين تطبيقي في الميدان',
             'content_fr' => "SORTIES HEBDOMADAIRES EN MER\nChaque filière organise des sorties pratiques régulières dans la baie de Nador et au-delà, pour mettre en application les cours théoriques.\n\nVISITES DE PORTS\nVisites organisées des ports de Nador, Ras El Ma, Al Hoceima et Beni Enzar.\n\nEMBARQUEMENT SUR NAVIRES\nLes étudiants de 3ème et 4ème semestres effectuent des stages embarqués à bord de chalutiers, sardiniers et navires de transport.\n\nVISITES D'UNITÉS DE TRANSFORMATION\nDécouverte des usines de transformation et de conservation des produits de la mer.",
             'content_ar' => "رحلات أسبوعية في البحر\nيُنظّم كل مسار رحلات تطبيقية منتظمة في خليج الناظور وما وراءه.\n\nزيارات الموانئ\nزيارات منظمة لموانئ الناظور ورأس الماء والحسيمة وبني أنصار.\n\nالتدريب على متن السفن\nيُجري طلاب الفصلين الثالث والرابع تدريبات على متن قوارب الجر والسردين.\n\nزيارات وحدات التحويل\nاكتشاف مصانع تحويل وحفظ منتجات البحر في الجهة.",
             'button_text_fr' => 'Voir la galerie', 'button_text_ar' => 'مشاهدة المعرض', 'button_url' => '/galerie'],
        ]);

        $ins('vie-temoignages', [
            ['section_key' => 'hero', 'section_type' => 'hero', 'position' => 1,
             'title_fr' => 'Témoignages de Diplômés', 'title_ar' => 'شهادات الخريجين',
             'subtitle_fr' => 'Ils ont choisi le CQPM Nador', 'subtitle_ar' => 'اختاروا CQPM الناظور',
             'content_fr' => "Découvrez les témoignages de nos diplômés qui ont réussi leur insertion dans le monde maritime.",
             'content_ar' => "اكتشف شهادات خريجينا الذين نجحوا في اندماجهم في عالم البحر.",
             'button_text_fr' => 'Postuler comme eux', 'button_text_ar' => 'تقدّم مثلهم', 'button_url' => '/candidature'],
            ['section_key' => 'temoignages', 'section_type' => 'text_image', 'position' => 2,
             'title_fr' => 'Ils témoignent', 'title_ar' => 'يشهدون',
             'subtitle_fr' => 'Paroles de diplômés', 'subtitle_ar' => 'أقوال الخريجين',
             'content_fr' => "\"Le CQPM Nador m'a donné les outils pour réaliser mon rêve : naviguer sur les mers du monde.\"\n— Youssef, Officier de Navigation, Promo 2019\n\n\"La formation m'a préparé à faire face à toutes les situations en mer. Aujourd'hui je suis chef mécanicien sur un chalutier.\"\n— Hamza, Chef Mécanicien, Promo 2020\n\n\"Grâce au CQPM, j'ai pu intégrer une coopérative de pêche dès la fin de ma formation.\"\n— Fatima, Responsable Production Aquacole, Promo 2022\n\n\"Les stages pratiques m'ont permis de trouver un emploi immédiatement après l'obtention de mon diplôme.\"\n— Omar, Technicien Sécurité Maritime, Promo 2021",
             'content_ar' => "\"أعطاني CQPM الناظور الأدوات لتحقيق حلمي: الإبحار في بحار العالم.\"\n— يوسف، ضابط ملاحة، فوج 2019\n\n\"أعدّني التكوين لمواجهة جميع المواقف في البحر. أنا اليوم رئيس ميكانيكيين على قارب صيد.\"\n— حمزة، رئيس ميكانيكيين، فوج 2020\n\n\"بفضل CQPM، تمكّنت من الانخراط في تعاونية الصيد منذ نهاية تكويني.\"\n— فاطمة، مسؤولة إنتاج مائيات، فوج 2022\n\n\"مكّنتني التدريبات التطبيقية من إيجاد عمل فور الحصول على شهادتي.\"\n— عمر، تقني السلامة البحرية، فوج 2021",
             'button_text_fr' => "Rejoindre le CQPM", 'button_text_ar' => 'الانضمام إلى CQPM', 'button_url' => '/candidature'],
        ]);

        // ──────────────────────────────────────────────────────────────────────
        // 9. Sections minimales pour les pages manquantes (si 0 sections)
        // ──────────────────────────────────────────────────────────────────────
        $minimal = [
            'contact'                => ['Contactez-nous', 'اتصل بنا'],
            'contact-localisation'   => ['Localisation', 'الموقع الجغرافي'],
            'actualites'             => ['Actualités', 'الأخبار'],
            'documents'              => ['Documents', 'الوثائق'],
            'galerie'                => ['Galerie', 'المعرض'],
            'admission-conditions'   => ["Conditions d'Admission", 'شروط القبول'],
            'admission-pieces'       => ['Pièces à Fournir', 'الوثائق المطلوبة'],
            'admission-calendrier'   => ['Calendrier des Admissions', 'تقويم القبولات'],
            'admission-faq'          => ['Questions Fréquentes', 'الأسئلة الشائعة'],
            'formations-initiale'    => ['Formation Initiale', 'التكوين الأولي'],
            'formations-qualification'  => ['Formation de Qualification', 'تكوين التأهيل'],
            'formations-specialisation' => ['Formation de Spécialisation', 'تكوين التخصص'],
            'formations-continue'    => ['Formation Continue', 'التكوين المستمر'],
        ];

        foreach ($minimal as $slug => [$fr, $ar]) {
            $p = Page::where('slug', $slug)->first();
            if ($p && $p->sections()->count() === 0) {
                PageSection::create([
                    'page_id'      => $p->id,
                    'section_key'  => 'hero',
                    'section_type' => 'hero',
                    'position'     => 1,
                    'is_active'    => true,
                    'title_fr'     => $fr,
                    'title_ar'     => $ar,
                    'subtitle_fr'  => 'CQPM Nador',
                    'subtitle_ar'  => 'CQPM الناظور',
                    'content_fr'   => 'Bienvenue sur la page ' . $fr . ' du CQPM Nador.',
                    'content_ar'   => 'مرحبًا بكم في صفحة ' . $ar . ' لـCQPM الناظور.',
                    'button_text_fr' => 'Postuler',
                    'button_text_ar' => 'تقديم الطلب',
                    'button_url'     => '/candidature',
                ]);
            }
        }

        Page::clearCmsCache();
    }
}
