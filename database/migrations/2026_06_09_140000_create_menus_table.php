<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('menus')->cascadeOnDelete();
            $table->string('title_fr');
            $table->string('title_ar');
            $table->string('slug')->unique();
            $table->string('url')->nullable();
            $table->string('type', 20)->default('internal');
            $table->string('target', 20)->default('_self');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_header')->default(true);
            $table->boolean('show_in_footer')->default(true);
            $table->timestamps();

            $table->index(['parent_id', 'position']);
            $table->index(['is_active', 'show_in_header']);
            $table->index(['is_active', 'show_in_footer']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
