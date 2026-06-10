<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title_fr');
            $table->string('title_ar');
            $table->string('slug')->unique();
            $table->longText('content_fr')->nullable();
            $table->longText('content_ar')->nullable();
            $table->string('image_path')->nullable();
            $table->string('meta_title_fr')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_description_fr')->nullable();
            $table->string('meta_description_ar')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('show_in_menu')->default(false)->index();
            $table->integer('position')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
