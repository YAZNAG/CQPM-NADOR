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
                'slug' => 'ouverture-inscriptions-2025-2026',
                'title_fr' => 'Ouverture des inscriptions — Année 2025/2026',
                'title_ar' => 'فتح باب التسجيل — السنة التكوينية 2025/2026',
                'excerpt_fr' => "Le CQPM Nador annonce l'ouverture officielle des candidatures pour l'année de formation 2025-2026.",
                'excerpt_ar' => 'يعلن CQPM الناظور عن الفتح الرسمي لباب الترشيحات للسنة التكوينية 2025-2026.',
                'content_fr' => "Le Centre de Qualification Professionnelle Maritime de Nador a le plaisir d'informer tous les candidats intéressés que les inscriptions pour l'année de formation 2025-2026 sont officiellement ouvertes.\n\nLes candidatures peuvent être déposées en ligne via le formulaire disponible sur notre site. Les dossiers physiques peuvent également être déposés directement au secrétariat du centre aux heures d'ouverture.\n\nDate limite de dépôt des dossiers : 15 août 2025\nRésultats de la sélection : 10 septembre 2025\nDate de rentrée : 22 septembre 2025\n\nPour toute information complémentaire, contactez-nous au +212 536 60 XX XX ou par e-mail.",
                'content_ar' => "يسعد مركز التأهيل المهني البحري بالناظور إعلام جميع المترشحين المهتمين بأن باب التسجيل للسنة التكوينية 2025-2026 قد فُتح رسمياً.\n\nيمكن تقديم الترشيحات إلكترونياً عبر النموذج المتاح على موقعنا. كما يمكن إيداع الملفات الورقية مباشرة في سكرتارية المركز خلال ساعات العمل.\n\nآخر أجل لإيداع الملفات: 15 غشت 2025\nنتائج الانتقاء: 10 شتنبر 2025\nتاريخ الدخول: 22 شتنبر 2025\n\nللمزيد من المعلومات، تواصلوا معنا على الرقم +212 536 60 XX XX أو عبر البريد الإلكتروني.",
                'published_at' => now()->subDays(5),
                'position' => 1,
            ],
            [
                'slug' => 'resultats-selection-2024-2025',
                'title_fr' => 'Résultats de sélection — Promotion 2024/2025',
                'title_ar' => 'نتائج الانتقاء — فوج 2024/2025',
                'excerpt_fr' => "Les résultats de la sélection pour l'année 2024-2025 sont disponibles. Consultez les listes des candidats admis.",
                'excerpt_ar' => 'نتائج انتقاء السنة 2024-2025 متاحة. اطلع على قوائم المترشحين المقبولين.',
                'content_fr' => "Le Centre de Qualification Professionnelle Maritime de Nador informe les candidats que les résultats de la sélection pour l'année de formation 2024-2025 sont maintenant disponibles.\n\nLes candidats admis sont invités à se présenter au secrétariat du centre munis de l'original de leur CIN et de leur diplôme, avant le 15 septembre 2024, pour finaliser leur inscription administrative.\n\nLes listes complètes des admis par filière sont consultables dans la section Documents de ce site.\n\nFélicitations à tous les candidats admis !",
                'content_ar' => "يُعلم مركز التأهيل المهني البحري بالناظور المترشحين بأن نتائج انتقاء السنة التكوينية 2024-2025 أصبحت متاحة الآن.\n\nيُدعى المترشحون المقبولون للحضور إلى سكرتارية المركز بصحبة أصل بطاقة التعريف الوطنية وشهادتهم، وذلك قبل 15 شتنبر 2024، لإتمام تسجيلهم الإداري.\n\nالقوائم الكاملة للمقبولين حسب المسار متاحة في قسم الوثائق من هذا الموقع.\n\nمبروك لجميع المقبولين!",
                'published_at' => now()->subDays(15),
                'position' => 2,
            ],
            [
                'slug' => 'journee-portes-ouvertes-2025',
                'title_fr' => 'Journée Portes Ouvertes — Mai 2025',
                'title_ar' => 'يوم الأبواب المفتوحة — ماي 2025',
                'excerpt_fr' => "Le CQPM Nador ouvre ses portes aux lycéens et familles le 24 mai 2025.",
                'excerpt_ar' => 'يفتح CQPM الناظور أبوابه أمام التلاميذ والعائلات يوم 24 ماي 2025.',
                'content_fr' => "Dans le cadre de sa mission d'information et d'orientation, le CQPM Nador organise sa journée portes ouvertes annuelle le samedi 24 mai 2025 de 9h à 17h.\n\nAu programme :\n• Visite guidée des installations (ateliers techniques, laboratoires, piscine de survie)\n• Présentation des 6 filières de formation\n• Rencontres avec les formateurs et les étudiants\n• Démonstrations pratiques de techniques maritimes\n• Informations sur les conditions d'admission et les débouchés professionnels\n\nEntrée libre. Transport depuis la gare de Nador assuré.",
                'content_ar' => "في إطار مهمته في الإعلام والتوجيه، ينظم CQPM الناظور يوم الأبواب المفتوحة السنوي يوم السبت 24 ماي 2025 من الساعة 9 إلى 17.\n\nالبرنامج:\n• زيارة موجهة للمنشآت (الورشات التقنية، المختبرات، مسبح النجاة)\n• تقديم المسارات الـ6 للتكوين\n• لقاءات مع المكوّنين والطلاب\n• عروض تطبيقية للتقنيات البحرية\n• معلومات حول شروط القبول والآفاق المهنية\n\nالدخول مجاني. نقل مضمون من محطة الناظور.",
                'published_at' => now()->subDays(30),
                'position' => 3,
            ],
            [
                'slug' => 'partenariat-onp-cqpm',
                'title_fr' => 'Signature de convention avec l\'Office National des Pêches',
                'title_ar' => 'توقيع اتفاقية مع المكتب الوطني للصيد',
                'excerpt_fr' => "Le CQPM Nador et l'ONP ont signé une convention de partenariat pour renforcer l'insertion professionnelle des diplômés.",
                'excerpt_ar' => 'وقّع CQPM الناظور والمكتب الوطني للصيد اتفاقية شراكة لتعزيز إدماج الخريجين مهنياً.',
                'content_fr' => "Le Centre de Qualification Professionnelle Maritime de Nador et l'Office National des Pêches (ONP) ont signé une convention de partenariat visant à renforcer la formation pratique et l'insertion professionnelle des diplômés du centre.\n\nCette convention permettra notamment :\n• Des stages embarqués dans le cadre des programmes pédagogiques\n• Des sessions de formation continue pour les professionnels de l'ONP\n• Un suivi des diplômés par l'ONP pour faciliter leur recrutement\n• Des échanges d'expertise entre formateurs et professionnels du secteur",
                'content_ar' => "وقّع مركز التأهيل المهني البحري بالناظور والمكتب الوطني للصيد (ONP) اتفاقية شراكة تهدف إلى تعزيز التكوين التطبيقي والإدماج المهني لخريجي المركز.\n\nتتيح هذه الاتفاقية:\n• تدريبات على متن السفن في إطار البرامج التربوية\n• جلسات تكوين مستمر لمهنيي المكتب\n• متابعة الخريجين من طرف المكتب لتسهيل توظيفهم\n• تبادل الخبرات بين المكوّنين ومهنيي القطاع",
                'published_at' => now()->subDays(45),
                'position' => 4,
            ],
            [
                'slug' => 'certification-stcw-nouveaux-programmes',
                'title_fr' => 'Nouveaux programmes certifiés STCW',
                'title_ar' => 'برامج جديدة معتمدة وفق STCW',
                'excerpt_fr' => "Le CQPM Nador renforce ses formations avec de nouveaux modules certifiés conformes à la Convention STCW internationale.",
                'excerpt_ar' => 'يعزز CQPM الناظور تكويناته بوحدات جديدة معتمدة وفق الاتفاقية الدولية STCW.',
                'content_fr' => "Dans le cadre de la modernisation continue de son offre de formation, le CQPM Nador a intégré de nouveaux modules pédagogiques certifiés conformément aux exigences de la Convention STCW (Standards of Training, Certification and Watchkeeping for Seafarers).\n\nCes nouveaux modules portent sur :\n• STCW Basic Safety Training (BST)\n• Advanced Fire Fighting\n• Medical First Aid\n• Security Awareness Training\n• Survival Craft and Rescue Boats\n\nCes certifications internationalement reconnues augmentent significativement l'employabilité de nos diplômés.",
                'content_ar' => "في إطار التحديث المستمر لعرضه التكويني، أدمج CQPM الناظور وحدات تربوية جديدة معتمدة وفق متطلبات الاتفاقية الدولية STCW.\n\nتشمل هذه الوحدات:\n• التدريب الأساسي للسلامة BST\n• مكافحة الحرائق المتقدمة\n• الإسعافات الأولية الطبية\n• تدريب التوعية الأمنية\n• قوارب النجاة وقوارب الإنقاذ\n\nهذه الشهادات المعترف بها دولياً ترفع بشكل ملحوظ من قابلية توظيف خريجينا.",
                'published_at' => now()->subDays(60),
                'position' => 5,
            ],
            [
                'slug' => 'remise-diplomes-promo-2024',
                'title_fr' => 'Cérémonie de remise des diplômes — Promotion 2024',
                'title_ar' => 'حفل توزيع الشهادات — فوج 2024',
                'excerpt_fr' => "Le CQPM Nador a célébré avec fierté la promotion 2024 lors d'une cérémonie officielle en présence des autorités.",
                'excerpt_ar' => 'احتفل CQPM الناظور بفخر بفوج 2024 في حفل رسمي بحضور السلطات.',
                'content_fr' => "Le Centre de Qualification Professionnelle Maritime de Nador a organisé la cérémonie de remise des diplômes de la promotion 2024 en présence des autorités locales et régionales, des partenaires institutionnels et des familles des diplômés.\n\nCette promotion comprend 85 diplômés répartis sur les 6 filières du centre. Le taux de réussite cette année est de 92%, témoignant de la qualité de la formation dispensée.\n\nLe CQPM Nador félicite chaleureusement tous ses diplômés et leur souhaite une brillante carrière dans le secteur maritime.",
                'content_ar' => "نظّم مركز التأهيل المهني البحري بالناظور حفل توزيع شهادات فوج 2024 بحضور السلطات المحلية والجهوية والشركاء المؤسسيين وعائلات الخريجين.\n\nيضم هذا الفوج 85 خريجاً موزعين على المسارات الـ6 للمركز. بلغت نسبة النجاح هذه السنة 92%، مما يشهد على جودة التكوين المقدَّم.\n\nيُهنئ CQPM الناظور بحرارة جميع خريجيه ويتمنى لهم مسيرة مهنية لامعة في القطاع البحري.",
                'published_at' => now()->subDays(75),
                'position' => 6,
            ],
            [
                'slug' => 'stage-mer-aquaculture',
                'title_fr' => 'Stage de mer — Filière Aquaculture',
                'title_ar' => 'تدريب في البحر — مسار تربية الأحياء المائية',
                'excerpt_fr' => "Les étudiants de la filière Aquaculture ont effectué un stage pratique en mer dans le cadre de leur cursus.",
                'excerpt_ar' => 'أجرى طلاب مسار تربية الأحياء المائية تدريباً تطبيقياً في البحر ضمن مسارهم الدراسي.',
                'content_fr' => "Dans le cadre du programme pédagogique de la filière Aquaculture, les étudiants de 3ème semestre ont effectué un stage de mer de deux semaines en collaboration avec les fermes aquacoles de la région de Nador.\n\nCe stage pratique leur a permis de mettre en application les techniques d'élevage de poissons et de coquillages apprises en cours, d'observer les cycles biologiques et de maîtriser les équipements d'une ferme aquacole professionnelle.\n\nLes retours des étudiants et des encadrants sont très positifs, confirmant l'importance de cette approche pratique dans la formation.",
                'content_ar' => "في إطار البرنامج التربوي لمسار تربية الأحياء المائية، أجرى طلاب الفصل الثالث تدريباً في البحر لمدة أسبوعين بالتعاون مع مزارع الأحياء المائية في منطقة الناظور.\n\nمكّنهم هذا التدريب التطبيقي من تطبيق تقنيات تربية الأسماك والمحار المكتسبة في الدراسة، ومراقبة الدورات البيولوجية وإتقان معدات مزرعة مائية مهنية.\n\nردود فعل الطلاب والمشرفين إيجابية جداً، مما يؤكد أهمية هذا النهج التطبيقي في التكوين.",
                'published_at' => now()->subDays(90),
                'position' => 7,
            ],
            [
                'slug' => 'concours-navigation-inter-centres',
                'title_fr' => 'Concours de navigation — Inter-Centres 2025',
                'title_ar' => 'مسابقة الملاحة — بين المراكز 2025',
                'excerpt_fr' => "Le CQPM Nador a remporté le 1er prix lors du concours de navigation inter-centres organisé à Agadir.",
                'excerpt_ar' => 'فاز CQPM الناظور بالجائزة الأولى في مسابقة الملاحة بين المراكز المنظمة بأكادير.',
                'content_fr' => "L'équipe du CQPM Nador a brillamment remporté le premier prix lors du 5ème Concours National de Navigation Maritime organisé à Agadir les 15 et 16 mars 2025.\n\nLa délégation du CQPM Nador, composée de 4 étudiants de la filière Navigation Maritime encadrés par leurs formateurs, a impressionné le jury par la qualité de leurs techniques de navigation, leur maîtrise des instruments de bord et leurs réflexes en situation d'urgence.\n\nCette victoire est le fruit de l'excellence de la formation dispensée au CQPM Nador et du travail acharné des étudiants.",
                'content_ar' => "أحرز فريق CQPM الناظور بامتياز الجائزة الأولى في المسابقة الوطنية الخامسة للملاحة البحرية المنظمة بأكادير يومي 15 و16 مارس 2025.\n\nأذهل وفد CQPM الناظور المؤلف من 4 طلاب من مسار الملاحة البحرية برفقة مكوّنيهم لجنة التحكيم بجودة تقنيات الملاحة لديهم وإتقانهم لأدوات السفينة وردود أفعالهم في حالات الطوارئ.\n\nهذا الفوز ثمرة تميز التكوين المقدَّم في CQPM الناظور وعمل الطلاب الدؤوب.",
                'published_at' => now()->subDays(110),
                'position' => 8,
            ],
            [
                'slug' => 'formation-securite-maritime-professionnels',
                'title_fr' => 'Formation continue — Sécurité maritime pour les professionnels',
                'title_ar' => 'تكوين مستمر — السلامة البحرية للمهنيين',
                'excerpt_fr' => "Le CQPM Nador organise une session de formation continue dédiée aux professionnels du secteur maritime.",
                'excerpt_ar' => 'ينظم CQPM الناظور جلسة تكوين مستمر مخصصة لمهنيي القطاع البحري.',
                'content_fr' => "Dans le cadre de sa mission de formation continue, le CQPM Nador organise du 10 au 21 juin 2025 une session de recyclage en sécurité maritime destinée aux professionnels du secteur (capitaines, officiers de pont, mécaniciens).\n\nCette formation de 80 heures couvre notamment les nouvelles réglementations SOLAS, les procédures ISM (International Safety Management), la gestion des situations d'urgence et les exercices d'abandon du navire.\n\nInscriptions auprès du service de formation continue du centre.",
                'content_ar' => "في إطار مهمته في التكوين المستمر، ينظم CQPM الناظور من 10 إلى 21 يونيو 2025 دورة تحديث في السلامة البحرية موجهة لمهنيي القطاع (قادة السفن، ضباط الظهر، الميكانيكيين).\n\nيشمل هذا التكوين البالغ 80 ساعة التنظيمات الجديدة لـSOLAS وإجراءات ISM وإدارة حالات الطوارئ وتمارين التخلي عن السفينة.\n\nالتسجيل لدى مصلحة التكوين المستمر بالمركز.",
                'published_at' => now()->subDays(130),
                'position' => 9,
            ],
            [
                'slug' => 'visite-ministerielle-cqpm-nador',
                'title_fr' => 'Visite officielle du Département de la Pêche Maritime',
                'title_ar' => 'زيارة رسمية لقطاع الصيد البحري',
                'excerpt_fr' => "Le CQPM Nador a accueilli une délégation du Département de la Pêche Maritime pour évaluer les formations.",
                'excerpt_ar' => 'استقبل CQPM الناظور وفداً من قطاع الصيد البحري لتقييم التكوينات.',
                'content_fr' => "Le Centre de Qualification Professionnelle Maritime de Nador a eu l'honneur d'accueillir une délégation du Département de la Pêche Maritime conduite par le Directeur de la Formation et de la Recherche Halieutique.\n\nLors de cette visite, la délégation a pu observer les formations en cours, visiter les installations et rencontrer les formateurs et les étudiants.\n\nLes échanges ont porté sur les perspectives d'amélioration des programmes, le renforcement des équipements et les nouvelles filières à développer pour répondre aux besoins du secteur.",
                'content_ar' => "تشرّف مركز التأهيل المهني البحري بالناظور باستقبال وفد من قطاع الصيد البحري برئاسة مدير التكوين والبحث السمكي.\n\nخلال هذه الزيارة، تمكّن الوفد من مشاهدة التكوينات الجارية وزيارة المنشآت ولقاء المكوّنين والطلاب.\n\nدارت المناقشات حول آفاق تحسين البرامج وتعزيز التجهيزات والمسارات الجديدة التي يجب تطويرها للاستجابة لاحتياجات القطاع.",
                'published_at' => now()->subDays(150),
                'position' => 10,
            ],
            [
                'slug' => 'initiative-nettoyage-plage-nador',
                'title_fr' => 'Initiative écologique — Nettoyage de la plage de Nador',
                'title_ar' => 'مبادرة بيئية — تنظيف شاطئ الناظور',
                'excerpt_fr' => "Les étudiants du CQPM Nador ont participé à une grande opération de nettoyage de la plage dans le cadre de la Semaine du Marin.",
                'excerpt_ar' => 'شارك طلاب CQPM الناظور في عملية تنظيف كبيرة للشاطئ ضمن أسبوع البحار.',
                'content_fr' => "Dans le cadre de la Semaine Nationale du Marin, les étudiants et formateurs du CQPM Nador ont organisé une grande opération de nettoyage de la plage de Nador en partenariat avec les autorités locales et les associations environnementales de la région.\n\nPendant une journée entière, plus de 150 participants ont collecté et trié les déchets, sensibilisant ainsi le public à la protection de l'environnement marin.\n\nCette initiative s'inscrit dans la vision du centre de former des professionnels non seulement compétents mais aussi responsables vis-à-vis de l'environnement maritime.",
                'content_ar' => "في إطار الأسبوع الوطني للبحار، نظّم طلاب ومكوّنو CQPM الناظور عملية تنظيف كبيرة لشاطئ الناظور بشراكة مع السلطات المحلية والجمعيات البيئية في الجهة.\n\nطوال يوم كامل، جمّع أكثر من 150 مشاركاً النفايات وصنّفوها، مُحسِّسين الجمهور بأهمية حماية البيئة البحرية.\n\nتندرج هذه المبادرة في رؤية المركز لتكوين مهنيين أكفاء ومسؤولين تجاه البيئة البحرية.",
                'published_at' => now()->subDays(180),
                'position' => 11,
            ],
            [
                'slug' => 'accord-cooperation-espagne',
                'title_fr' => 'Accord de coopération avec le Centre maritime de Carthagène (Espagne)',
                'title_ar' => 'اتفاقية تعاون مع المركز البحري بقرطاجنة (إسبانيا)',
                'excerpt_fr' => "Le CQPM Nador signe un accord de coopération internationale avec un centre de formation maritime espagnol.",
                'excerpt_ar' => 'يوقع CQPM الناظور اتفاقية تعاون دولي مع مركز تكوين بحري إسباني.',
                'content_fr' => "Le Centre de Qualification Professionnelle Maritime de Nador a signé un accord de coopération avec le Centre de Formation Maritime de Carthagène (Espagne) dans le cadre du programme INTERREG de coopération méditerranéenne.\n\nCet accord prévoit notamment :\n• Des échanges d'étudiants pour des stages de 3 mois\n• Des formations croisées pour les formateurs\n• L'harmonisation des programmes pédagogiques selon les standards européens\n• Des projets de recherche conjoints sur la pêche durable méditerranéenne\n\nCet accord représente une avancée majeure pour l'internationalisation du CQPM Nador.",
                'content_ar' => "وقّع مركز التأهيل المهني البحري بالناظور اتفاقية تعاون مع مركز التكوين البحري بقرطاجنة (إسبانيا) في إطار برنامج INTERREG للتعاون المتوسطي.\n\nتتضمن هذه الاتفاقية:\n• تبادل الطلاب لتدريبات مدتها 3 أشهر\n• تكوينات متقاطعة للمكوّنين\n• تنسيق البرامج التربوية وفق المعايير الأوروبية\n• مشاريع بحثية مشتركة حول الصيد المستدام المتوسطي\n\nتمثل هذه الاتفاقية خطوة كبرى نحو تدويل CQPM الناظور.",
                'published_at' => now()->subDays(200),
                'position' => 12,
            ],
        ];

        foreach ($items as $item) {
            Article::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge([
                    'title'              => $item['title_fr'],
                    'content'            => $item['content_fr'],
                    'file_path'          => null,
                    'image_path'         => null,
                    'meta_title_fr'      => $item['title_fr'] . ' — CQPM Nador',
                    'meta_title_ar'      => $item['title_ar'] . ' — CQPM الناظور',
                    'meta_description_fr'=> $item['excerpt_fr'],
                    'meta_description_ar'=> $item['excerpt_ar'],
                    'is_active'          => true,
                ], $item)
            );
        }

        Article::clearNewsCache();
    }
}
