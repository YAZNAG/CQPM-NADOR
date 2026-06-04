@extends('layouts.admin')

@section('title', 'Paramètres du site')
@section('page-title', 'Paramètres du site')
@section('page-subtitle', 'Gérez le contenu dynamique affiché sur la page d\'accueil publique')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Settings form ────────────────────────────────────────────────────── --}}
    <div class="lg:col-span-2">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5">
            @csrf

            {{-- Announcement block --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="bg-navy px-5 py-4 flex items-center gap-3">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"/></svg>
                    <h3 class="text-white font-semibold text-sm">Bandeau d'annonce (homepage)</h3>
                </div>

                <div class="p-5 space-y-4">
                    {{-- Active toggle --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div>
                            <div class="font-semibold text-gray-900 text-sm">Afficher le bandeau d'annonce</div>
                            <div class="text-gray-500 text-xs mt-0.5">Le bandeau apparaît en dessous du hero sur la page d'accueil.</div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" name="annonce_active" value="1"
                                   {{ ($settings['annonce_active'] ?? '1') === '1' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-10 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-navy/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-navy"></div>
                        </label>
                    </div>

                    {{-- Titre --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                            Titre de l'annonce <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="annonce_titre"
                               value="{{ old('annonce_titre', $settings['annonce_titre'] ?? '') }}"
                               placeholder="Ex: Concours d'Accès 2024/2025 — Inscriptions Ouvertes"
                               class="w-full border @error('annonce_titre') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        @error('annonce_titre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Texte --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                            Texte de l'annonce <span class="text-red-500">*</span>
                        </label>
                        <textarea name="annonce_texte" rows="4"
                                  placeholder="Rédigez le texte de l'annonce qui sera visible sur la page d'accueil..."
                                  class="w-full border @error('annonce_texte') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all resize-none">{{ old('annonce_texte', $settings['annonce_texte'] ?? '') }}</textarea>
                        <p class="text-gray-400 text-xs mt-1">Maximum 1000 caractères. Seuls les 140 premiers sont affichés dans le bandeau.</p>
                        @error('annonce_texte')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Save button --}}
            <div class="flex items-center justify-between bg-white rounded-xl border border-gray-200 px-5 py-4">
                <p class="text-xs text-gray-400">Les modifications sont publiées immédiatement sur le site public.</p>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-navy hover:bg-navy-light text-white font-semibold text-sm rounded-lg transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Enregistrer les paramètres
                </button>
            </div>
        </form>
    </div>

    {{-- ── Preview sidebar ──────────────────────────────────────────────────── --}}
    <div>
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden sticky top-6">
            <div class="px-5 py-4 border-b border-gray-100">
                <h4 class="font-semibold text-gray-900 text-sm">Aperçu du bandeau</h4>
                <p class="text-gray-400 text-xs mt-0.5">Rendu approximatif sur la page d'accueil</p>
            </div>
            <div class="p-4">
                <div class="rounded-lg overflow-hidden border border-gold/30 bg-gold-light">
                    <div class="px-3 py-2.5 flex items-start gap-2">
                        <div class="w-6 h-6 bg-gold rounded-full flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <div class="font-bold text-navy text-xs" id="preview-titre">{{ $settings['annonce_titre'] ?? 'Titre de l\'annonce' }}</div>
                            <div class="text-navy/60 text-xs mt-1 leading-relaxed" id="preview-texte">{{ Str::limit($settings['annonce_texte'] ?? '', 100) }}</div>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400 text-xs mt-3 text-center">Rafraîchissez la page après sauvegarde pour voir l'aperçu mis à jour.</p>
            </div>
        </div>

        {{-- Links --}}
        <div class="mt-4 bg-white rounded-xl border border-gray-200 p-4">
            <h4 class="font-semibold text-gray-900 text-sm mb-3">Pages liées</h4>
            <div class="space-y-2">
                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center gap-2 text-xs text-sea hover:text-navy font-medium transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Voir la page d'accueil publique
                </a>
                <a href="{{ route('admin.documents.index') }}"
                   class="flex items-center gap-2 text-xs text-sea hover:text-navy font-medium transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Gérer les documents PDF (Avis & Résultats)
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
