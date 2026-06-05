@extends('layouts.admin')

@section('title', 'Modifier — ' . $filiere->title)
@section('page-title', 'Modifier la filière')
@section('page-subtitle', $filiere->title)

@section('content')

<div class="max-w-2xl">

    <a href="{{ route('admin.filieres.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-navy font-medium mb-5 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <h2 class="font-semibold text-gray-900 text-sm">Modifier la filière</h2>
        </div>

        <form id="filiere-update-form"
              method="POST" action="{{ route('admin.filieres.update', $filiere) }}"
              enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label for="title" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                    Titre de la filière <span class="text-red-500">*</span>
                </label>
                <input id="title" name="title" type="text"
                       value="{{ old('title', $filiere->title) }}"
                       class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition
                              {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Badge --}}
            <div>
                <label for="badge" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                    Badge / Niveau de qualification <span class="text-red-500">*</span>
                </label>
                <input id="badge" name="badge" type="text"
                       value="{{ old('badge', $filiere->badge) }}"
                       class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition
                              {{ $errors->has('badge') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('badge')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Duration --}}
            <div>
                <label for="duration" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                    Durée <span class="text-red-500">*</span>
                </label>
                <input id="duration" name="duration" type="text"
                       value="{{ old('duration', $filiere->duration) }}"
                       class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition
                              {{ $errors->has('duration') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('duration')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none
                                 {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('description', $filiere->description) }}</textarea>
                @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Icon --}}
            <div>
                <label for="icon" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                    Icône / Logo
                    <span class="font-normal text-gray-400 normal-case tracking-normal ml-1">(laisser vide pour conserver l'actuelle)</span>
                </label>

                {{-- Current icon preview --}}
                @if($filiere->icon_path)
                <div class="mb-3 flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <img src="{{ $filiere->icon_url }}"
                         alt="Icône actuelle"
                         class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Icône actuelle</p>
                        <p class="text-xs text-gray-400">Uploadez une nouvelle image pour la remplacer.</p>
                    </div>
                </div>
                @endif

                <input id="icon" name="icon" type="file"
                       accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy/5 file:text-navy hover:file:bg-navy/10 transition
                              {{ $errors->has('icon') ? 'border border-red-400 bg-red-50 rounded-lg p-1' : '' }}">
                @error('icon')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

        </form>{{-- ← update form ends here, before the delete form --}}

        {{-- Action bar — two sibling forms, never nested --}}
        <div class="flex items-center justify-between px-6 pb-6 pt-4 border-t border-gray-100">

            {{-- Delete (standalone form) --}}
            <form method="POST" action="{{ route('admin.filieres.destroy', $filiere) }}"
                  onsubmit="return confirm('Supprimer définitivement la filière « {{ $filiere->title }} » ?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer la filière
                </button>
            </form>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.filieres.index') }}"
                   class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Annuler
                </a>
                {{-- form="filiere-update-form" links this button to the update form above --}}
                <button type="submit" form="filiere-update-form"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-navy hover:bg-navy-dark text-white text-sm font-bold rounded-lg transition-all shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </div>

</div>

@endsection
