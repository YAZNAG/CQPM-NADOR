@extends('layouts.admin')

@section('title', 'Dossier — ' . $application->full_name)
@section('page-title', $application->full_name)
@section('page-subtitle', 'Dossier n° ' . str_pad($application->id, 4, '0', STR_PAD_LEFT) . ' — soumis le ' . $application->created_at->format('d/m/Y à H:i'))

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.applications.index') }}"
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
                    <dd class="text-sm font-medium text-gray-900 leading-relaxed">{{ $field['value'] }}</dd>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>

    {{-- ── Right: sidebar ───────────────────────────────────────────────────── --}}
    <div class="space-y-5">

        {{-- Status update widget --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-5 py-3">
                <h3 class="text-white font-semibold text-sm">Statut du dossier</h3>
            </div>
            <div class="p-5">
                {{-- Current badge --}}
                <div class="mb-4 flex items-center gap-3">
                    <span class="text-xs text-gray-500">Statut actuel :</span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full
                        {{ $application->status === 'Validé' ? 'bg-green-100 text-green-700' : ($application->status === 'Rejeté' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $application->status === 'Validé' ? 'bg-green-500' : ($application->status === 'Rejeté' ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                        {{ $application->status }}
                    </span>
                </div>

                {{-- Update form --}}
                <form method="POST" action="{{ route('admin.applications.status', $application) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Changer le statut</label>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach(\App\Models\Application::STATUSES as $s)
                        <label class="flex items-center gap-2.5 p-2.5 rounded-lg border cursor-pointer transition-all
                            {{ $application->status === $s ? 'border-navy bg-navy/5' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="status" value="{{ $s }}" {{ $application->status === $s ? 'checked' : '' }}
                                   class="text-navy focus:ring-navy">
                            <span class="text-sm font-medium {{ $application->status === $s ? 'text-navy' : 'text-gray-600' }}">{{ $s }}</span>
                            @if($s === 'Validé')
                            <span class="ml-auto w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            @elseif($s === 'Rejeté')
                            <span class="ml-auto w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            @else
                            <span class="ml-auto w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                            @endif
                        </label>
                        @endforeach
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all mt-2">
                        Mettre à jour le statut
                    </button>
                </form>
            </div>
        </div>

        {{-- Metadata --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h4 class="font-semibold text-gray-900 text-sm mb-4">Métadonnées</h4>
            <div class="space-y-2.5 text-xs">
                <div class="flex justify-between"><span class="text-gray-500">N° dossier</span><span class="font-mono font-bold text-navy">#{{ str_pad($application->id, 4, '0', STR_PAD_LEFT) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Soumis le</span><span class="font-medium">{{ $application->created_at->format('d/m/Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Heure</span><span class="font-medium">{{ $application->created_at->format('H:i') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Déclaration</span><span class="text-green-600 font-medium">✓ Acceptée</span></div>
            </div>
        </div>

        {{-- Actions --}}
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
