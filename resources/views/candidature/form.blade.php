@extends('layouts.app')

@section('title', 'Formulaire de Candidature')

@section('content')

{{-- ── Page header ─────────────────────────────────────────────────────────── --}}
<div class="bg-navy py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-white/50 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80">Formulaire de candidature</span>
        </nav>
        <h1 class="text-2xl md:text-3xl font-bold text-white">Formulaire de Candidature</h1>
        <p class="text-white/60 text-sm mt-2">Remplissez soigneusement tous les champs. Tous les champs sont obligatoires.</p>
    </div>
</div>

{{-- ── Form ─────────────────────────────────────────────────────────────────── --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Validation errors summary --}}
    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-semibold text-red-800 text-sm mb-1">Veuillez corriger les erreurs suivantes :</h3>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-xs text-red-600">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('candidature.store') }}" class="space-y-8">
        @csrf

        {{-- ── Section 1: Type & Section ────────────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">1</span>
                    Informations de candidature
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- Type de formation --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Type de formation <span class="text-red-500">*</span>
                    </label>
                    <select name="type_formation"
                            class="w-full border @error('type_formation') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- Sélectionner --</option>
                        @foreach(['Formation Initiale','Formation Continue','Perfectionnement','Reconversion Professionnelle','Stage de Mise à Niveau'] as $opt)
                        <option value="{{ $opt }}" {{ old('type_formation') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('type_formation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Section de candidature --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Section de candidature <span class="text-red-500">*</span>
                    </label>
                    <select name="section_candidature"
                            class="w-full border @error('section_candidature') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- Sélectionner --</option>
                        @foreach(['Navigation Maritime','Machine Maritime','Pêche Maritime','Sécurité Maritime','Aquaculture & Mariculture','Transformation des Produits de la Mer'] as $opt)
                        <option value="{{ $opt }}" {{ old('section_candidature') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('section_candidature')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Niveau scolaire --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Niveau scolaire <span class="text-red-500">*</span>
                    </label>
                    <select name="niveau_scolaire"
                            class="w-full border @error('niveau_scolaire') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- Sélectionner --</option>
                        @foreach(['3ème Collège','2ème Baccalauréat','Baccalauréat','Bac+2 (DUT/BTS)','Licence (Bac+3)','Master (Bac+5)','Autre'] as $opt)
                        <option value="{{ $opt }}" {{ old('niveau_scolaire') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('niveau_scolaire')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- ── Section 2: Identité ───────────────────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">2</span>
                    Identité du candidat
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- Nom --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: BENALI"
                           class="w-full border @error('nom') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all uppercase">
                    @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Prénom --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Ex: Mohammed"
                           class="w-full border @error('prenom') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('prenom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Genre --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Genre <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4 mt-3">
                        @foreach(['Masculin','Féminin'] as $g)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="genre" value="{{ $g }}" {{ old('genre') === $g ? 'checked' : '' }}
                                   class="w-4 h-4 text-navy border-gray-300 focus:ring-navy">
                            <span class="text-sm text-gray-700">{{ $g }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('genre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Date de naissance --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Date de naissance <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                           class="w-full border @error('date_naissance') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('date_naissance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Lieu de naissance --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Lieu de naissance <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" placeholder="Ex: Nador"
                           class="w-full border @error('lieu_naissance') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('lieu_naissance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Empty cell for layout alignment --}}
                <div class="hidden md:block"></div>

            </div>
        </div>

        {{-- ── Section 3: Coordonnées ────────────────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">3</span>
                    Coordonnées et localisation
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Adresse e-mail <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@email.com"
                           class="w-full border @error('email') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Téléphone --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Téléphone <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="Ex: 0600000000"
                           class="w-full border @error('telephone') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('telephone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Région --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Région <span class="text-red-500">*</span>
                    </label>
                    <select name="region"
                            class="w-full border @error('region') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- Sélectionner --</option>
                        @foreach([
                            'Tanger-Tétouan-Al Hoceïma',
                            'Oriental',
                            'Fès-Meknès',
                            'Rabat-Salé-Kénitra',
                            'Béni Mellal-Khénifra',
                            'Casablanca-Settat',
                            'Marrakech-Safi',
                            'Drâa-Tafilalet',
                            'Souss-Massa',
                            'Guelmim-Oued Noun',
                            'Laâyoune-Sakia El Hamra',
                            'Dakhla-Oued Ed-Dahab',
                        ] as $opt)
                        <option value="{{ $opt }}" {{ old('region') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('region')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Ville --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Ville <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="ville" value="{{ old('ville') }}" placeholder="Ex: Nador"
                           class="w-full border @error('ville') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('ville')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Adresse postale --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        Adresse postale complète <span class="text-red-500">*</span>
                    </label>
                    <textarea name="adresse_postale" rows="3" placeholder="N° rue, quartier, code postal..."
                              class="w-full border @error('adresse_postale') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all resize-none">{{ old('adresse_postale') }}</textarea>
                    @error('adresse_postale')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- ── Déclaration sur l'honneur ─────────────────────────────────────── --}}
        <div class="bg-white rounded-xl border @error('declaration_honneur') border-red-300 @else border-gray-200 @enderror overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">4</span>
                    Déclaration sur l'honneur
                </h2>
            </div>
            <div class="p-6">
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-5">
                    <p class="text-amber-800 text-sm leading-relaxed">
                        <svg class="w-4 h-4 inline mr-1 mb-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Toute fausse déclaration entraînera l'annulation immédiate de la candidature et pourra faire l'objet de poursuites.
                    </p>
                </div>

                <label class="flex items-start gap-4 cursor-pointer group">
                    <input type="checkbox" name="declaration_honneur" value="1"
                           {{ old('declaration_honneur') ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-navy border-gray-300 rounded focus:ring-navy shrink-0">
                    <span class="text-sm text-gray-700 leading-relaxed group-hover:text-gray-900 transition-colors">
                        <strong class="text-navy">Je déclare sur l'honneur</strong> que les informations indiquées dans ce formulaire de candidature sont,
                        à ma connaissance, <strong>authentiques, complètes et exactes</strong>.
                        Je m'engage à fournir les pièces justificatives correspondantes lors de mon inscription définitive
                        et à respecter le règlement intérieur du Centre de Qualification Professionnelle Maritime de Nador.
                    </span>
                </label>
                @error('declaration_honneur')
                <p class="text-red-500 text-xs mt-2 ml-9">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ── Submit ────────────────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50 rounded-xl border border-gray-200 p-6">
            <p class="text-xs text-gray-500 text-center sm:text-left">
                <svg class="w-4 h-4 inline mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Vos données sont traitées de manière confidentielle, conformément à la réglementation en vigueur.
            </p>
            <div class="flex gap-3">
                <a href="{{ route('home') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 font-medium rounded-lg text-sm transition-all">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-8 py-2.5 bg-navy hover:bg-navy-light text-white font-semibold rounded-lg text-sm transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Soumettre ma candidature
                </button>
            </div>
        </div>

    </form>
</div>

@endsection
