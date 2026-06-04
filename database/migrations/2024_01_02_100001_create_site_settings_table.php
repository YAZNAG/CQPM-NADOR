<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('site_settings')->insert([
            ['key' => 'annonce_active', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'annonce_titre',  'value' => 'Concours d\'Accès 2024/2025 — Inscriptions Ouvertes', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'annonce_texte',  'value' => 'Le Centre de Qualification Professionnelle Maritime de Nador annonce l\'ouverture des inscriptions au concours d\'accès pour l\'année de formation 2024/2025. Les dossiers de candidature sont disponibles en téléchargement ci-dessous.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
