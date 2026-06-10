@extends('layouts.admin')

@section('title', 'Modifier — ' . ($filiere->title_fr ?: $filiere->title))
@section('page-title', 'Modifier la filière')
@section('page-subtitle', $filiere->title_fr ?: $filiere->title)

@section('content')

<div class="max-w-4xl">

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('admin.filieres.show', $filiere) }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-navy font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900 text-sm">Modifier la filière</h2>
        </div>

        <form id="filiere-update-form" method="POST" action="{{ route('admin.filieres.update', $filiere) }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf @method('PUT')

            {{-- Titres --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Titre FR <span class="text-red-500">*</span></label>
                    <input name="title_fr" type="text" value="{{ old('title_fr', $filiere->title_fr ?: $filiere->title) }}"
                           class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('title_fr') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                    @error('title_fr')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Titre AR</label>
                    <input name="title_ar" type="text" value="{{ old('title_ar', $filiere->title_ar) }}" dir="rtl"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
            </div>

            {{-- Badge + Level + Duration --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Badge <span class="text-red-500">*</span></label>
                    <input name="badge" type="text" value="{{ old('badge', $filiere->badge) }}"
                           class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('badge') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                    @error('badge')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Niveau / Qualification</label>
                    <input name="level" type="text" value="{{ old('level', $filiere->level) }}"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Durée <span class="text-red-500">*</span></label>
                    <input name="duration" type="text" value="{{ old('duration', $filiere->duration) }}"
                           class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('duration') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                    @error('duration')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Description FR <span class="text-red-500">*</span></label>
                    <textarea name="description_fr" rows="4" class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('description_fr') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('description_fr', $filiere->description_fr ?: $filiere->description) }}</textarea>
                    @error('description_fr')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Description AR</label>
                    <textarea name="description_ar" rows="4" dir="rtl" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('description_ar', $filiere->description_ar) }}</textarea>
                </div>
            </div>

            {{-- Objectifs --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Objectifs FR</label>
                    <textarea name="objectifs_fr" rows="5" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('objectifs_fr', $filiere->objectifs_fr) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Objectifs AR</label>
                    <textarea name="objectifs_ar" rows="5" dir="rtl" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('objectifs_ar', $filiere->objectifs_ar) }}</textarea>
                </div>
            </div>

            {{-- Programme --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Programme FR</label>
                    <textarea name="programme_fr" rows="5" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('programme_fr', $filiere->programme_fr) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Programme AR</label>
                    <textarea name="programme_ar" rows="5" dir="rtl" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('programme_ar', $filiere->programme_ar) }}</textarea>
                </div>
            </div>

            {{-- Débouchés --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Débouchés FR</label>
                    <textarea name="debouches_fr" rows="4" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('debouches_fr', $filiere->debouches_fr) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Débouchés AR</label>
                    <textarea name="debouches_ar" rows="4" dir="rtl" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('debouches_ar', $filiere->debouches_ar) }}</textarea>
                </div>
            </div>

            {{-- Conditions d'accès --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Conditions d'accès FR</label>
                    <textarea name="conditions_acces_fr" rows="5" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('conditions_acces_fr', $filiere->conditions_acces_fr) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Conditions d'accès AR</label>
                    <textarea name="conditions_acces_ar" rows="5" dir="rtl" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ old('conditions_acces_ar', $filiere->conditions_acces_ar) }}</textarea>
                </div>
            </div>

            {{-- Images --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Icône</label>
                    @if($filiere->icon_path)
                    <img src="{{ $filiere->icon_url }}" alt="icon" class="w-12 h-12 object-cover rounded-lg border mb-2">
                    @endif
                    <input name="icon" type="file" accept="image/*"
                           class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy/5 file:text-navy hover:file:bg-navy/10 transition">
                    @error('icon')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Image principale</label>
                    @if($filiere->image_path)
                    <img src="{{ $filiere->image_url }}" alt="image" class="w-32 h-16 object-cover rounded-lg border mb-2">
                    @endif
                    <input name="image" type="file" accept="image/*"
                           class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy/5 file:text-navy hover:file:bg-navy/10 transition">
                    @error('image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Position + Statut --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">Position</label>
                    <input name="position" type="number" value="{{ old('position', $filiere->position) }}"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
                <div class="flex items-end pb-2.5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $filiere->is_active) ? 'checked' : '' }} class="w-4 h-4 text-navy rounded">
                        <span class="text-sm font-medium text-gray-700">Filière active (visible sur le site)</span>
                    </label>
                </div>
            </div>

        </form>

        <div class="flex items-center justify-between px-6 pb-6 pt-4 border-t border-gray-100">
            <form method="POST" action="{{ route('admin.filieres.destroy', $filiere) }}"
                  onsubmit="return confirm('Supprimer définitivement la filière « {{ $filiere->title_fr ?: $filiere->title }} » ?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Supprimer
                </button>
            </form>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.filieres.show', $filiere) }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">Annuler</a>
                <button type="submit" form="filiere-update-form"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-navy hover:bg-navy-dark text-white text-sm font-bold rounded-lg transition-all shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
