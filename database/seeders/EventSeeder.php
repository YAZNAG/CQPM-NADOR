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
                'slug' => 'journee-portes-ouvertes-mai-2025',
                'title_fr' => 'Journée Portes Ouvertes — CQPM Nador',
                'title_ar' => 'يوم الأبواب المفتوحة — CQPM الناظور',
                'excerpt_fr' => "Venez découvrir le CQPM Nador, ses filières et ses installations lors de notre journée portes ouvertes.",
                'excerpt_ar' => 'تعرف على CQPM الناظور ومساراته ومنشآته في يوم الأبواب المفتوحة.',
                'content_fr' => "Le CQPM Nador vous invite à découvrir ses formations et ses installations lors de la journée portes ouvertes du 24 mai 2025. Visites guidées, démonstrations et rencontres avec les formateurs au programme.",
                'content_ar' => "يدعوكم CQPM الناظور لاكتشاف تكويناته ومنشآته في يوم الأبواب المفتوحة بتاريخ 24 ماي 2025. زيارات موجهة وعروض ولقاءات مع المكوّنين في البرنامج.",
                'location_fr' => 'CQPM Nador — Port de Nador',
                'location_ar' => 'CQPM الناظور — ميناء الناظور',
                'starts_at' => now()->addDays(14)->setTime(9, 0),
                'ends_at'   => now()->addDays(14)->setTime(17, 0),
                'position'  => 1,
            ],
            [
                'slug' => 'session-orientation-candidats-2025',
                'title_fr' => "Session d'orientation des candidats",
                'title_ar' => 'حصة التوجيه للمترشحين',
                'excerpt_fr' => "Présentation des filières, conditions d'accès et calendrier pour les candidats à la promotion 2025-2026.",
                'excerpt_ar' => 'تقديم المسارات وشروط القبول والروزنامة للمترشحين لفوج 2025-2026.',
                'content_fr' => "Le CQPM Nador organise une session d'orientation pour les candidats souhaitant intégrer la promotion 2025-2026. L'équipe pédagogique répondra à toutes vos questions.",
                'content_ar' => "ينظم CQPM الناظور حصة توجيهية للمترشحين الراغبين في الانضمام لفوج 2025-2026. سيجيب الفريق التربوي على جميع أسئلتكم.",
                'location_fr' => 'Amphithéâtre du CQPM Nador',
                'location_ar' => 'قاعة المحاضرات — CQPM الناظور',
                'starts_at' => now()->addDays(7)->setTime(10, 0),
                'ends_at'   => now()->addDays(7)->setTime(12, 30),
                'position'  => 2,
            ],
            [
                'slug' => 'atelier-securite-maritime-gmdss',
                'title_fr' => 'Atelier Sécurité Maritime — GMDSS',
                'title_ar' => 'ورشة السلامة البحرية — GMDSS',
                'excerpt_fr' => "Atelier pratique sur les communications maritimes et le système GMDSS pour les professionnels.",
                'excerpt_ar' => 'ورشة تطبيقية حول الاتصالات البحرية ونظام GMDSS للمهنيين.',
                'content_fr' => "Cet atelier pratique de 2 jours couvre les procédures du Système Mondial de Détresse et de Sécurité en Mer (GMDSS) : utilisation des équipements radio, procédures d'urgence et communication en situation de détresse.",
                'content_ar' => "تتضمن هذه الورشة التطبيقية التي تمتد يومين إجراءات نظام الاستغاثة والسلامة البحرية العالمي (GMDSS): استخدام أجهزة الراديو وإجراءات الطوارئ والتواصل في حالات الاستغاثة.",
                'location_fr' => 'Salle GMDSS — CQPM Nador',
                'location_ar' => 'قاعة GMDSS — CQPM الناظور',
                'starts_at' => now()->addDays(21)->setTime(9, 0),
                'ends_at'   => now()->addDays(22)->setTime(17, 0),
                'position'  => 3,
            ],
            [
                'slug' => 'foire-metiers-mer-nador',
                'title_fr' => 'Foire des Métiers de la Mer — Nador 2025',
                'title_ar' => 'معرض مهن البحر — الناظور 2025',
                'excerpt_fr' => "Participez à la foire annuelle des métiers de la mer organisée en partenariat avec le Port de Nador.",
                'excerpt_ar' => 'شارك في المعرض السنوي لمهن البحر المنظم بشراكة مع ميناء الناظور.',
                'content_fr' => "La Foire des Métiers de la Mer réunit chaque année les principaux acteurs du secteur maritime. Stands des armateurs, des coopératives de pêche, des institutions de formation et des autorités maritimes. Entrée gratuite.",
                'content_ar' => "يجمع معرض مهن البحر سنوياً كبار فاعلي القطاع البحري. أجنحة ملاك السفن وتعاونيات الصيد ومؤسسات التكوين والسلطات البحرية. الدخول مجاني.",
                'location_fr' => 'Complexe du Port de Nador',
                'location_ar' => 'مجمع ميناء الناظور',
                'starts_at' => now()->addDays(35)->setTime(9, 0),
                'ends_at'   => now()->addDays(36)->setTime(18, 0),
                'position'  => 4,
            ],
            [
                'slug' => 'concours-interne-navigation-2025',
                'title_fr' => 'Concours interne de navigation — Promotion 2025',
                'title_ar' => 'مسابقة الملاحة الداخلية — فوج 2025',
                'excerpt_fr' => "Les étudiants de la filière Navigation Maritime s'affrontent lors du concours interne annuel.",
                'excerpt_ar' => 'يتنافس طلاب مسار الملاحة البحرية في المسابقة الداخلية السنوية.',
                'content_fr' => "Le concours interne de navigation met en compétition les étudiants sur des exercices de navigation côtière, de cartographie et de manœuvre simulée. Les lauréats représenteront le CQPM au concours national.",
                'content_ar' => "تُنافس مسابقة الملاحة الداخلية بين الطلاب في تمارين الملاحة الساحلية والخرائط والمناورة المحاكاة. سيمثل الفائزون CQPM في المسابقة الوطنية.",
                'location_fr' => 'Salle de simulation — CQPM Nador',
                'location_ar' => 'قاعة المحاكاة — CQPM الناظور',
                'starts_at' => now()->addDays(42)->setTime(9, 0),
                'ends_at'   => now()->addDays(42)->setTime(16, 0),
                'position'  => 5,
            ],
            [
                'slug' => 'formation-premier-secours-mer',
                'title_fr' => 'Formation Premiers Secours en Mer',
                'title_ar' => 'تكوين الإسعافات الأولية في البحر',
                'excerpt_fr' => "Stage obligatoire de premiers secours en mer pour les étudiants de 2ème et 3ème semestres.",
                'excerpt_ar' => 'تدريب إلزامي في الإسعافات الأولية البحرية لطلاب الفصل الثاني والثالث.',
                'content_fr' => "Ce stage de 3 jours couvre les techniques de réanimation cardio-pulmonaire (RCP), le traitement des hypothermies, la prise en charge des noyades et les procédures médicales à bord. Certification STCW Medical First Aid à l'issue.",
                'content_ar' => "يشمل هذا التدريب لمدة 3 أيام تقنيات الإنعاش القلبي الرئوي، معالجة انخفاض الحرارة، التعامل مع الغرق والإجراءات الطبية على متن السفن. شهادة STCW Medical First Aid عند الانتهاء.",
                'location_fr' => 'Centre médical — CQPM Nador',
                'location_ar' => 'المركز الطبي — CQPM الناظور',
                'starts_at' => now()->addDays(50)->setTime(8, 30),
                'ends_at'   => now()->addDays(52)->setTime(17, 0),
                'position'  => 6,
            ],
            [
                'slug' => 'ceremonie-remise-diplomes-2025',
                'title_fr' => 'Cérémonie de remise des diplômes — Promotion 2025',
                'title_ar' => 'حفل توزيع الشهادات — فوج 2025',
                'excerpt_fr' => "Cérémonie officielle de remise des diplômes aux lauréats de la promotion 2025 du CQPM Nador.",
                'excerpt_ar' => 'حفل رسمي لتوزيع الشهادات على خريجي فوج 2025 من CQPM الناظور.',
                'content_fr' => "Le CQPM Nador organise la cérémonie officielle de remise des diplômes de la promotion 2025 en présence des autorités, des partenaires et des familles. Une occasion de célébrer les réussites de nos diplômés.",
                'content_ar' => "ينظم CQPM الناظور الحفل الرسمي لتوزيع شهادات فوج 2025 بحضور السلطات والشركاء والعائلات. مناسبة للاحتفال بنجاحات خريجينا.",
                'location_fr' => 'Salle de conférences — Port de Nador',
                'location_ar' => 'قاعة المؤتمرات — ميناء الناظور',
                'starts_at' => now()->addDays(90)->setTime(15, 0),
                'ends_at'   => now()->addDays(90)->setTime(19, 0),
                'position'  => 7,
            ],
            [
                'slug' => 'sortie-pedagogique-port-alhucemas',
                'title_fr' => 'Sortie pédagogique — Port d\'Al Hoceima',
                'title_ar' => 'رحلة تربوية — ميناء الحسيمة',
                'excerpt_fr' => "Visite pédagogique du port d'Al Hoceima pour les étudiants des filières Navigation et Pêche.",
                'excerpt_ar' => 'زيارة تربوية لميناء الحسيمة لطلاب مسارَي الملاحة والصيد.',
                'content_fr' => "Cette sortie pédagogique d'une journée au port d'Al Hoceima permettra aux étudiants de découvrir l'organisation d'un port de pêche, les procédures de débarquement et de criée, et les équipements de navigation des chalutiers.",
                'content_ar' => "تتيح هذه الرحلة التربوية ليوم كامل لميناء الحسيمة للطلاب اكتشاف تنظيم ميناء الصيد وإجراءات الإنزال والمزاد وتجهيزات ملاحة قوارب الجر.",
                'location_fr' => 'Port d\'Al Hoceima',
                'location_ar' => 'ميناء الحسيمة',
                'starts_at' => now()->addDays(25)->setTime(7, 30),
                'ends_at'   => now()->addDays(25)->setTime(18, 0),
                'position'  => 8,
            ],
            [
                'slug' => 'seminaire-aquaculture-durable',
                'title_fr' => 'Séminaire — Aquaculture durable en Méditerranée',
                'title_ar' => 'ندوة — تربية الأحياء المائية المستدامة في المتوسط',
                'excerpt_fr' => "Séminaire international sur les pratiques d'aquaculture durable avec des experts marocains et méditerranéens.",
                'excerpt_ar' => 'ندوة دولية حول ممارسات تربية الأحياء المائية المستدامة مع خبراء مغاربة ومتوسطيين.',
                'content_fr' => "Ce séminaire rassemble des experts du Maroc, d'Espagne, d'Italie et de Grèce pour partager les meilleures pratiques en matière d'aquaculture durable, d'élevage de nouvelles espèces et de techniques d'alimentation respectueuses de l'environnement.",
                'content_ar' => "تجمع هذه الندوة خبراء من المغرب وإسبانيا وإيطاليا واليونان لتبادل أفضل الممارسات في تربية الأحياء المائية المستدامة وتربية الأنواع الجديدة وتقنيات التغذية الصديقة للبيئة.",
                'location_fr' => 'CQPM Nador — Salle polyvalente',
                'location_ar' => 'CQPM الناظور — القاعة متعددة الاستخدام',
                'starts_at' => now()->addDays(60)->setTime(9, 0),
                'ends_at'   => now()->addDays(60)->setTime(17, 30),
                'position'  => 9,
            ],
            [
                'slug' => 'competition-sportive-inter-filieres',
                'title_fr' => 'Compétition sportive inter-filières',
                'title_ar' => 'مسابقة رياضية بين المسارات',
                'excerpt_fr' => "Le tournoi sportif annuel inter-filières bat son plein avec football, volleyball et natation.",
                'excerpt_ar' => 'ينطلق البطولة الرياضية السنوية بين المسارات بكرة القدم والكرة الطائرة والسباحة.',
                'content_fr' => "La compétition sportive inter-filières du CQPM Nador réunit chaque année l'ensemble des étudiants autour de disciplines sportives. Au programme : football, volleyball, natation et tir à la corde. Remise de trophées en clôture.",
                'content_ar' => "تجمع المسابقة الرياضية السنوية بين مسارات CQPM الناظور جميع الطلاب حول رياضات مختلفة. في البرنامج: كرة القدم والكرة الطائرة والسباحة وشد الحبل. توزيع الكؤوس في الختام.",
                'location_fr' => 'Complexe sportif de Nador',
                'location_ar' => 'المركب الرياضي للناظور',
                'starts_at' => now()->addDays(70)->setTime(9, 0),
                'ends_at'   => now()->addDays(70)->setTime(18, 0),
                'position'  => 10,
            ],
        ];

        foreach ($items as $item) {
            Event::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge([
                    'image_path'          => null,
                    'meta_title_fr'       => $item['title_fr'] . ' — CQPM Nador',
                    'meta_title_ar'       => $item['title_ar'] . ' — CQPM الناظور',
                    'meta_description_fr' => $item['excerpt_fr'],
                    'meta_description_ar' => $item['excerpt_ar'],
                    'is_active'           => true,
                ], $item)
            );
        }

        Event::clearEventCache();
    }
}
