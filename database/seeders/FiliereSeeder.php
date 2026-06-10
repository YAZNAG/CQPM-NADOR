<?php

namespace Database\Seeders;

use App\Models\Filiere;
use App\Models\FiliereRequiredDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FiliereSeeder extends Seeder
{
    public function run(): void
    {
        $filieres = [
            [
                'title'              => 'Navigation Maritime',
                'title_fr'           => 'Navigation Maritime',
                'title_ar'           => 'الملاحة البحرية',
                'slug'               => 'navigation-maritime',
                'badge'              => 'Brevet de Patron',
                'level'              => 'Technicien Spécialisé',
                'duration'           => '24 mois',
                'description'        => 'Navigation côtière et hauturière, cartographie, météorologie marine, règlement international pour prévenir les abordages.',
                'description_fr'     => 'Navigation côtière et hauturière, cartographie maritime, météorologie marine et règlement international pour prévenir les abordages en mer.',
                'description_ar'     => 'الملاحة الساحلية وأعالي البحار، الخرائط البحرية، الأرصاد الجوية البحرية، واللوائح الدولية لمنع الاصطدامات في البحر.',
                'objectifs_fr'       => "- Maîtriser la navigation côtière et hauturière\n- Utiliser les instruments de navigation modernes\n- Appliquer les règles COLREG\n- Gérer la sécurité du navire et de l'équipage",
                'objectifs_ar'       => "- إتقان الملاحة الساحلية وأعالي البحار\n- استخدام أدوات الملاحة الحديثة\n- تطبيق قواعد كولريج\n- إدارة سلامة السفينة والطاقم",
                'programme_fr'       => "Semestre 1 : Bases de navigation, météorologie, astronomie nautique\nSemestre 2 : Navigation électronique, GMDSS, sécurité maritime\nSemestre 3 : Réglementation internationale, gestion du navire\nSemestre 4 : Stage en mer + mémoire de fin d'études",
                'programme_ar'       => "الفصل 1: أسس الملاحة، الأرصاد الجوية، علم الفلك الملاحي\nالفصل 2: الملاحة الإلكترونية، GMDSS، السلامة البحرية\nالفصل 3: الأنظمة الدولية، إدارة السفينة\nالفصل 4: تدريب ميداني + بحث التخرج",
                'debouches_fr'       => "- Officier de pont sur navires de pêche\n- Patron de pêche côtière et hauturière\n- Agent maritime dans les ports\n- Inspecteur de sécurité maritime",
                'debouches_ar'       => "- ضابط سطح على سفن الصيد\n- ربان صيد ساحلي وأعالي البحار\n- وكيل بحري في الموانئ\n- مفتش السلامة البحرية",
                'conditions_acces_fr'=> "- Être titulaire du Baccalauréat (toutes séries)\n- Être âgé de 17 à 30 ans\n- Aptitude médicale (vision, audition)\n- Ne pas avoir de casier judiciaire\n- Réussir le concours d'accès",
                'conditions_acces_ar'=> "- حامل شهادة الباكالوريا (جميع الشعب)\n- العمر بين 17 و30 سنة\n- اللياقة الطبية (البصر، السمع)\n- عدم وجود سوابق قضائية\n- اجتياز مباراة الالتحاق",
                'is_active'          => true,
                'position'           => 1,
            ],
            [
                'title'              => 'Machine Maritime',
                'title_fr'           => 'Machine Maritime',
                'title_ar'           => 'آلات السفن البحرية',
                'slug'               => 'machine-maritime',
                'badge'              => 'Brevet de Mécanicien',
                'level'              => 'Technicien Spécialisé',
                'duration'           => '24 mois',
                'description'        => 'Conduite et maintenance des moteurs diesel marins, systèmes électriques, hydrauliques et de réfrigération embarqués.',
                'description_fr'     => 'Conduite et maintenance des moteurs diesel marins, systèmes électriques embarqués, hydraulique navale et systèmes de réfrigération à bord.',
                'description_ar'     => 'تشغيل وصيانة محركات الديزل البحرية، الأنظمة الكهربائية على متن السفن، الهيدروليك البحري وأنظمة التبريد.',
                'objectifs_fr'       => "- Conduire et entretenir les moteurs diesel marins\n- Maintenir les systèmes électriques et hydrauliques\n- Diagnostiquer et résoudre les pannes moteur\n- Gérer la salle des machines",
                'objectifs_ar'       => "- تشغيل وصيانة محركات الديزل البحرية\n- صيانة الأنظمة الكهربائية والهيدروليكية\n- تشخيص وإصلاح أعطال المحركات\n- إدارة غرفة الآلات",
                'programme_fr'       => "Semestre 1 : Mécanique générale, électrotechnique, thermodynamique\nSemestre 2 : Moteurs diesel, systèmes hydrauliques\nSemestre 3 : Électronique embarquée, réfrigération navale\nSemestre 4 : Stage embarqué + mémoire",
                'programme_ar'       => "الفصل 1: ميكانيكا عامة، كهروتقنية، ديناميكا حرارية\nالفصل 2: محركات ديزل، أنظمة هيدروليكية\nالفصل 3: إلكترونيات على متن السفينة، تبريد بحري\nالفصل 4: تدريب ميداني + بحث",
                'debouches_fr'       => "- Mécanicien de quart sur navire\n- Chef mécanicien sur petits navires\n- Technicien de maintenance portuaire\n- Agent en chantier naval",
                'debouches_ar'       => "- ميكانيكي حراسة على السفينة\n- كبير الميكانيكيين على السفن الصغيرة\n- تقني صيانة ميناء\n- عامل في حوض السفن",
                'conditions_acces_fr'=> "- Baccalauréat scientifique ou technique\n- Âge : 17 à 30 ans\n- Aptitude physique (pas de problèmes cardiaques)\n- Réussir le concours d'accès",
                'conditions_acces_ar'=> "- باكالوريا علمية أو تقنية\n- العمر بين 17 و30 سنة\n- اللياقة البدنية (دون مشاكل قلبية)\n- اجتياز مباراة الالتحاق",
                'is_active'          => true,
                'position'           => 2,
            ],
            [
                'title'              => 'Pêche Artisanale',
                'title_fr'           => 'Pêche Artisanale',
                'title_ar'           => 'الصيد التقليدي',
                'slug'               => 'peche-artisanale',
                'badge'              => 'Certificat Professionnel',
                'level'              => 'Qualification Professionnelle',
                'duration'           => '12 mois',
                'description'        => 'Techniques de pêche côtière, identification des espèces, gestion des captures, réglementation halieutique nationale.',
                'description_fr'     => 'Techniques de pêche côtière, identification et valorisation des espèces marines, gestion responsable des captures et réglementation halieutique.',
                'description_ar'     => 'تقنيات الصيد الساحلي، التعرف على الأنواع البحرية وتثمينها، الإدارة المسؤولة للمصيد واللوائح السمكية.',
                'objectifs_fr'       => "- Maîtriser les techniques de pêche artisanale\n- Identifier les espèces marines\n- Respecter la réglementation halieutique\n- Gérer la chaîne de froid à bord",
                'objectifs_ar'       => "- إتقان تقنيات الصيد التقليدي\n- التعرف على الأنواع البحرية\n- احترام الأنظمة السمكية\n- إدارة سلسلة التبريد على متن القارب",
                'programme_fr'       => "Module 1 : Biologie marine, identification des espèces\nModule 2 : Techniques de pêche, engins et matériel\nModule 3 : Réglementation, sécurité et premiers secours\nModule 4 : Stage pratique en mer",
                'programme_ar'       => "الوحدة 1: بيولوجيا بحرية، التعرف على الأنواع\nالوحدة 2: تقنيات الصيد، الأدوات والمعدات\nالوحدة 3: الأنظمة، السلامة والإسعافات الأولية\nالوحدة 4: تدريب ميداني في البحر",
                'debouches_fr'       => "- Pêcheur artisanal côtier\n- Patron de barque de pêche\n- Coopérative de pêche artisanale\n- Agent des ressources halieutiques",
                'debouches_ar'       => "- صياد ساحلي تقليدي\n- ربان قارب صيد\n- تعاونية الصيد التقليدي\n- عون الموارد السمكية",
                'conditions_acces_fr'=> "- Niveau 3ème collège minimum\n- Âge : 16 à 35 ans\n- Savoir nager\n- Aptitude médicale\n- Concours d'accès",
                'conditions_acces_ar'=> "- مستوى الثالثة إعدادي على الأقل\n- العمر بين 16 و35 سنة\n- القدرة على السباحة\n- اللياقة الطبية\n- مباراة الالتحاق",
                'is_active'          => true,
                'position'           => 3,
            ],
            [
                'title'              => 'Sécurité Maritime',
                'title_fr'           => 'Sécurité Maritime',
                'title_ar'           => 'السلامة البحرية',
                'slug'               => 'securite-maritime',
                'badge'              => 'STCW de base',
                'level'              => 'Certification',
                'duration'           => '6 semaines',
                'description'        => 'Techniques de survie en mer, lutte anti-incendie, PMAN, premiers secours médicaux, GMDSS/VHF.',
                'description_fr'     => 'Formation aux techniques de survie en mer, lutte contre l\'incendie, plan de maîtrise des avaries, premiers secours et communications GMDSS/VHF.',
                'description_ar'     => 'التدريب على تقنيات البقاء في البحر، مكافحة الحرائق، خطة التحكم في الأضرار، الإسعافات الأولية واتصالات GMDSS/VHF.',
                'objectifs_fr'       => "- Appliquer les procédures STCW de base\n- Maîtriser les techniques de survie en mer\n- Utiliser les équipements de lutte anti-incendie\n- Prodiguer les premiers secours médicaux",
                'objectifs_ar'       => "- تطبيق إجراءات STCW الأساسية\n- إتقان تقنيات البقاء في البحر\n- استخدام معدات مكافحة الحرائق\n- تقديم الإسعافات الأولية",
                'programme_fr'       => "Semaine 1-2 : Survie personnelle en mer (PST)\nSemaine 3 : Lutte anti-incendie de base (BFF)\nSemaine 4 : Prévention et lutte contre l'incendie (AFF)\nSemaine 5-6 : Premiers secours médicaux, GMDSS/VHF",
                'programme_ar'       => "الأسبوع 1-2: البقاء الشخصي في البحر (PST)\nالأسبوع 3: مكافحة الحريق الأساسية (BFF)\nالأسبوع 4: الوقاية ومكافحة الحرائق (AFF)\nالأسبوع 5-6: إسعافات طبية أولية، GMDSS/VHF",
                'debouches_fr'       => "- Matelot qualifié STCW\n- Membre d'équipage sur navires nationaux\n- Renouvellement de certificats maritimes\n- Accès à d'autres formations maritimes",
                'debouches_ar'       => "- بحار مؤهل STCW\n- فرد طاقم على السفن الوطنية\n- تجديد الشهادات البحرية\n- الوصول إلى تكوينات بحرية أخرى",
                'conditions_acces_fr'=> "- Être marin ou candidat à l'emploi maritime\n- Niveau 9ème année minimum\n- Âge minimum : 16 ans\n- Aptitude médicale valide",
                'conditions_acces_ar'=> "- أن تكون بحاراً أو مترشحاً للعمل البحري\n- مستوى السنة التاسعة على الأقل\n- السن الأدنى: 16 سنة\n- لياقة طبية سارية المفعول",
                'is_active'          => true,
                'position'           => 4,
            ],
            [
                'title'              => 'Aquaculture',
                'title_fr'           => 'Aquaculture',
                'title_ar'           => 'تربية الأحياء البحرية',
                'slug'               => 'aquaculture',
                'badge'              => 'Technicien Spécialisé',
                'level'              => 'Technicien Spécialisé',
                'duration'           => '18 mois',
                'description'        => "Élevage de poissons et coquillages, gestion des installations aquacoles côtières, qualité et traçabilité des produits.",
                'description_fr'     => "Élevage de poissons et mollusques, gestion des installations aquacoles côtières, contrôle qualité et traçabilité des produits aquacoles.",
                'description_ar'     => "تربية الأسماك والرخويات، إدارة منشآت تربية الأحياء المائية الساحلية، مراقبة الجودة وتتبع المنتجات.",
                'objectifs_fr'       => "- Maîtriser les techniques d'élevage aquacole\n- Gérer les installations de mariculture\n- Contrôler la qualité des produits\n- Appliquer les normes sanitaires",
                'objectifs_ar'       => "- إتقان تقنيات تربية الأحياء المائية\n- إدارة منشآت تربية الأحياء البحرية\n- مراقبة جودة المنتجات\n- تطبيق المعايير الصحية",
                'programme_fr'       => "Semestre 1 : Biologie aquacole, chimie de l'eau\nSemestre 2 : Élevage de poissons, ostréiculture\nSemestre 3 : Gestion de ferme, pathologie aquacole\nStage de 3 mois en ferme aquacole",
                'programme_ar'       => "الفصل 1: بيولوجيا الاستزراع المائي، كيمياء الماء\nالفصل 2: تربية الأسماك، زراعة المحار\nالفصل 3: إدارة المزرعة، أمراض الأحياء المائية\nتدريب 3 أشهر في مزرعة مائية",
                'debouches_fr'       => "- Technicien en ferme aquacole\n- Responsable de site ostréicole\n- Contrôleur qualité produits de la mer\n- Entrepreneur aquacole",
                'debouches_ar'       => "- تقني في مزرعة مائية\n- مسؤول موقع زراعة المحار\n- مراقب جودة منتجات البحر\n- رائد أعمال في تربية الأحياء المائية",
                'conditions_acces_fr'=> "- Baccalauréat scientifique, agronomique ou similaire\n- Âge : 17 à 30 ans\n- Intérêt pour les sciences marines\n- Concours d'accès",
                'conditions_acces_ar'=> "- باكالوريا علمية أو زراعية أو ما يعادلها\n- العمر بين 17 و30 سنة\n- الاهتمام بالعلوم البحرية\n- مباراة الالتحاق",
                'is_active'          => true,
                'position'           => 5,
            ],
            [
                'title'              => 'Transformation des Produits',
                'title_fr'           => 'Transformation des Produits de la Mer',
                'title_ar'           => 'تحويل منتجات البحر',
                'slug'               => 'transformation-produits',
                'badge'              => 'Certificat Professionnel',
                'level'              => 'Qualification Professionnelle',
                'duration'           => '12 mois',
                'description'        => "Valorisation des produits de la mer, procédés HACCP, conditionnement, chaîne du froid et normes d'hygiène.",
                'description_fr'     => "Valorisation et transformation des produits de la mer, maîtrise des procédés HACCP, conditionnement, gestion de la chaîne du froid et normes d'hygiène alimentaire.",
                'description_ar'     => "تثمين وتحويل منتجات البحر، التحكم في إجراءات HACCP، التعبئة والتغليف، إدارة سلسلة التبريد ومعايير النظافة الغذائية.",
                'objectifs_fr'       => "- Appliquer les normes HACCP\n- Maîtriser les techniques de transformation\n- Gérer la chaîne du froid\n- Contrôler la qualité sanitaire des produits",
                'objectifs_ar'       => "- تطبيق معايير HACCP\n- إتقان تقنيات التحويل\n- إدارة سلسلة التبريد\n- مراقبة الجودة الصحية للمنتجات",
                'programme_fr'       => "Module 1 : Technologie des produits de la mer\nModule 2 : Normes HACCP et hygiène alimentaire\nModule 3 : Froid industriel, conditionnement\nModule 4 : Stage en unité de transformation",
                'programme_ar'       => "الوحدة 1: تكنولوجيا منتجات البحر\nالوحدة 2: معايير HACCP والنظافة الغذائية\nالوحدة 3: التبريد الصناعي، التعبئة\nالوحدة 4: تدريب في وحدة التحويل",
                'debouches_fr'       => "- Ouvrier qualifié en unité de transformation\n- Contrôleur qualité en industrie alimentaire\n- Agent ONSSA / inspection sanitaire\n- Gestionnaire de stock frigorifique",
                'debouches_ar'       => "- عامل مؤهل في وحدة تحويل\n- مراقب جودة في الصناعة الغذائية\n- عون ONSSA / تفتيش صحي\n- مسير مخزن التبريد",
                'conditions_acces_fr'=> "- Niveau 9ème année ou équivalent\n- Âge : 16 à 35 ans\n- Aptitude médicale (alimentation)\n- Concours d'accès",
                'conditions_acces_ar'=> "- مستوى السنة التاسعة أو ما يعادلها\n- العمر بين 16 و35 سنة\n- اللياقة الطبية (قطاع الغذاء)\n- مباراة الالتحاق",
                'is_active'          => true,
                'position'           => 6,
            ],
        ];

        // Default required documents (applied to each filiere)
        $defaultDocs = [
            ['title_fr' => 'Copie CIN',                        'title_ar' => 'نسخة من بطاقة الهوية الوطنية',    'pos' => 1, 'required' => true],
            ['title_fr' => 'Extrait d\'acte de naissance',    'title_ar' => 'نسخة من عقد الازدياد',            'pos' => 2, 'required' => true],
            ['title_fr' => 'Diplôme ou attestation de niveau','title_ar' => 'شهادة المستوى الدراسي',           'pos' => 3, 'required' => true],
            ['title_fr' => 'Relevé de notes',                 'title_ar' => 'كشف النقط',                       'pos' => 4, 'required' => true],
            ['title_fr' => 'Photo d\'identité',               'title_ar' => 'صورة شخصية',                      'pos' => 5, 'required' => true],
            ['title_fr' => 'Certificat médical',              'title_ar' => 'شهادة طبية',                      'pos' => 6, 'required' => true],
            ['title_fr' => 'Formulaire de candidature signé', 'title_ar' => 'استمارة الترشيح موقعة',           'pos' => 7, 'required' => true],
        ];

        Filiere::truncate();

        foreach ($filieres as $data) {
            $filiere = Filiere::create($data);

            foreach ($defaultDocs as $doc) {
                FiliereRequiredDocument::create([
                    'filiere_id' => $filiere->id,
                    'title_fr'   => $doc['title_fr'],
                    'title_ar'   => $doc['title_ar'],
                    'is_required'=> $doc['required'],
                    'position'   => $doc['pos'],
                ]);
            }
        }
    }
}
