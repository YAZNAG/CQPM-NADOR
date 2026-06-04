@extends('layouts.admin')

@section('title', 'Candidatures')
@section('page-title', 'Gestion des candidatures')
@section('page-subtitle', $applications->total() . ' dossier(s) au total')

@section('content')

{{-- ── Search & Filters ─────────────────────────────────────────────────────── --}}
<form method="GET" action="{{ route('admin.applications.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
    <div class="flex flex-wrap gap-3 items-end">
        {{-- Search by name/email --}}
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5 tracking-wide">Recherche</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom, prénom ou e-mail..."
                       class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
        </div>
        {{-- Filter: Type formation --}}
        <div class="min-w-44">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5 tracking-wide">Type de formation</label>
            <select name="type" class="w-full py-2.5 px-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                <option value="">Tous</option>
                @foreach($types as $t)
                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        {{-- Filter: Status --}}
        <div class="min-w-36">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5 tracking-wide">Statut</label>
            <select name="status" class="w-full py-2.5 px-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                <option value="">Tous</option>
                @foreach(\App\Models\Application::STATUSES as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        {{-- Buttons --}}
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
                Filtrer
            </button>
            @if(request()->hasAny(['q','type','status']))
            <a href="{{ route('admin.applications.index') }}" class="px-4 py-2.5 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-all">
                Réinitialiser
            </a>
            @endif
        </div>
    </div>
</form>

{{-- ── Table ────────────────────────────────────────────────────────────────── --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900 text-sm">Dossiers de candidature</h3>
        <div class="flex items-center gap-3">
            {{-- Status legend --}}
            <div class="hidden sm:flex items-center gap-3 text-xs text-gray-500">
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-400"></span>En attente</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span>Validé</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span>Rejeté</span>
            </div>
            <span class="bg-navy/10 text-navy text-xs font-bold px-2.5 py-1 rounded-full">{{ $applications->total() }}</span>
        </div>
    </div>

    @if($applications->isEmpty())
    <div class="py-16 text-center">
        <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p class="text-gray-400 text-sm">Aucun résultat pour ces filtres.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-4 py-3">#</th>
                    <th class="text-left px-4 py-3">Candidat</th>
                    <th class="text-left px-4 py-3">Formation / Section</th>
                    <th class="text-left px-4 py-3">Région</th>
                    <th class="text-left px-4 py-3">Statut</th>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($applications as $app)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3.5 text-gray-400 text-xs font-mono">{{ $app->id }}</td>

                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 bg-navy/10 rounded-full flex items-center justify-center text-navy font-bold text-xs shrink-0">
                                {{ strtoupper(substr($app->prenom, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">{{ $app->full_name }}</div>
                                <div class="text-gray-400 text-xs">{{ $app->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3.5">
                        <div class="text-xs font-medium text-navy">{{ $app->type_formation }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 truncate max-w-36">{{ $app->section_candidature }}</div>
                    </td>

                    <td class="px-4 py-3.5 text-gray-500 text-xs">{{ $app->region }}</td>

                    {{-- Status badge + quick-change --}}
                    <td class="px-4 py-3.5">
                        <form method="POST" action="{{ route('admin.applications.status', $app) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs font-semibold rounded-full px-2.5 py-1 border-0 cursor-pointer focus:outline-none focus:ring-2 focus:ring-navy/30
                                    {{ $app->status === 'Validé' ? 'bg-green-100 text-green-700' : ($app->status === 'Rejeté' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                @foreach(\App\Models\Application::STATUSES as $s)
                                <option value="{{ $s }}" {{ $app->status === $s ? 'selected' : '' }}
                                        class="{{ $s === 'Validé' ? 'bg-green-100 text-green-700' : ($s === 'Rejeté' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ $s }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </td>

                    <td class="px-4 py-3.5 text-gray-400 text-xs">{{ $app->created_at->format('d/m/Y') }}</td>

                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.applications.show', $app) }}"
                               class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-medium rounded-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Voir
                            </a>
                            <form method="POST" action="{{ route('admin.applications.destroy', $app) }}"
                                  onsubmit="return confirm('Supprimer ce dossier ? Action irréversible.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-500 text-xs font-medium rounded-lg transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Suppr.
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($applications->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
        {{ $applications->links() }}
    </div>
    @endif
    @endif
</div>

@endsection
