@extends('layouts.admin')

@section('title', 'Nouvelle filière')
@section('page-title', 'Nouvelle filière')
@section('page-subtitle', 'Ajouter une filière à la page d\'accueil')

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <h2 class="font-semibold text-gray-900 text-sm">Créer une filière</h2>
        </div>

        <form method="POST" action="{{ route('admin.filieres.store') }}"
              enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            {{-- Title --}}
            <div>
                <label for="title" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                    Titre de la filière <span class="text-red-500">*</span>
                </label>
                <input id="title" name="title" type="text"
                       value="{{ old('title') }}"
                       placeholder="Ex: Navigation Maritime"
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
                       value="{{ old('badge') }}"
                       placeholder="Ex: Brevet de Patron, Certificat Professionnel…"
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
                       value="{{ old('duration') }}"
                       placeholder="Ex: 24 mois, 6 semaines…"
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
                          placeholder="Décrivez brièvement le contenu et les objectifs de cette filière…"
                          class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none
                                 {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('description') }}</textarea>
                @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Icon upload --}}
            <div>
                <label for="icon" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                    Icône / Logo de la filière
                    <span class="font-normal text-gray-400 normal-case tracking-normal ml-1">(JPG, PNG, SVG — max 2 Mo)</span>
                </label>
                <input id="icon" name="icon" type="file"
                       accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy/5 file:text-navy hover:file:bg-navy/10 transition
                              {{ $errors->has('icon') ? 'border border-red-400 bg-red-50 rounded-lg p-1' : '' }}">
                @error('icon')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                <p class="mt-1.5 text-xs text-gray-400">Si aucune icône n'est uploadée, un pictogramme maritime par défaut sera affiché.</p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('admin.filieres.index') }}"
                   class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-navy hover:bg-navy-dark text-white text-sm font-bold rounded-lg transition-all shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Créer la filière
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
