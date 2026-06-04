<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('type_formation');
            $table->string('nom');
            $table->string('prenom');
            $table->string('section_candidature');
            $table->string('genre');
            $table->string('email');
            $table->string('telephone');
            $table->string('lieu_naissance');
            $table->date('date_naissance');
            $table->string('niveau_scolaire');
            $table->string('region');
            $table->string('ville');
            $table->text('adresse_postale');
            $table->boolean('declaration_honneur')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
