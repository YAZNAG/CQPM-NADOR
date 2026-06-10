<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'nom_fr' => 'Centre de Qualification Professionnelle Maritime de Nador',
            'nom_ar' => 'مركز التأهيل المهني البحري بالناظور',
            'sigle' => 'CQPM Nador',
            'slogan_fr' => 'Formation maritime professionnelle au service des métiers de la mer',
            'slogan_ar' => 'تكوين مهني بحري في خدمة مهن البحر',
            'adresse_fr' => 'Port de Nador, Avenue Mohammed VI, Nador 62000, Maroc',
            'adresse_ar' => 'ميناء الناظور، شارع محمد السادس، الناظور 62000، المغرب',
            'telephone' => '+212 (0) 536 XX XX XX',
            'email' => 'contact@cqpm-nador.ma',
            'horaires_fr' => 'Lundi - Vendredi : 08h30 - 16h30',
            'horaires_ar' => 'الإثنين - الجمعة: 08:30 - 16:30',
            'google_maps_embed' => '',
            'latitude' => '35.1740',
            'longitude' => '-2.9287',
            'facebook_url' => '',
            'instagram_url' => '',
            'youtube_url' => '',
            'linkedin_url' => '',
            'whatsapp_number' => '',
            'footer_description_fr' => 'Établissement de formation professionnelle maritime placé sous la tutelle du Département de la Pêche Maritime.',
            'footer_description_ar' => 'مؤسسة للتكوين المهني البحري تابعة لقطاع الصيد البحري.',
            'copyright_fr' => 'Tous droits réservés',
            'copyright_ar' => 'جميع الحقوق محفوظة',
            'default_meta_title_fr' => 'CQPM Nador - Formation professionnelle maritime',
            'default_meta_title_ar' => 'مركز التأهيل المهني البحري بالناظور',
            'default_meta_description_fr' => 'Centre de Qualification Professionnelle Maritime de Nador - Formations, actualités, admission et services.',
            'default_meta_description_ar' => 'مركز التأهيل المهني البحري بالناظور - التكوينات والأخبار والتسجيل والخدمات.',
            'afficher_lang_switcher' => '1',
            'afficher_bouton_candidature' => '1',
            'afficher_reseaux_sociaux' => '1',
            'maintenance_mode' => '0',
            'annonce_active' => '1',
            'annonce_titre' => 'Concours d’accès 2024/2025 - Inscriptions ouvertes',
            'annonce_texte' => 'Le Centre de Qualification Professionnelle Maritime de Nador annonce l’ouverture des inscriptions au concours d’accès pour l’année de formation 2024/2025.',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        SiteSetting::clearCache();
    }
}
