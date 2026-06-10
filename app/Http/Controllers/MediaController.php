<?php

namespace App\Http\Controllers;

use App\Models\MediaItem;
use App\Models\SiteSetting;

class MediaController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all_settings();
        $siteSigle = $settings['sigle'] ?? 'CQPM Nador';
        $siteName = app()->getLocale() === 'ar'
            ? ($settings['nom_ar'] ?? $siteSigle)
            : ($settings['nom_fr'] ?? $siteSigle);

        $mediaItems = MediaItem::query()
            ->active()
            ->ordered()
            ->paginate(12);

        $seo = [
            'title' => (app()->getLocale() === 'ar' ? 'المعرض' : 'Galerie médias') . ' - ' . $siteSigle,
            'description' => app()->getLocale() === 'ar'
                ? 'صور وفيديوهات ' . $siteName . '.'
                : 'Photos et vidéos du ' . $siteName . '.',
        ];

        return view('media.index', compact('mediaItems', 'seo', 'settings'));
    }

    public function photos()
    {
        $settings   = SiteSetting::all_settings();
        $mediaItems = MediaItem::active()->ordered()->where('media_type', 'image')->paginate(12);
        return view('media.index', compact('mediaItems', 'settings'));
    }

    public function videos()
    {
        $settings   = SiteSetting::all_settings();
        $mediaItems = MediaItem::active()->ordered()->where('media_type', 'video')->paginate(12);
        return view('media.index', compact('mediaItems', 'settings'));
    }

    public function events()
    {
        $settings   = SiteSetting::all_settings();
        $mediaItems = MediaItem::active()->ordered()->paginate(12);
        return view('media.index', compact('mediaItems', 'settings'));
    }

    public function virtual()
    {
        $settings = SiteSetting::all_settings();
        return view('media.virtual', compact('settings'));
    }

    public function show(MediaItem $mediaItem)
    {
        abort_unless($mediaItem->is_active, 404);

        $seo = [
            'title' => $mediaItem->meta_title ?: $mediaItem->title,
            'description' => $mediaItem->meta_description ?: $mediaItem->description,
            'image' => $mediaItem->image_url,
        ];

        return view('media.show', compact('mediaItem', 'seo'));
    }
}
