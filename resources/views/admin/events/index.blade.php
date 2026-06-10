@extends('layouts.admin')

@section('title', 'Événements')
@section('page-title', 'Événements')
@section('page-subtitle', 'Gérer les événements publics du CQPM Nador')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h2 class="text-sm font-semibold text-gray-900">Liste des événements</h2>
        <p class="text-xs text-gray-500 mt-1">Dates, lieux, contenus FR/AR, image et SEO.</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Ajouter un événement
    </a>
</div>

<form method="GET" action="{{ route('admin.events.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 mb-5 grid grid-cols-1 md:grid-cols-4 gap-3">
    <div class="md:col-span-2">
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Recherche</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Titre ou slug" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Statut</label>
        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white">
            <option value="">Tous</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actifs</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactifs</option>
        </select>
    </div>
    <div class="flex items-end gap-2">
        <button class="flex-1 px-4 py-2.5 bg-navy text-white text-sm font-semibold rounded-lg">Filtrer</button>
        <a href="{{ route('admin.events.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-semibold rounded-lg">Reset</a>
    </div>
</form>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-4 py-3">Événement</th>
                    <th class="text-left px-4 py-3">Slug</th>
                    <th class="text-center px-4 py-3">Date</th>
                    <th class="text-center px-4 py-3">Statut</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($events as $event)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3.5">
                        <div class="font-semibold text-navy">{{ $event->title_fr }}</div>
                        <div class="text-xs text-gray-500 mt-0.5" dir="rtl">{{ $event->title_ar }}</div>
                    </td>
                    <td class="px-4 py-3.5"><a href="{{ route('events.show', $event) }}" target="_blank" class="font-mono text-xs text-sea hover:underline">/events/{{ $event->slug }}</a></td>
                    <td class="px-4 py-3.5 text-center text-xs text-gray-500">{{ optional($event->starts_at)->format('d/m/Y H:i') ?: '—' }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <span class="inline-flex px-2 py-1 rounded-full {{ $event->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs font-semibold">{{ $event->is_active ? 'Actif' : 'Inactif' }}</span>
                    </td>
                    <td class="px-4 py-3.5">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.events.edit', $event) }}" class="px-3 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded">Modifier</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Supprimer cet événement ?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 text-xs font-semibold rounded">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">Aucun événement trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($events->hasPages())
<div class="mt-5">{{ $events->links() }}</div>
@endif

@endsection
