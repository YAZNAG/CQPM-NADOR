<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            // Avis de concours
            ['title' => 'Avis de concours — Navigation Maritime 2025/2026',              'file_path' => 'documents/avis-concours-navigation-2025.pdf'],
            ['title' => 'Avis de concours — Machine Maritime 2025/2026',                 'file_path' => 'documents/avis-concours-machine-2025.pdf'],
            ['title' => 'Avis de concours — Pêche Artisanale 2025/2026',                 'file_path' => 'documents/avis-concours-peche-2025.pdf'],
            ['title' => 'Avis de concours — Sécurité Maritime 2025/2026',                'file_path' => 'documents/avis-concours-securite-2025.pdf'],
            ['title' => 'Avis de concours — Aquaculture 2025/2026',                      'file_path' => 'documents/avis-concours-aquaculture-2025.pdf'],
            // إعلانات — AR
            ['title' => 'إعلان مباراة الولوج — الملاحة البحرية 2025/2026',              'file_path' => 'documents/avis-concours-navigation-ar-2025.pdf'],
            ['title' => 'إعلان مباراة الولوج — آلات السفن 2025/2026',                   'file_path' => 'documents/avis-concours-machine-ar-2025.pdf'],
            // Résultats
            ['title' => 'Résultats de sélection — Promotion 2024/2025',                  'file_path' => 'documents/resultats-selection-2024-2025.pdf'],
            ['title' => 'Liste des admis — Navigation Maritime — Promo 2024',             'file_path' => 'documents/admis-navigation-2024.pdf'],
            ['title' => 'Liste des admis — Machine Maritime — Promo 2024',                'file_path' => 'documents/admis-machine-2024.pdf'],
            ['title' => 'Liste des admis — Pêche Artisanale — Promo 2024',               'file_path' => 'documents/admis-peche-2024.pdf'],
            // نتائج — AR
            ['title' => 'نتائج الانتقاء — فوج 2024/2025',                               'file_path' => 'documents/resultats-selection-ar-2024-2025.pdf'],
            ['title' => 'قائمة المقبولين — الملاحة البحرية — فوج 2024',                  'file_path' => 'documents/admis-navigation-ar-2024.pdf'],
            // Formulaires & guides
            ['title' => "Formulaire de candidature — Année 2025/2026",                   'file_path' => 'documents/formulaire-candidature-2025.pdf'],
            ['title' => "Guide du candidat — CQPM Nador 2025",                           'file_path' => 'documents/guide-candidat-2025.pdf'],
            ['title' => "Conditions générales d'admission — CQPM Nador",                  'file_path' => 'documents/conditions-admission.pdf'],
            // دليل — AR
            ['title' => 'دليل المترشح — CQPM الناظور 2025',                             'file_path' => 'documents/guide-candidat-ar-2025.pdf'],
            ['title' => 'استمارة الترشيح — 2025/2026',                                   'file_path' => 'documents/formulaire-candidature-ar-2025.pdf'],
            // Programmes
            ['title' => "Programme pédagogique — Navigation Maritime 2024/2025",          'file_path' => 'documents/programme-navigation-2024.pdf'],
            ['title' => "Programme pédagogique — Aquaculture 2024/2025",                  'file_path' => 'documents/programme-aquaculture-2024.pdf'],
        ];

        foreach ($documents as $doc) {
            Document::firstOrCreate(['title' => $doc['title']], $doc);
        }
    }
}
