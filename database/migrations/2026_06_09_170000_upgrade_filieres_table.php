<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('filieres', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('id');
            $table->string('title_fr')->nullable()->after('slug');
            $table->string('title_ar')->nullable()->after('title_fr');
            $table->string('level')->nullable()->after('badge');
            $table->text('description_fr')->nullable()->after('description');
            $table->text('description_ar')->nullable()->after('description_fr');
            $table->text('objectifs_fr')->nullable()->after('description_ar');
            $table->text('objectifs_ar')->nullable()->after('objectifs_fr');
            $table->text('programme_fr')->nullable()->after('objectifs_ar');
            $table->text('programme_ar')->nullable()->after('programme_fr');
            $table->text('debouches_fr')->nullable()->after('programme_ar');
            $table->text('debouches_ar')->nullable()->after('debouches_fr');
            $table->text('conditions_acces_fr')->nullable()->after('debouches_ar');
            $table->text('conditions_acces_ar')->nullable()->after('conditions_acces_fr');
            $table->string('image_path')->nullable()->after('icon_path');
            $table->boolean('is_active')->default(true)->after('image_path');
            $table->integer('position')->default(0)->after('is_active');
            $table->string('meta_title_fr')->nullable()->after('position');
            $table->string('meta_title_ar')->nullable()->after('meta_title_fr');
            $table->text('meta_description_fr')->nullable()->after('meta_title_ar');
            $table->text('meta_description_ar')->nullable()->after('meta_description_fr');
        });

        // Populate slug, title_fr, title_ar from existing title
        foreach (\App\Models\Filiere::all() as $f) {
            $slug = Str::slug($f->title);
            $base = $slug;
            $i = 1;
            while (\App\Models\Filiere::where('slug', $slug)->where('id', '!=', $f->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $f->update([
                'slug'       => $slug,
                'title_fr'   => $f->title_fr ?? $f->title,
                'description_fr' => $f->description_fr ?? $f->description,
                'position'   => $f->id,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('filieres', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'title_fr', 'title_ar', 'level',
                'description_fr', 'description_ar',
                'objectifs_fr', 'objectifs_ar',
                'programme_fr', 'programme_ar',
                'debouches_fr', 'debouches_ar',
                'conditions_acces_fr', 'conditions_acces_ar',
                'image_path', 'is_active', 'position',
                'meta_title_fr', 'meta_title_ar',
                'meta_description_fr', 'meta_description_ar',
            ]);
        });
    }
};
