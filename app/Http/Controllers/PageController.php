<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Document;
use App\Models\Event;
use App\Models\Filiere;
use App\Models\MediaItem;
use App\Models\Page;
use App\Models\SiteSetting;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::cachedHome();
        $sections = $page?->sections ?? collect();
        $documents = Document::latest()->take(8)->get();
        $settings = SiteSetting::all_settings();
        $articles = Article::cachedRecent(6);
        $filieres = Filiere::all();
        $mediaItems = MediaItem::cachedGallery(6);

        return view('home', compact('page', 'sections', 'documents', 'settings', 'articles', 'filieres', 'mediaItems'));
    }

    public function staticPage(string $slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->first();
        $settings = SiteSetting::all_settings();
        if ($page) {
            $page->load(['sections' => fn ($q) => $q->active()->ordered()]);
            $sections = $page->sections;
            $documents = Document::latest()->take(8)->get();
            $articles = Article::cachedRecent(6);
            $filieres = Filiere::where('is_active', true)->orderBy('position')->get();
            $mediaItems = MediaItem::cachedGallery(6);
            return view('pages.show', compact('page', 'sections', 'documents', 'settings', 'articles', 'filieres', 'mediaItems'));
        }
        return view('pages.static', compact('slug', 'settings'));
    }

    public function sitemap()
    {
        $pages    = Page::where('is_active', true)->get();
        $articles = Article::where('is_active', true)->whereNotNull('published_at')->orderByDesc('published_at')->get();
        $events   = Event::where('is_active', true)->get();
        $filieres = Filiere::where('is_active', true)->get();
        $documents = Document::latest()->get();

        $content = view('sitemap', compact('pages', 'articles', 'events', 'filieres', 'documents'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /lang/\n\nSitemap: " . url('/sitemap.xml');
        return response($content, 200)->header('Content-Type', 'text/plain');
    }

    public function show(Page $page)
    {
        abort_unless($page->is_active, 404);

        $page->load(['sections' => fn ($query) => $query->active()->ordered()]);

        $sections = $page->sections;
        $documents = Document::latest()->take(8)->get();
        $settings = SiteSetting::all_settings();
        $articles = Article::cachedRecent(6);
        $filieres = Filiere::all();
        $mediaItems = MediaItem::cachedGallery(6);

        return view('pages.show', compact('page', 'sections', 'documents', 'settings', 'articles', 'filieres', 'mediaItems'));
    }
}
