@extends('layouts.admin')

@section('title', 'Sections')
@section('page-title', 'Sections de la page')
@section('page-subtitle', 'Gestion du site > Pages > Sections')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h2 class="text-sm font-semibold text-gray-900">{{ $page->title_fr }} / <span dir="rtl">{{ $page->title_ar }}</span></h2>
        <p class="text-xs text-gray-500 mt-1">Gérez l’ordre, le statut et le contenu des sections de cette page.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.pages.index') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg transition-all">
            Pages
        </a>
        <a href="{{ route('admin.pages.sections.create', $page) }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter une section
        </a>
    </div>
</div>

<form id="sections-order-form" method="POST" action="{{ route('admin.pages.sections.order', $page) }}" class="hidden">
    @csrf
    @method('PATCH')
</form>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="font-semibold text-gray-900 text-sm">Sections</h3>
            <p class="text-gray-400 text-xs mt-0.5">Modifiez les positions puis enregistrez l’ordre.</p>
        </div>
        <button type="submit" form="sections-order-form"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gold hover:bg-gold-dark text-navy text-sm font-bold rounded-lg transition-all">
            Enregistrer l’ordre
        </button>
    </div>

    @if($sections->isEmpty())
        <div class="py-14 text-center">
            <p class="text-gray-400 text-sm">Aucune section créée pour cette page.</p>
            <a href="{{ route('admin.pages.sections.create', $page) }}" class="mt-3 inline-block text-sm font-semibold text-navy underline">Créer la première section</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        <th class="text-center px-4 py-3">Ordre</th>
                        <th class="text-left px-4 py-3">Clé</th>
                        <th class="text-left px-4 py-3">Type</th>
                        <th class="text-left px-4 py-3">Titre FR</th>
                        <th class="text-left px-4 py-3">Titre AR</th>
                        <th class="text-center px-4 py-3">Statut</th>
                        <th class="text-right px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($sections as $section)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3.5 text-center">
                            <input form="sections-order-form" type="number" name="positions[{{ $section->id }}]" min="0" value="{{ $section->position }}"
                                   class="w-20 border border-gray-300 rounded-lg px-2 py-1.5 text-center text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                        </td>
                        <td class="px-4 py-3.5 font-mono text-xs text-navy">{{ $section->section_key }}</td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">{{ $section->section_type }}</span>
                        </td>
                        <td class="px-4 py-3.5 font-semibold text-gray-800">{{ $section->title_fr ?: '—' }}</td>
                        <td class="px-4 py-3.5 text-gray-700" dir="rtl">{{ $section->title_ar ?: '—' }}</td>
                        <td class="px-4 py-3.5 text-center">
                            @if($section->is_active)
                                <span class="inline-flex px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">Actif</span>
                            @else
                                <span class="inline-flex px-2 py-1 rounded-full bg-gray-100 text-gray-500 text-xs font-semibold">Inactif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex flex-wrap items-center justify-end gap-2">
                                <form method="POST" action="{{ route('admin.pages.sections.toggle', [$page, $section]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded transition-all">
                                        {{ $section->is_active ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.pages.sections.edit', [$page, $section]) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded transition-all">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('admin.pages.sections.destroy', [$page, $section]) }}" onsubmit="return confirm('Supprimer cette section ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 text-xs font-semibold rounded transition-all">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
