@extends('layouts.app')

@section('title', 'Candidature soumise')

@section('content')

<div class="min-h-[70vh] flex items-center justify-center py-16 px-4">
    <div class="max-w-lg w-full text-center">

        {{-- Success icon --}}
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-navy mb-3">Candidature soumise avec succès !</h1>

        <p class="text-gray-600 leading-relaxed mb-6 text-sm">
            Votre dossier de candidature a bien été enregistré. Notre équipe étudiera votre demande
            et vous contactera dans les meilleurs délais par e-mail ou téléphone.
        </p>

        <div class="bg-sea-light border border-sea/20 rounded-xl p-5 mb-8 text-left">
            <h3 class="font-semibold text-navy text-sm mb-3">Prochaines étapes :</h3>
            <ol class="space-y-2">
                @foreach([
                    'Votre dossier est en cours d\'examen par notre service des admissions.',
                    'Vous recevrez une confirmation par e-mail sous 5 à 10 jours ouvrables.',
                    'Si votre dossier est retenu, vous serez convoqué(e) pour un entretien ou un test.',
                    'Préparez vos pièces justificatives (diplômes, CIN, photos d\'identité).',
                ] as $i => $step)
                <li class="flex items-start gap-3 text-sm text-gray-700">
                    <span class="w-5 h-5 bg-navy text-white rounded-full flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">{{ $i + 1 }}</span>
                    {{ $step }}
                </li>
                @endforeach
            </ol>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-navy hover:bg-navy-light text-white font-semibold rounded-lg text-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Retour à l'accueil
            </a>
            <a href="{{ route('home') }}#documents"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg text-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Voir les documents
            </a>
        </div>

    </div>
</div>

@endsection
