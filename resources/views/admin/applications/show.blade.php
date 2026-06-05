@extends('layouts.admin')

@section('title', 'Dossier — ' . $application->full_name)
@section('page-title', $application->full_name)
@section('page-subtitle', 'Dossier n° ' . str_pad($application->id, 4, '0', STR_PAD_LEFT) . ' — soumis le ' . $application->created_at->format('d/m/Y à H:i'))

@section('content')

@php
$tabMap = ['En attente' => 'en_attente', 'Validé' => 'accepte', 'Rejeté' => 'refuse'];
$currentTab = $tabMap[$application->status] ?? 'en_attente';
@endphp

<div class="mb-5">
    <a href="{{ route('admin.applications.index', ['tab' => $currentTab]) }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-navy transition-colors font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Left: detailed info ──────────────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-5">

        @php
        $sections = [
            ['title' => 'Informations de candidature', 'fields' => [
                ['label' => 'Type de formation',  'value' => $application->type_formation],
                ['label' => 'Section',            'value' => $application->section_candidature],
                ['label' => 'Niveau scolaire',    'value' => $application->niveau_scolaire],
            ]],
            ['title' => 'Identité', 'fields' => [
                ['label' => 'Nom',              'value' => $application->nom],
                ['label' => 'Prénom',           'value' => $application->prenom],
                ['label' => 'Numéro CIN',       'value' => $application->cin ?? '—'],
                ['label' => 'Genre',            'value' => $application->genre],
                ['label' => 'Date naissance',   'value' => $application->date_naissance->format('d/m/Y')],
                ['label' => 'Lieu naissance',   'value' => $application->lieu_naissance],
            ]],
            ['title' => 'Coordonnées & Localisation', 'fields' => [
                ['label' => 'E-mail',           'value' => $application->email],
                ['label' => 'Téléphone',        'value' => $application->telephone],
                ['label' => 'Région',           'value' => $application->region],
                ['label' => 'Ville',            'value' => $application->ville],
                ['label' => 'Adresse postale',  'value' => $application->adresse_postale],
            ]],
        ];
        @endphp

        @foreach($sections as $section)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-5 py-3">
                <h3 class="text-white font-semibold text-sm">{{ $section['title'] }}</h3>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($section['fields'] as $field)
                <div class="{{ $field['label'] === 'Adresse postale' ? 'sm:col-span-2' : '' }}">
                    <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5">{{ $field['label'] }}</dt>
                    @if($field['label'] === 'Numéro CIN')
                    <dd class="text-sm font-mono font-semibold text-gray-900 tracking-wider">{{ $field['value'] }}</dd>
                    @else
                    <dd class="text-sm font-medium text-gray-900 leading-relaxed">{{ $field['value'] }}</dd>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>

    {{-- ── Right: sidebar ───────────────────────────────────────────────────── --}}
    <div class="space-y-5">

        {{-- Quick action buttons --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100 flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full
                    {{ $application->status === 'Validé' ? 'bg-green-100 text-green-700' : ($application->status === 'Rejeté' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $application->status === 'Validé' ? 'bg-green-500' : ($application->status === 'Rejeté' ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                    {{ $application->status === 'Validé' ? 'Accepté' : ($application->status === 'Rejeté' ? 'Refusé' : 'En attente') }}
                </span>
                <span class="text-xs text-gray-500">Statut actuel</span>
            </div>
            <div class="p-4 space-y-2">
                @if($application->status !== 'Validé')
                <form method="POST" action="{{ route('admin.applications.status', $application) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="Validé">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Accepter le candidat
                    </button>
                </form>
                @endif

                @if($application->status !== 'Rejeté')
                <form method="POST" action="{{ route('admin.applications.status', $application) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="Rejeté">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Refuser le candidat
                    </button>
                </form>
                @endif

                @if($application->status !== 'En attente')
                <form method="POST" action="{{ route('admin.applications.status', $application) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="En attente">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 border border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-semibold rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Remettre en attente
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Metadata --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h4 class="font-semibold text-gray-900 text-sm mb-4">Métadonnées</h4>
            <div class="space-y-2.5 text-xs">
                <div class="flex justify-between"><span class="text-gray-500">N° dossier</span><span class="font-mono font-bold text-navy">#{{ str_pad($application->id, 4, '0', STR_PAD_LEFT) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Soumis le</span><span class="font-medium">{{ $application->created_at->format('d/m/Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Heure</span><span class="font-medium">{{ $application->created_at->format('H:i') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">CIN</span><span class="font-mono font-bold text-navy">{{ $application->cin ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Déclaration</span><span class="text-green-600 font-medium">✓ Acceptée</span></div>
            </div>
        </div>

        {{-- Contact / Delete actions --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-2">
            <a href="mailto:{{ $application->email }}"
               class="flex items-center gap-2 w-full px-4 py-2.5 bg-sea-light hover:bg-sea/20 text-sea text-sm font-medium rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Contacter par e-mail
            </a>
            <form method="POST" action="{{ route('admin.applications.destroy', $application) }}"
                  onsubmit="return confirm('Supprimer ce dossier définitivement ?')">
                @csrf @method('DELETE')
                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Supprimer ce dossier
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
