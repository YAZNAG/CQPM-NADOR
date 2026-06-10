<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\SiteSetting;

class EventController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all_settings();
        $siteSigle = $settings['sigle'] ?? 'CQPM Nador';
        $siteName = app()->getLocale() === 'ar'
            ? ($settings['nom_ar'] ?? $siteSigle)
            : ($settings['nom_fr'] ?? $siteSigle);

        $events = Event::query()
            ->active()
            ->ordered()
            ->paginate(9);

        $seo = [
            'title' => (app()->getLocale() === 'ar' ? 'الأنشطة' : 'Événements') . ' - ' . $siteSigle,
            'description' => app()->getLocale() === 'ar'
                ? 'أنشطة ومواعيد ' . $siteName . '.'
                : 'Événements, activités et rendez-vous du ' . $siteName . '.',
        ];

        return view('events.index', compact('events', 'seo', 'settings'));
    }

    public function show(Event $event)
    {
        abort_unless($event->is_active, 404);

        $seo = [
            'title' => $event->meta_title ?: $event->title,
            'description' => $event->meta_description ?: $event->excerpt,
            'image' => $event->image_url,
        ];

        return view('events.show', compact('event', 'seo'));
    }
}
