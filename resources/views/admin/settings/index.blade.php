@extends('layouts.admin')

@section('title', 'Identité du site')
@section('page-title', 'Identité du site & paramètres globaux')
@section('page-subtitle', 'Gestion du site > Identité, coordonnées, footer, SEO et affichage')

@section('content')

@php
    $value = fn (string $key, mixed $default = '') => old($key, $settings[$key] ?? $default);
    $checked = fn (string $key, string $default = '1') => old($key, $settings[$key] ?? $default) === '1' || old($key, $settings[$key] ?? $default) === 1 || old($key, $settings[$key] ?? $default) === true;
    $fileUrl = fn (string $key) => ! empty($settings[$key] ?? null) ? \Illuminate\Support\Facades\Storage::url($settings[$key]) : null;
@endphp

<form method="POST" action="{{ route('admin.site-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">1. Identité du centre</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Nom français <span class="text-red-500">*</span></label>
                <input name="nom_fr" value="{{ $value('nom_fr') }}" class="w-full border @error('nom_fr') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm">
                @error('nom_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Nom arabe <span class="text-red-500">*</span></label>
                <input name="nom_ar" dir="rtl" value="{{ $value('nom_ar') }}" class="w-full border @error('nom_ar') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm">
                @error('nom_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Sigle <span class="text-red-500">*</span></label>
                <input name="sigle" value="{{ $value('sigle') }}" class="w-full border @error('sigle') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm">
                @error('sigle')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div></div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Slogan français</label>
                <input name="slogan_fr" value="{{ $value('slogan_fr') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Slogan arabe</label>
                <input name="slogan_ar" dir="rtl" value="{{ $value('slogan_ar') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Logo</label>
                <input type="file" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg" class="w-full border @error('logo') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm bg-white">
                @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                @if($fileUrl('logo'))
                    <img src="{{ $fileUrl('logo') }}" alt="Logo" class="mt-3 h-20 w-20 object-contain rounded-lg border border-gray-200 bg-white">
                    <label class="mt-2 flex items-center gap-2 text-sm text-gray-600"><input type="checkbox" name="remove_logo" value="1"> Supprimer le logo actuel</label>
                @endif
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Favicon</label>
                <input type="file" name="favicon" accept=".ico,.jpg,.jpeg,.png,.webp,.svg" class="w-full border @error('favicon') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm bg-white">
                @error('favicon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                @if($fileUrl('favicon'))
                    <img src="{{ $fileUrl('favicon') }}" alt="Favicon" class="mt-3 h-12 w-12 object-contain rounded-lg border border-gray-200 bg-white">
                    <label class="mt-2 flex items-center gap-2 text-sm text-gray-600"><input type="checkbox" name="remove_favicon" value="1"> Supprimer le favicon actuel</label>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">2. Coordonnées</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Adresse français</label>
                <textarea name="adresse_fr" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('adresse_fr') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Adresse arabe</label>
                <textarea name="adresse_ar" rows="3" dir="rtl" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('adresse_ar') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Téléphone</label>
                <input name="telephone" value="{{ $value('telephone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Email</label>
                <input type="email" name="email" value="{{ $value('email') }}" class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Horaires français</label>
                <textarea name="horaires_fr" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('horaires_fr') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Horaires arabe</label>
                <textarea name="horaires_ar" rows="3" dir="rtl" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('horaires_ar') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Google Maps embed</label>
                <textarea name="google_maps_embed" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono">{{ $value('google_maps_embed') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Latitude</label>
                <input name="latitude" value="{{ $value('latitude') }}" class="w-full border @error('latitude') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm">
                @error('latitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Longitude</label>
                <input name="longitude" value="{{ $value('longitude') }}" class="w-full border @error('longitude') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm">
                @error('longitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">3. Réseaux sociaux</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach(['facebook_url' => 'Facebook', 'instagram_url' => 'Instagram', 'youtube_url' => 'YouTube', 'linkedin_url' => 'LinkedIn'] as $field => $label)
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">{{ $label }}</label>
                    <input type="url" name="{{ $field }}" value="{{ $value($field) }}" class="w-full border @error($field) border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm">
                    @error($field)<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            @endforeach
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">WhatsApp</label>
                <input name="whatsapp_number" value="{{ $value('whatsapp_number') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">4. Footer</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Description footer français</label>
                <textarea name="footer_description_fr" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('footer_description_fr') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Description footer arabe</label>
                <textarea name="footer_description_ar" rows="4" dir="rtl" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('footer_description_ar') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Copyright français</label>
                <input name="copyright_fr" value="{{ $value('copyright_fr') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Copyright arabe</label>
                <input name="copyright_ar" dir="rtl" value="{{ $value('copyright_ar') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">5. SEO global</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Meta title français</label>
                <input name="default_meta_title_fr" value="{{ $value('default_meta_title_fr') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Meta title arabe</label>
                <input name="default_meta_title_ar" dir="rtl" value="{{ $value('default_meta_title_ar') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Meta description français</label>
                <textarea name="default_meta_description_fr" rows="3" maxlength="255" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('default_meta_description_fr') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Meta description arabe</label>
                <textarea name="default_meta_description_ar" rows="3" maxlength="255" dir="rtl" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('default_meta_description_ar') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Image OpenGraph par défaut</label>
                <input type="file" name="default_og_image" accept=".jpg,.jpeg,.png,.webp" class="w-full border @error('default_og_image') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm bg-white">
                @error('default_og_image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                @if($fileUrl('default_og_image'))
                    <img src="{{ $fileUrl('default_og_image') }}" alt="OpenGraph" class="mt-3 h-24 w-40 object-cover rounded-lg border border-gray-200">
                    <label class="mt-2 flex items-center gap-2 text-sm text-gray-600"><input type="checkbox" name="remove_default_og_image" value="1"> Supprimer l’image OpenGraph actuelle</label>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">6. Paramètres d’affichage</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
            @foreach([
                'afficher_lang_switcher' => 'Afficher le sélecteur FR/AR',
                'afficher_bouton_candidature' => 'Afficher bouton candidature',
                'afficher_reseaux_sociaux' => 'Afficher réseaux sociaux',
                'maintenance_mode' => 'Mode maintenance',
            ] as $field => $label)
                <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                    <input type="checkbox" name="{{ $field }}" value="1" {{ $checked($field, $field === 'maintenance_mode' ? '0' : '1') ? 'checked' : '' }} class="w-4 h-4 text-navy border-gray-300 rounded">
                    <span class="text-sm text-gray-700">{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">Bandeau d’annonce</h2>
        </div>
        <div class="p-5 space-y-4">
            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                <input type="checkbox" name="annonce_active" value="1" {{ $checked('annonce_active') ? 'checked' : '' }} class="w-4 h-4 text-navy border-gray-300 rounded">
                <span class="text-sm text-gray-700">Afficher le bandeau d’annonce sur l’accueil</span>
            </label>
            <input name="annonce_titre" value="{{ $value('annonce_titre') }}" placeholder="Titre du bandeau" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <textarea name="annonce_texte" rows="3" placeholder="Texte du bandeau" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ $value('annonce_texte') }}</textarea>
        </div>
    </div>

    <div class="sticky bottom-0 bg-white border border-gray-200 rounded-xl px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 shadow-sm">
        <p class="text-xs text-gray-500">Les modifications sont appliquées immédiatement et le cache global est vidé automatiquement.</p>
        <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg">
            Enregistrer les paramètres globaux
        </button>
    </div>
</form>

@endsection
