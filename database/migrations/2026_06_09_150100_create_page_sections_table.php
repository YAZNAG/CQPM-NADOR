<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('section_key');
            $table->string('section_type');
            $table->string('title_fr')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('subtitle_fr')->nullable();
            $table->string('subtitle_ar')->nullable();
            $table->longText('content_fr')->nullable();
            $table->longText('content_ar')->nullable();
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('button_text_fr')->nullable();
            $table->string('button_text_ar')->nullable();
            $table->string('button_url')->nullable();
            $table->string('second_button_text_fr')->nullable();
            $table->string('second_button_text_ar')->nullable();
            $table->string('second_button_url')->nullable();
            $table->json('extra_data')->nullable();
            $table->integer('position')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->unique(['page_id', 'section_key']);
            $table->index(['page_id', 'is_active', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
