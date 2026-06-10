@extends('layouts.admin')

@section('title', 'Filière — ' . ($filiere->title_fr ?: $filiere->title))
@section('page-title', $filiere->title_fr ?: $filiere->title)
@section('page-subtitle', 'Détail et pièces obligatoires')

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.filieres.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-navy transition-colors font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Retour aux filières
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: info --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Infos générales --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-5 py-3 flex items-center justify-between">
                <h3 class="text-white font-semibold text-sm">Informations générales</h3>
                <a href="{{ route('admin.filieres.edit', $filiere) }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-gold/20 hover:bg-gold text-gold hover:text-navy text-xs font-semibold rounded transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Modifier
                </a>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><dt class="text-xs text-gray-400 font-semibold uppercase">Titre FR</dt><dd class="text-sm font-medium text-gray-900 mt-0.5">{{ $filiere->title_fr ?: '—' }}</dd></div>
                <div><dt class="text-xs text-gray-400 font-semibold uppercase">Titre AR</dt><dd class="text-sm font-medium text-gray-900 mt-0.5" dir="rtl">{{ $filiere->title_ar ?: '—' }}</dd></div>
                <div><dt class="text-xs text-gray-400 font-semibold uppercase">Badge</dt><dd class="mt-0.5"><span class="inline-block bg-navy/10 text-navy text-xs px-2 py-0.5 rounded font-medium">{{ $filiere->badge }}</span></dd></div>
                <div><dt class="text-xs text-gray-400 font-semibold uppercase">Durée</dt><dd class="text-sm font-medium text-gray-900 mt-0.5">{{ $filiere->duration }}</dd></div>
                <div><dt class="text-xs text-gray-400 font-semibold uppercase">Niveau</dt><dd class="text-sm font-medium text-gray-900 mt-0.5">{{ $filiere->level ?: '—' }}</dd></div>
                <div><dt class="text-xs text-gray-400 font-semibold uppercase">Statut</dt>
                    <dd class="mt-0.5">
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full {{ $filiere->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $filiere->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            {{ $filiere->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </dd>
                </div>
                <div class="sm:col-span-2"><dt class="text-xs text-gray-400 font-semibold uppercase">Slug / URL</dt><dd class="text-sm font-mono text-navy mt-0.5">/formations/filiere/{{ $filiere->slug }}</dd></div>
            </div>
        </div>

        {{-- Conditions d'accès --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-amber-500 px-5 py-3">
                <h3 class="text-white font-semibold text-sm">Conditions d'accès</h3>
            </div>
            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Français</p>
                    <pre class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $filiere->conditions_acces_fr ?: '—' }}</pre>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-2">العربية</p>
                    <pre class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed" dir="rtl">{{ $filiere->conditions_acces_ar ?: '—' }}</pre>
                </div>
            </div>
        </div>

        {{-- Pièces obligatoires --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-5 py-3 flex items-center justify-between">
                <h3 class="text-white font-semibold text-sm">Pièces obligatoires ({{ $filiere->requiredDocuments->count() }})</h3>
            </div>

            {{-- Add form --}}
            <form method="POST" action="{{ route('admin.filieres.documents.store', $filiere) }}" class="p-5 border-b border-gray-100 bg-gray-50">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Titre FR <span class="text-red-500">*</span></label>
                        <input type="text" name="title_fr" placeholder="Ex: Copie CIN" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Titre AR</label>
                        <input type="text" name="title_ar" placeholder="نسخة من البطاقة الوطنية" dir="rtl"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30">
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_required" value="1" checked class="w-4 h-4 text-navy rounded">
                        <span class="text-xs font-semibold text-gray-600">Obligatoire</span>
                    </label>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajouter la pièce
                    </button>
                </div>
            </form>

            {{-- List --}}
            @if($filiere->requiredDocuments->isEmpty())
            <div class="p-8 text-center text-gray-400 text-sm">Aucune pièce définie pour cette filière.</div>
            @else
            <ul class="divide-y divide-gray-100">
                @foreach($filiere->requiredDocuments as $doc)
                <li class="px-5 py-3.5 flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full {{ $doc->is_required ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center text-xs font-bold shrink-0">
                        {{ $doc->position }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $doc->title_fr }}</p>
                        @if($doc->title_ar)
                        <p class="text-xs text-gray-400" dir="rtl">{{ $doc->title_ar }}</p>
                        @endif
                    </div>
                    <span class="inline-flex items-center text-xs px-2 py-0.5 rounded-full {{ $doc->is_required ? 'bg-red-50 text-red-600' : 'bg-gray-100 text-gray-500' }}">
                        {{ $doc->is_required ? 'Obligatoire' : 'Optionnelle' }}
                    </span>
                    <form method="POST" action="{{ route('admin.filieres.documents.destroy', [$filiere, $doc]) }}"
                          onsubmit="return confirm('Supprimer cette pièce ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">

        {{-- Preview --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if($filiere->image_path)
            <img src="{{ $filiere->image_url }}" alt="{{ $filiere->title_fr }}" class="w-full h-40 object-cover">
            @else
            <div class="h-32 bg-gradient-to-br from-navy to-sea flex items-center justify-center">
                <span class="text-white/30 text-sm">Pas d'image</span>
            </div>
            @endif
            <div class="p-4">
                <span class="inline-block bg-gold text-navy text-xs font-bold px-2 py-1 rounded mb-2">{{ $filiere->badge }}</span>
                <p class="text-sm text-gray-600 line-clamp-3">{{ $filiere->description_fr ?: $filiere->description }}</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4 space-y-2">
            <a href="{{ route('admin.filieres.edit', $filiere) }}"
               class="flex items-center gap-2 w-full px-4 py-2.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-sm font-medium rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Modifier la filière
            </a>
            <a href="{{ route('formations.filiere.show', $filiere->slug) }}" target="_blank"
               class="flex items-center gap-2 w-full px-4 py-2.5 bg-sea/5 hover:bg-sea/20 text-sea text-sm font-medium rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Voir la page publique
            </a>
        </div>

    </div>

</div>

@endsection
