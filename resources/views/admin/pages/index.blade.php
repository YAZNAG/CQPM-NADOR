@extends('layouts.admin')

@section('title', 'Pages')
@section('page-title', 'Gestion des pages')
@section('page-subtitle', 'Gestion du site > Pages')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h2 class="text-sm font-semibold text-gray-900">Pages publiques</h2>
        <p class="text-xs text-gray-500 mt-1">Gérez les contenus FR/AR, images, SEO et sections des pages du site.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}"
       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter une page
    </a>
</div>

<form method="GET" action="{{ route('admin.pages.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 mb-5 grid grid-cols-1 md:grid-cols-4 gap-3">
    <div class="md:col-span-2">
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Recherche</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Titre ou slug"
               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Statut</label>
        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            <option value="">Tous</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actives</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactives</option>
        </select>
    </div>
    <div class="flex items-end gap-2">
        <button type="submit" class="flex-1 px-4 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
            Filtrer
        </button>
        <a href="{{ route('admin.pages.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg transition-all">
            Réinitialiser
        </a>
    </div>
</form>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-900 text-sm">Liste des pages</h3>
    </div>

    @if($pages->isEmpty())
        <div class="py-14 text-center">
            <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h7l2 2h5a2 2 0 012 2v10a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-400 text-sm">Aucune page trouvée.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        <th class="text-left px-4 py-3">Titre FR</th>
                        <th class="text-left px-4 py-3">Titre AR</th>
                        <th class="text-left px-4 py-3">Slug</th>
                        <th class="text-center px-4 py-3">Statut</th>
                        <th class="text-center px-4 py-3">Position</th>
                        <th class="text-center px-4 py-3">Sections</th>
                        <th class="text-right px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pages as $page)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3.5 font-semibold text-navy">{{ $page->title_fr }}</td>
                        <td class="px-4 py-3.5 text-gray-700" dir="rtl">{{ $page->title_ar }}</td>
                        <td class="px-4 py-3.5">
                            <a href="{{ $page->slug === 'accueil' ? route('home') : route('pages.show', $page) }}" target="_blank"
                               class="font-mono text-xs text-sea hover:underline">/{{ $page->slug }}</a>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            @if($page->is_active)
                                <span class="inline-flex px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">Actif</span>
                            @else
                                <span class="inline-flex px-2 py-1 rounded-full bg-gray-100 text-gray-500 text-xs font-semibold">Inactif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-center font-mono text-xs text-gray-500">{{ $page->position }}</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex px-2 py-1 rounded-full bg-navy/5 text-navy text-xs font-semibold">{{ $page->sections_count }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex flex-wrap items-center justify-end gap-2">
                                <a href="{{ route('admin.pages.sections.index', $page) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-sea-light hover:bg-sea hover:text-white text-sea text-xs font-semibold rounded transition-all">
                                    Sections
                                </a>
                                <a href="{{ route('admin.pages.edit', $page) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded transition-all">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Supprimer cette page et toutes ses sections ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 text-xs font-semibold rounded transition-all">
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

@if($pages->hasPages())
<div class="mt-5">
    {{ $pages->links() }}
</div>
@endif

@endsection
