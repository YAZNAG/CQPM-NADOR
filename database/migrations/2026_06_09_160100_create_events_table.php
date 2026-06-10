<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title_fr');
            $table->string('title_ar');
            $table->string('slug')->unique();
            $table->text('excerpt_fr')->nullable();
            $table->text('excerpt_ar')->nullable();
            $table->longText('content_fr')->nullable();
            $table->longText('content_ar')->nullable();
            $table->string('location_fr')->nullable();
            $table->string('location_ar')->nullable();
            $table->string('image_path')->nullable();
            $table->string('meta_title_fr')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_description_fr')->nullable();
            $table->string('meta_description_ar')->nullable();
            $table->dateTime('starts_at')->nullable()->index();
            $table->dateTime('ends_at')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('position')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
