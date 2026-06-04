@extends('layouts.admin')

@section('title', 'Réclamation — ' . $complaint->full_name)
@section('page-title', 'Détail de la réclamation')
@section('page-subtitle', 'Soumis le ' . $complaint->created_at->format('d/m/Y à H:i'))

@section('content')

<div class="max-w-3xl">

    {{-- Back button + status badge --}}
    <div class="flex items-center justify-between mb-5">
        <a href="{{ $complaint->is_archived ? route('admin.complaints.archived') : route('admin.complaints.index') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-navy font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ $complaint->is_archived ? 'Retour aux archives' : 'Retour à la liste' }}
        </a>

        @if($complaint->is_archived)
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 text-amber-700 text-xs font-bold rounded-lg">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Réclamation traitée — Archivée
        </span>
        @else
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg">
            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
            En attente de traitement
        </span>
        @endif
    </div>

    {{-- Sender info card --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <h3 class="font-semibold text-gray-900 text-sm">Informations de l'expéditeur</h3>
        </div>
        <div class="px-5 py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Nom et prénom</p>
                <p class="text-sm font-semibold text-gray-900">{{ $complaint->full_name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Adresse e-mail</p>
                <a href="mailto:{{ $complaint->email }}"
                   class="text-sm text-sea hover:text-navy font-medium transition-colors">
                    {{ $complaint->email }}
                </a>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Téléphone</p>
                <a href="tel:{{ $complaint->phone }}"
                   class="text-sm text-sea hover:text-navy font-medium transition-colors">
                    {{ $complaint->phone }}
                </a>
            </div>
        </div>
    </div>

    {{-- Message card --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
        <div class="px-5 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Objet</p>
            <h2 class="text-base font-bold text-navy">{{ $complaint->subject }}</h2>
        </div>
        <div class="px-5 py-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Message</p>
            <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 rounded-lg px-4 py-4 border border-gray-100">{{ $complaint->message }}</div>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 flex items-center gap-2">
            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-xs text-gray-400">
                Reçu le {{ $complaint->created_at->format('d/m/Y') }} à {{ $complaint->created_at->format('H:i') }}
            </span>
        </div>
    </div>

    {{-- Action bar --}}
    <div class="flex flex-col sm:flex-row gap-3">

        {{-- Reply --}}
        <div class="flex-1 bg-sea-light border border-sea/20 rounded-xl px-5 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-sea/20 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-sea" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-navy">Répondre</p>
                    <p class="text-xs text-gray-500">Ouvrir le client e-mail</p>
                </div>
            </div>
            <a href="mailto:{{ $complaint->email }}?subject=Réponse%3A%20{{ urlencode($complaint->subject) }}"
               class="shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-navy hover:bg-navy-dark text-white text-xs font-bold rounded-lg transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Répondre par e-mail
            </a>
        </div>

        {{-- Archive / Unarchive toggle --}}
        @if(! $complaint->is_archived)
        <form method="POST" action="{{ route('admin.complaints.archive', $complaint) }}"
              class="sm:w-auto bg-green-50 border border-green-200 rounded-xl px-5 py-4 flex items-center gap-4">
            @csrf
            @method('PATCH')
            <div class="flex items-center gap-3 flex-1">
                <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-green-800">Marquer comme traitée</p>
                    <p class="text-xs text-green-600">Déplacer vers les archives</p>
                </div>
            </div>
            <button type="submit"
                    onclick="return confirm('Archiver cette réclamation comme traitée ?')"
                    class="shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2L19 8"/>
                </svg>
                Archiver
            </button>
        </form>
        @else
        <form method="POST" action="{{ route('admin.complaints.unarchive', $complaint) }}"
              class="sm:w-auto bg-amber-50 border border-amber-200 rounded-xl px-5 py-4 flex items-center gap-4">
            @csrf
            @method('PATCH')
            <div class="flex items-center gap-3 flex-1">
                <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-amber-800">Restaurer</p>
                    <p class="text-xs text-amber-600">Remettre dans les réclamations actives</p>
                </div>
            </div>
            <button type="submit"
                    onclick="return confirm('Restaurer cette réclamation dans les actives ?')"
                    class="shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Désarchiver
            </button>
        </form>
        @endif

    </div>

</div>

@endsection
