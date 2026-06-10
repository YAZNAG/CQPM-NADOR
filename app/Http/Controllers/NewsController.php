<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SiteSetting;

class NewsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all_settings();
        $siteSigle = $settings['sigle'] ?? 'CQPM Nador';
        $siteName = app()->getLocale() === 'ar'
            ? ($settings['nom_ar'] ?? $siteSigle)
            : ($settings['nom_fr'] ?? $siteSigle);

        $articles = Article::query()
            ->active()
            ->published()
            ->ordered()
            ->paginate(9);

        $seo = [
            'title' => (app()->getLocale() === 'ar' ? 'الأخبار' : 'Actualités') . ' - ' . $siteSigle,
            'description' => app()->getLocale() === 'ar'
                ? 'آخر أخبار وإعلانات ' . $siteName . '.'
                : 'Dernières actualités et annonces du ' . $siteName . '.',
        ];

        return view('news.index', compact('articles', 'seo', 'settings'));
    }

    public function show(Article $article)
    {
        abort_unless($article->is_active, 404);

        $seo = [
            'title' => $article->meta_title ?: $article->title,
            'description' => $article->meta_description ?: $article->excerpt,
            'image' => $article->image_url,
        ];

        return view('news.show', compact('article', 'seo'));
    }
}
