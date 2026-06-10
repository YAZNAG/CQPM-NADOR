<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->string('title_fr');
            $table->string('title_ar');
            $table->string('slug')->unique();
            $table->text('description_fr')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('media_type')->default('image')->index();
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('alt_fr')->nullable();
            $table->string('alt_ar')->nullable();
            $table->string('category_fr')->nullable();
            $table->string('category_ar')->nullable();
            $table->string('meta_title_fr')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_description_fr')->nullable();
            $table->string('meta_description_ar')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('position')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_items');
    }
};
