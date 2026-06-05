<?php

namespace Database\Seeders;

use App\Models\Filiere;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    public function run(): void
    {
        $filieres = [
            [
                'title'       => 'Navigation Maritime',
                'badge'       => 'Brevet de Patron',
                'duration'    => '24 mois',
                'description' => 'Navigation côtière et hauturière, cartographie, météorologie marine, règlement international pour prévenir les abordages.',
            ],
            [
                'title'       => 'Machine Maritime',
                'badge'       => 'Brevet de Mécanicien',
                'duration'    => '24 mois',
                'description' => 'Conduite et maintenance des moteurs diesel marins, systèmes électriques, hydrauliques et de réfrigération embarqués.',
            ],
            [
                'title'       => 'Pêche Artisanale',
                'badge'       => 'Certificat Professionnel',
                'duration'    => '12 mois',
                'description' => 'Techniques de pêche côtière, identification des espèces, gestion des captures, réglementation halieutique nationale.',
            ],
            [
                'title'       => 'Sécurité Maritime',
                'badge'       => 'STCW de base',
                'duration'    => '6 semaines',
                'description' => 'Techniques de survie en mer, lutte anti-incendie, PMAN, premiers secours médicaux, GMDSS/VHF.',
            ],
            [
                'title'       => 'Aquaculture',
                'badge'       => 'Technicien Spécialisé',
                'duration'    => '18 mois',
                'description' => "Élevage de poissons et coquillages, gestion des installations aquacoles côtières, qualité et traçabilité des produits.",
            ],
            [
                'title'       => 'Transformation des Produits',
                'badge'       => 'Certificat Professionnel',
                'duration'    => '12 mois',
                'description' => "Valorisation des produits de la mer, procédés HACCP, conditionnement, chaîne du froid et normes d'hygiène.",
            ],
        ];

        foreach ($filieres as $filiere) {
            Filiere::create($filiere);
        }
    }
}
