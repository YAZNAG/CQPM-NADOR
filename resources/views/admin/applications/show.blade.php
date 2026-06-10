@extends('layouts.admin')

@section('title', 'Dossier — ' . $application->full_name)
@section('page-title', $application->full_name)
@section('page-subtitle', 'Dossier n° ' . str_pad($application->id, 4, '0', STR_PAD_LEFT) . ' — soumis le ' . $application->created_at->format('d/m/Y à H:i'))

@section('content')

@php
$tabMap = ['En attente' => 'en_attente', 'Incomplet' => 'en_attente', 'Validé' => 'accepte', 'Rejeté' => 'refuse'];
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

    {{-- Left: detailed info --}}
    <div class="lg:col-span-2 space-y-5">

        @php
        $sections = [
            ['title' => 'Informations de candidature', 'fields' => [
                ['label' => 'Filière',             'value' => $application->filiere?->title_fr ?: ($application->filiere?->title ?? '—')],
                ['label' => 'Type de formation',   'value' => $application->type_formation],
                ['label' => 'Section',             'value' => $application->section_candidature],
                ['label' => 'Niveau scolaire',     'value' => $application->niveau_scolaire],
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

        {{-- Conditions d'accès filière --}}
        @if($application->filiere && $application->filiere->conditions_acces_fr)
        <div class="bg-white rounded-xl border border-amber-200 overflow-hidden">
            <div class="bg-amber-500 px-5 py-3">
                <h3 class="text-white font-semibold text-sm">Conditions d'accès ({{ $application->filiere->title_fr }})</h3>
            </div>
            <div class="p-5">
                <pre class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $application->filiere->conditions_acces_fr }}</pre>
            </div>
        </div>
        @endif

        {{-- Pièces justificatives --}}
        @if($application->uploadedDocuments->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-5 py-3">
                <h3 class="text-white font-semibold text-sm">Pièces justificatives ({{ $application->uploadedDocuments->count() }})</h3>
            </div>
            <ul class="divide-y divide-gray-100">
                @foreach($application->uploadedDocuments as $doc)
                @php
                    $reqDoc = $doc->requiredDocument;
                    $uploaded = true;
                @endphp
                <li class="px-5 py-3.5 flex items-center gap-3">
                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center shrink-0">
                        @if(in_array($doc->mime_type, ['image/jpeg','image/png','image/jpg']))
                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        @else
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $reqDoc?->title_fr ?? 'Document' }}</p>
                        <p class="text-xs text-gray-400">{{ $doc->original_name }} — {{ $doc->file_size_human }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Reçu
                    </span>
                    <a href="{{ route('admin.applications.document.download', [$application, $doc]) }}"
                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Télécharger
                    </a>
                </li>
                @endforeach
            </ul>

            {{-- Pièces manquantes --}}
            @if($application->filiere)
            @php
                $uploadedDocIds = $application->uploadedDocuments->pluck('filiere_required_document_id')->toArray();
                $missingDocs    = $application->filiere->requiredDocuments->filter(fn($d) => $d->is_required && !in_array($d->id, $uploadedDocIds));
            @endphp
            @if($missingDocs->isNotEmpty())
            <div class="px-5 py-3 bg-red-50 border-t border-red-100">
                <p class="text-xs font-semibold text-red-700 mb-1">Pièces obligatoires manquantes :</p>
                <ul class="space-y-0.5">
                    @foreach($missingDocs as $missing)
                    <li class="text-xs text-red-600">• {{ $missing->title_fr }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @endif
        </div>
        @endif

        {{-- Observation admin --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-5 py-3">
                <h3 class="text-white font-semibold text-sm">Observation de l'administrateur</h3>
            </div>
            <form method="POST" action="{{ route('admin.applications.observation', $application) }}" class="p-5">
                @csrf @method('PATCH')
                <textarea name="observation" rows="3" placeholder="Ajouter une observation..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none">{{ $application->observation }}</textarea>
                <div class="mt-2 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition-all">
                        Enregistrer l'observation
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Right sidebar --}}
    <div class="space-y-5">

        {{-- Status --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100 flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full
                    {{ match($application->status) {
                        'Validé'    => 'bg-green-100 text-green-700',
                        'Rejeté'    => 'bg-red-100 text-red-700',
                        'Incomplet' => 'bg-orange-100 text-orange-700',
                        default     => 'bg-amber-100 text-amber-700'
                    } }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ match($application->status) {
                        'Validé'    => 'bg-green-500',
                        'Rejeté'    => 'bg-red-500',
                        'Incomplet' => 'bg-orange-500',
                        default     => 'bg-amber-500'
                    } }}"></span>
                    {{ $application->status }}
                </span>
                <span class="text-xs text-gray-500">Statut actuel</span>
            </div>
            <div class="p-4 space-y-2">
                @foreach(['Validé' => ['bg-green-500', 'hover:bg-green-600', 'Accepter'], 'Rejeté' => ['bg-red-500', 'hover:bg-red-600', 'Refuser'], 'Incomplet' => ['bg-orange-400', 'hover:bg-orange-500', 'Marquer incomplet'], 'En attente' => ['border border-amber-300 bg-amber-50', 'hover:bg-amber-100', 'Remettre en attente']] as $status => $cfg)
                @if($application->status !== $status)
                <form method="POST" action="{{ route('admin.applications.status', $application) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ $status }}">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 {{ $cfg[0] }} {{ $cfg[1] }} {{ str_contains($cfg[0], 'border') ? 'text-amber-700' : 'text-white' }} text-sm font-semibold rounded-lg transition-all">
                        {{ $cfg[2] }}
                    </button>
                </form>
                @endif
                @endforeach
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
                <div class="flex justify-between"><span class="text-gray-500">Pièces</span><span class="font-medium">{{ $application->uploadedDocuments->count() }} reçue(s)</span></div>
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
