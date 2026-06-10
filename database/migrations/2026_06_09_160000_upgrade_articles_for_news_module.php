<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title_fr')->nullable()->after('id');
            $table->string('title_ar')->nullable()->after('title_fr');
            $table->string('slug')->nullable()->unique()->after('title_ar');
            $table->text('excerpt_fr')->nullable()->after('slug');
            $table->text('excerpt_ar')->nullable()->after('excerpt_fr');
            $table->longText('content_fr')->nullable()->after('excerpt_ar');
            $table->longText('content_ar')->nullable()->after('content_fr');
            $table->string('image_path')->nullable()->after('content_ar');
            $table->string('meta_title_fr')->nullable()->after('image_path');
            $table->string('meta_title_ar')->nullable()->after('meta_title_fr');
            $table->string('meta_description_fr')->nullable()->after('meta_title_ar');
            $table->string('meta_description_ar')->nullable()->after('meta_description_fr');
            $table->timestamp('published_at')->nullable()->index()->after('meta_description_ar');
            $table->boolean('is_active')->default(true)->index()->after('published_at');
            $table->integer('position')->default(0)->index()->after('is_active');
        });

        DB::table('articles')->orderBy('id')->get()->each(function ($article) {
            $baseSlug = Str::slug($article->title ?: 'actualite-' . $article->id) ?: 'actualite-' . $article->id;
            $slug = $baseSlug;
            $counter = 2;

            while (DB::table('articles')->where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            DB::table('articles')->where('id', $article->id)->update([
                'title_fr' => $article->title,
                'title_ar' => $article->title,
                'slug' => $slug,
                'excerpt_fr' => Str::limit(strip_tags((string) $article->content), 180),
                'excerpt_ar' => Str::limit(strip_tags((string) $article->content), 180),
                'content_fr' => $article->content,
                'content_ar' => $article->content,
                'image_path' => $this->isImagePath($article->file_path) ? $article->file_path : null,
                'published_at' => $article->created_at,
                'is_active' => true,
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'title_fr',
                'title_ar',
                'slug',
                'excerpt_fr',
                'excerpt_ar',
                'content_fr',
                'content_ar',
                'image_path',
                'meta_title_fr',
                'meta_title_ar',
                'meta_description_fr',
                'meta_description_ar',
                'published_at',
                'is_active',
                'position',
            ]);
        });
    }

    private function isImagePath(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        return in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }
};
