<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    private const TEXT_FIELDS = [
        'nom_fr',
        'nom_ar',
        'sigle',
        'slogan_fr',
        'slogan_ar',
        'adresse_fr',
        'adresse_ar',
        'telephone',
        'email',
        'horaires_fr',
        'horaires_ar',
        'google_maps_embed',
        'latitude',
        'longitude',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'linkedin_url',
        'whatsapp_number',
        'footer_description_fr',
        'footer_description_ar',
        'copyright_fr',
        'copyright_ar',
        'default_meta_title_fr',
        'default_meta_title_ar',
        'default_meta_description_fr',
        'default_meta_description_ar',
        'annonce_titre',
        'annonce_texte',
    ];

    private const BOOLEAN_FIELDS = [
        'afficher_lang_switcher',
        'afficher_bouton_candidature',
        'afficher_reseaux_sociaux',
        'maintenance_mode',
        'annonce_active',
    ];

    private const FILE_FIELDS = [
        'logo',
        'favicon',
        'default_og_image',
    ];

    public function index()
    {
        $settings = SiteSetting::all_settings();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nom_fr' => ['required', 'string', 'max:255'],
            'nom_ar' => ['required', 'string', 'max:255'],
            'sigle' => ['required', 'string', 'max:100'],
            'slogan_fr' => ['nullable', 'string', 'max:255'],
            'slogan_ar' => ['nullable', 'string', 'max:255'],
            'adresse_fr' => ['nullable', 'string', 'max:1000'],
            'adresse_ar' => ['nullable', 'string', 'max:1000'],
            'telephone' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'horaires_fr' => ['nullable', 'string', 'max:500'],
            'horaires_ar' => ['nullable', 'string', 'max:500'],
            'google_maps_embed' => ['nullable', 'string', 'max:10000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'facebook_url' => ['nullable', 'url', 'max:2048'],
            'instagram_url' => ['nullable', 'url', 'max:2048'],
            'youtube_url' => ['nullable', 'url', 'max:2048'],
            'linkedin_url' => ['nullable', 'url', 'max:2048'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'footer_description_fr' => ['nullable', 'string', 'max:1000'],
            'footer_description_ar' => ['nullable', 'string', 'max:1000'],
            'copyright_fr' => ['nullable', 'string', 'max:255'],
            'copyright_ar' => ['nullable', 'string', 'max:255'],
            'default_meta_title_fr' => ['nullable', 'string', 'max:255'],
            'default_meta_title_ar' => ['nullable', 'string', 'max:255'],
            'default_meta_description_fr' => ['nullable', 'string', 'max:255'],
            'default_meta_description_ar' => ['nullable', 'string', 'max:255'],
            'annonce_titre' => ['nullable', 'string', 'max:255'],
            'annonce_texte' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'favicon' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg,ico', 'max:1024'],
            'default_og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_logo' => ['nullable', 'boolean'],
            'remove_favicon' => ['nullable', 'boolean'],
            'remove_default_og_image' => ['nullable', 'boolean'],
            'afficher_lang_switcher' => ['nullable', 'boolean'],
            'afficher_bouton_candidature' => ['nullable', 'boolean'],
            'afficher_reseaux_sociaux' => ['nullable', 'boolean'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'annonce_active' => ['nullable', 'boolean'],
        ], [
            'nom_fr.required' => 'Le nom français du centre est obligatoire.',
            'nom_ar.required' => 'Le nom arabe du centre est obligatoire.',
            'sigle.required' => 'Le sigle est obligatoire.',
            'email.email' => 'L’adresse e-mail doit être valide.',
            '*.url' => 'L’URL saisie doit être valide.',
            'logo.mimes' => 'Le logo doit être au format JPG, PNG, WEBP ou SVG.',
            'favicon.mimes' => 'Le favicon doit être au format ICO, JPG, PNG, WEBP ou SVG.',
            'default_og_image.mimes' => 'L’image OpenGraph doit être au format JPG, PNG ou WEBP.',
        ]);

        foreach (self::TEXT_FIELDS as $field) {
            SiteSetting::set($field, $data[$field] ?? null);
        }

        foreach (self::BOOLEAN_FIELDS as $field) {
            SiteSetting::set($field, $request->boolean($field) ? '1' : '0');
        }

        foreach (self::FILE_FIELDS as $field) {
            $this->handleFileField($request, $field);
        }

        SiteSetting::clearCache();

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Identité du site et paramètres globaux mis à jour.');
    }

    private function handleFileField(Request $request, string $field): void
    {
        $currentPath = SiteSetting::get($field);
        $removeField = 'remove_' . $field;

        if ($request->boolean($removeField) && $currentPath) {
            Storage::disk('public')->delete($currentPath);
            SiteSetting::set($field, null);
            $currentPath = null;
        }

        if (! $request->hasFile($field)) {
            return;
        }

        if ($currentPath) {
            Storage::disk('public')->delete($currentPath);
        }

        SiteSetting::set($field, $request->file($field)->store('site', 'public'));
    }
}
