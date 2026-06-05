@extends('layouts.admin')

@section('title', 'Candidatures')
@section('page-title', 'Gestion des candidatures')
@section('page-subtitle', 'Filtrage par statut — ' . ($counts['en_attente'] + $counts['accepte'] + $counts['refuse']) . ' dossier(s) au total')

@section('content')

{{-- ── Tab Navigation ────────────────────────────────────────────────────────── --}}
<div class="bg-white rounded-xl border border-gray-200 mb-5 overflow-hidden">
    <div class="flex items-center justify-between border-b border-gray-100 px-5">
        <div class="flex">
            @foreach([
                ['key' => 'en_attente', 'label' => 'En attente',  'count' => $counts['en_attente'], 'dot' => 'bg-amber-400'],
                ['key' => 'accepte',    'label' => 'Acceptés',     'count' => $counts['accepte'],    'dot' => 'bg-green-500'],
                ['key' => 'refuse',     'label' => 'Refusés',      'count' => $counts['refuse'],     'dot' => 'bg-red-500'],
            ] as $tabDef)
            <a href="{{ route('admin.applications.index', ['tab' => $tabDef['key']]) }}"
               class="flex items-center gap-2 px-5 py-4 text-sm font-semibold border-b-2 transition-all
                      {{ $tab === $tabDef['key']
                         ? 'border-navy text-navy'
                         : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <span class="w-2 h-2 rounded-full {{ $tabDef['dot'] }}"></span>
                {{ $tabDef['label'] }}
                <span class="text-xs font-bold px-2 py-0.5 rounded-full
                    {{ $tab === $tabDef['key'] ? 'bg-navy text-white' : 'bg-gray-100 text-gray-500' }}">
                    {{ $tabDef['count'] }}
                </span>
            </a>
            @endforeach
        </div>

        {{-- "Convertir en liste" shown only on Acceptés tab --}}
        @if($tab === 'accepte')
        <a href="{{ route('admin.applications.pdf') }}"
           class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition-all my-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            Convertir en liste (PDF)
        </a>
        @endif
    </div>

    {{-- ── Search & Type Filter ──────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.applications.index') }}" class="p-4 bg-gray-50 border-b border-gray-100">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <div class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-48">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5 tracking-wide">Recherche</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom, prénom ou e-mail..."
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy bg-white">
                </div>
            </div>
            <div class="min-w-52">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5 tracking-wide">Type de formation</label>
                <select name="type" class="w-full py-2 px-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy bg-white">
                    <option value="">Toutes les formations</option>
                    @foreach($types as $t)
                    <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
                    Filtrer
                </button>
                @if(request()->hasAny(['q','type']))
                <a href="{{ route('admin.applications.index', ['tab' => $tab]) }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-100 transition-all">
                    Réinitialiser
                </a>
                @endif
            </div>
        </div>
    </form>

    {{-- ── Table ─────────────────────────────────────────────────────────────── --}}
    @if($applications->isEmpty())
    <div class="py-16 text-center">
        <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-gray-400 text-sm">
            @if($tab === 'en_attente') Aucun dossier en attente.
            @elseif($tab === 'accepte') Aucun candidat accepté pour l'instant.
            @else Aucun dossier refusé.
            @endif
        </p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-4 py-3">#</th>
                    <th class="text-left px-4 py-3">Candidat</th>
                    <th class="text-left px-4 py-3">CIN</th>
                    <th class="text-left px-4 py-3">Formation / Section</th>
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
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0
                                {{ $tab === 'accepte' ? 'bg-green-100 text-green-700' : ($tab === 'refuse' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700') }}">
                                {{ strtoupper(substr($app->prenom, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">{{ $app->full_name }}</div>
                                <div class="text-gray-400 text-xs">{{ $app->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3.5">
                        <span class="text-xs font-mono font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">
                            {{ $app->cin ?? '—' }}
                        </span>
                    </td>

                    <td class="px-4 py-3.5">
                        <div class="text-xs font-medium text-navy">{{ $app->type_formation }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 truncate max-w-36">{{ $app->section_candidature }}</div>
                    </td>

                    <td class="px-4 py-3.5 text-gray-400 text-xs">{{ $app->created_at->format('d/m/Y') }}</td>

                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            {{-- View button --}}
                            <a href="{{ route('admin.applications.show', $app) }}"
                               class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-medium rounded-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Voir
                            </a>

                            {{-- Quick status action buttons --}}
                            @if($tab === 'en_attente')
                            <form method="POST" action="{{ route('admin.applications.status', $app) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Validé">
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-green-50 hover:bg-green-500 hover:text-white text-green-700 text-xs font-medium rounded-lg transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Accepter
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.applications.status', $app) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Rejeté">
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 text-xs font-medium rounded-lg transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Refuser
                                </button>
                            </form>

                            @elseif($tab === 'accepte')
                            <form method="POST" action="{{ route('admin.applications.status', $app) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="En attente">
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 hover:bg-amber-400 hover:text-white text-amber-700 text-xs font-medium rounded-lg transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    En attente
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.applications.status', $app) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Rejeté">
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 text-xs font-medium rounded-lg transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Refuser
                                </button>
                            </form>

                            @elseif($tab === 'refuse')
                            <form method="POST" action="{{ route('admin.applications.status', $app) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Validé">
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-green-50 hover:bg-green-500 hover:text-white text-green-700 text-xs font-medium rounded-lg transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Accepter
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.applications.status', $app) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="En attente">
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 hover:bg-amber-400 hover:text-white text-amber-700 text-xs font-medium rounded-lg transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    En attente
                                </button>
                            </form>
                            @endif

                            {{-- Delete button --}}
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
