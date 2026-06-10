<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filiere_required_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filiere_id')->constrained()->cascadeOnDelete();
            $table->string('title_fr');
            $table->string('title_ar');
            $table->text('description_fr')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_required')->default(true);
            $table->string('file_type')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index(['filiere_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filiere_required_documents');
    }
};
