@extends('layouts.app')

@php
    $isRtl = app()->getLocale() === 'ar';
    $applicationSettings = $settings ?? \App\Models\SiteSetting::all_settings();
    $applicationSiteName = $isRtl
        ? ($applicationSettings['nom_ar'] ?? ($applicationSettings['sigle'] ?? 'CQPM Nador'))
        : ($applicationSettings['nom_fr'] ?? ($applicationSettings['sigle'] ?? 'CQPM Nador'));
    $filieres        = $filieres ?? \App\Models\Filiere::where('is_active', true)->orderBy('position')->get();
    $selectedFiliere = $selectedFiliere ?? null;
@endphp

@section('title', $isRtl ? 'استمارة الترشيح - CQPM Nador' : 'Formulaire de Candidature - CQPM Nador')

@section('content')

{{-- Page header --}}
<div class="bg-navy py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-white/50 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ $isRtl ? 'الرئيسية' : 'Accueil' }}</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80">{{ $isRtl ? 'التسجيل' : 'Formulaire de candidature' }}</span>
        </nav>
        <h1 class="text-2xl md:text-3xl font-bold text-white">
            {{ $isRtl ? 'استمارة الترشيح / Formulaire de Candidature' : 'Formulaire de Candidature / استمارة الترشيح' }}
        </h1>
        <p class="text-white/60 text-sm mt-2">{{ $isRtl ? 'يرجى ملء جميع الخانات بعناية. جميع الحقول المشار إليها بـ * إلزامية.' : 'Remplissez soigneusement tous les champs. Les champs marqués * sont obligatoires.' }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <div>
                <h3 class="font-semibold text-red-800 text-sm mb-1">{{ $isRtl ? 'يرجى تصحيح الأخطاء التالية:' : 'Veuillez corriger les erreurs suivantes :' }}</h3>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-xs text-red-600">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('candidature.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- Section 1: Filière --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">1</span>
                    {{ $isRtl ? 'اختيار المسلك والتكوين' : 'Choix de la filière et du type de formation' }}
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Filière --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        {{ $isRtl ? 'المسلك' : 'Filière' }} <span class="text-red-500">*</span>
                    </label>
                    <select name="filiere_id" id="filiere_select"
                            class="w-full border @error('filiere_id') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- {{ $isRtl ? 'اختر مسلكاً' : 'Sélectionner une filière' }} --</option>
                        @foreach($filieres as $f)
                        <option value="{{ $f->id }}"
                                data-slug="{{ $f->slug }}"
                                data-conditions-fr="{{ e($f->conditions_acces_fr) }}"
                                data-conditions-ar="{{ e($f->conditions_acces_ar) }}"
                                {{ (old('filiere_id', $selectedFiliere?->id) == $f->id) ? 'selected' : '' }}>
                            {{ $isRtl ? ($f->title_ar ?: $f->title_fr) : $f->title_fr }}
                        </option>
                        @endforeach
                    </select>
                    @error('filiere_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Type de formation --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        {{ $isRtl ? 'نوع التكوين' : 'Type de formation' }} <span class="text-red-500">*</span>
                    </label>
                    <select name="type_formation"
                            class="w-full border @error('type_formation') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- {{ $isRtl ? 'اختر' : 'Sélectionner' }} --</option>
                        @foreach(['Formation Initiale','Formation Continue','Perfectionnement','Reconversion Professionnelle','Stage de Mise à Niveau'] as $opt)
                        <option value="{{ $opt }}" {{ old('type_formation') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('type_formation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Section de candidature --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        {{ $isRtl ? 'قسم الترشيح' : 'Section de candidature' }} <span class="text-red-500">*</span>
                    </label>
                    <select name="section_candidature"
                            class="w-full border @error('section_candidature') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- {{ $isRtl ? 'اختر' : 'Sélectionner' }} --</option>
                        @foreach(['Navigation Maritime','Machine Maritime','Pêche Maritime','Sécurité Maritime','Aquaculture & Mariculture','Transformation des Produits de la Mer'] as $opt)
                        <option value="{{ $opt }}" {{ old('section_candidature') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('section_candidature')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Niveau scolaire --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
                        {{ $isRtl ? 'المستوى الدراسي' : 'Niveau scolaire' }} <span class="text-red-500">*</span>
                    </label>
                    <select name="niveau_scolaire"
                            class="w-full border @error('niveau_scolaire') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- {{ $isRtl ? 'اختر' : 'Sélectionner' }} --</option>
                        @foreach(['3ème Collège','2ème Baccalauréat','Baccalauréat','Bac+2 (DUT/BTS)','Licence (Bac+3)','Master (Bac+5)','Autre'] as $opt)
                        <option value="{{ $opt }}" {{ old('niveau_scolaire') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('niveau_scolaire')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- Conditions d'accès (dynamic) --}}
        <div id="conditions-box" class="{{ ($selectedFiliere && ($isRtl ? $selectedFiliere->conditions_acces_ar : $selectedFiliere->conditions_acces_fr)) ? '' : 'hidden' }} bg-amber-50 border border-amber-200 rounded-xl p-5">
            <h3 class="font-semibold text-amber-800 text-sm mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                {{ $isRtl ? 'شروط الالتحاق' : 'Conditions d\'accès à cette filière' }}
            </h3>
            <div id="conditions-content" class="text-sm text-amber-700 whitespace-pre-line leading-relaxed">
                {{ $selectedFiliere ? ($isRtl ? $selectedFiliere->conditions_acces_ar : $selectedFiliere->conditions_acces_fr) : '' }}
            </div>
        </div>

        {{-- Section 2: Identité --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">2</span>
                    {{ $isRtl ? 'هوية المترشح' : 'Identité du candidat' }}
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'الاسم العائلي' : 'Nom' }} <span class="text-red-500">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="{{ $isRtl ? 'مثال: بنعلي' : 'Ex: BENALI' }}"
                           class="w-full border @error('nom') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all uppercase">
                    @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'الاسم الشخصي' : 'Prénom' }} <span class="text-red-500">*</span></label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="{{ $isRtl ? 'مثال: محمد' : 'Ex: Mohammed' }}"
                           class="w-full border @error('prenom') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('prenom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'الجنس' : 'Genre' }} <span class="text-red-500">*</span></label>
                    <div class="flex gap-4 mt-3">
                        @foreach(['Masculin' => ($isRtl ? 'ذكر' : 'Masculin'), 'Féminin' => ($isRtl ? 'أنثى' : 'Féminin')] as $val => $label)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="genre" value="{{ $val }}" {{ old('genre') === $val ? 'checked' : '' }} class="w-4 h-4 text-navy">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('genre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'تاريخ الميلاد' : 'Date de naissance' }} <span class="text-red-500">*</span></label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                           class="w-full border @error('date_naissance') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('date_naissance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'مكان الميلاد' : 'Lieu de naissance' }} <span class="text-red-500">*</span></label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" placeholder="{{ $isRtl ? 'مثال: الناظور' : 'Ex: Nador' }}"
                           class="w-full border @error('lieu_naissance') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('lieu_naissance')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'رقم البطاقة الوطنية' : 'Numéro de CIN' }} <span class="text-red-500">*</span></label>
                    <input type="text" name="cin" value="{{ old('cin') }}" placeholder="{{ $isRtl ? 'مثال: AB123456' : 'Ex: AB123456' }}"
                           class="w-full border @error('cin') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all uppercase">
                    @error('cin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- Section 3: Coordonnées --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">3</span>
                    {{ $isRtl ? 'معلومات الاتصال والسكن' : 'Coordonnées et localisation' }}
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'البريد الإلكتروني' : 'Adresse e-mail' }} <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@email.com"
                           class="w-full border @error('email') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'رقم الهاتف' : 'Téléphone' }} <span class="text-red-500">*</span></label>
                    <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="Ex: 0600000000"
                           class="w-full border @error('telephone') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('telephone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'الجهة' : 'Région' }} <span class="text-red-500">*</span></label>
                    <select name="region" class="w-full border @error('region') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                        <option value="">-- {{ $isRtl ? 'اختر' : 'Sélectionner' }} --</option>
                        @foreach(['Tanger-Tétouan-Al Hoceïma','Oriental','Fès-Meknès','Rabat-Salé-Kénitra','Béni Mellal-Khénifra','Casablanca-Settat','Marrakech-Safi','Drâa-Tafilalet','Souss-Massa','Guelmim-Oued Noun','Laâyoune-Sakia El Hamra','Dakhla-Oued Ed-Dahab'] as $opt)
                        <option value="{{ $opt }}" {{ old('region') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('region')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'المدينة' : 'Ville' }} <span class="text-red-500">*</span></label>
                    <input type="text" name="ville" value="{{ old('ville') }}" placeholder="{{ $isRtl ? 'الناظور' : 'Ex: Nador' }}"
                           class="w-full border @error('ville') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('ville')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">{{ $isRtl ? 'العنوان الكامل' : 'Adresse postale complète' }} <span class="text-red-500">*</span></label>
                    <textarea name="adresse_postale" rows="3" placeholder="{{ $isRtl ? 'الشارع، الحي، الرمز البريدي...' : 'N° rue, quartier, code postal...' }}"
                              class="w-full border @error('adresse_postale') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all resize-none">{{ old('adresse_postale') }}</textarea>
                    @error('adresse_postale')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- Section 4: Pièces justificatives --}}
        <div id="documents-section" class="{{ $selectedFiliere && $selectedFiliere->requiredDocuments->isNotEmpty() ? '' : 'hidden' }} bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">4</span>
                    {{ $isRtl ? 'الوثائق المطلوبة' : 'Pièces justificatives' }}
                    <span class="text-white/50 text-xs font-normal">(PDF, JPG, PNG — max 5 Mo)</span>
                </h2>
            </div>
            <div id="documents-list" class="p-6 space-y-4">
                @if($selectedFiliere)
                @foreach($selectedFiliere->requiredDocuments as $doc)
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ $isRtl ? ($doc->title_ar ?: $doc->title_fr) : $doc->title_fr }}
                        @if($doc->is_required)<span class="text-red-500 ml-1">*</span>@endif
                    </label>
                    <input type="file" name="document_{{ $doc->id }}" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-light cursor-pointer">
                    @error("document_{$doc->id}")<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                @endforeach
                @endif
            </div>
        </div>

        {{-- Section 5: Déclaration --}}
        <div class="bg-white rounded-xl border @error('declaration_honneur') border-red-300 @else border-gray-200 @enderror overflow-hidden">
            <div class="bg-navy px-6 py-4">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                    <span class="w-6 h-6 bg-gold rounded-full text-navy text-xs font-bold flex items-center justify-center">5</span>
                    {{ $isRtl ? 'التصريح بالشرف' : 'Déclaration sur l\'honneur' }}
                </h2>
            </div>
            <div class="p-6">
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-5">
                    <p class="text-amber-800 text-sm leading-relaxed">
                        {{ $isRtl
                            ? 'أي تصريح كاذب سيؤدي إلى إلغاء الترشيح فوراً وقد يُعرّض صاحبه للمتابعة القانونية.'
                            : 'Toute fausse déclaration entraînera l\'annulation immédiate de la candidature et pourra faire l\'objet de poursuites.' }}
                    </p>
                </div>
                <label class="flex items-start gap-4 cursor-pointer group">
                    <input type="checkbox" name="declaration_honneur" value="1" {{ old('declaration_honneur') ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-navy border-gray-300 rounded focus:ring-navy shrink-0">
                    <span class="text-sm text-gray-700 leading-relaxed">
                        <strong class="text-navy">{{ $isRtl ? 'أصرح بشرفي' : 'Je déclare sur l\'honneur' }}</strong>
                        {{ $isRtl
                            ? ' أن المعلومات الواردة في هذا الطلب صحيحة وكاملة. وأتعهد بتقديم الوثائق المطلوبة والالتزام بالنظام الداخلي للمركز.'
                            : ' que les informations indiquées dans ce formulaire sont authentiques, complètes et exactes. Je m\'engage à fournir les pièces justificatives et à respecter le règlement intérieur du ' . $applicationSiteName . '.' }}
                    </span>
                </label>
                @error('declaration_honneur')<p class="text-red-500 text-xs mt-2 ml-9">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50 rounded-xl border border-gray-200 p-6">
            <p class="text-xs text-gray-500 text-center sm:text-left">
                <svg class="w-4 h-4 inline mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                {{ $isRtl ? 'بياناتك تُعالج بسرية تامة وفق الأنظمة المعمول بها.' : 'Vos données sont traitées de manière confidentielle, conformément à la réglementation en vigueur.' }}
            </p>
            <div class="flex gap-3">
                <a href="{{ route('home') }}" class="px-6 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 font-medium rounded-lg text-sm transition-all">
                    {{ $isRtl ? 'إلغاء' : 'Annuler' }}
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-2.5 bg-navy hover:bg-navy-light text-white font-semibold rounded-lg text-sm transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    {{ $isRtl ? 'إرسال الترشيح' : 'Soumettre ma candidature' }}
                </button>
            </div>
        </div>

    </form>
</div>

<script>
(function () {
    const select       = document.getElementById('filiere_select');
    const condBox      = document.getElementById('conditions-box');
    const condContent  = document.getElementById('conditions-content');
    const docsSection  = document.getElementById('documents-section');
    const docsList     = document.getElementById('documents-list');
    const isRtl        = document.documentElement.dir === 'rtl';

    // Filières data passed from PHP via data-attributes on options
    // Dynamic document list fetched via fetch when filiere changes
    select?.addEventListener('change', async function () {
        const opt  = this.options[this.selectedIndex];
        const id   = this.value;

        // Conditions
        const cond = isRtl ? opt.dataset.conditionsAr : opt.dataset.conditionsFr;
        if (cond && cond.trim()) {
            condContent.textContent = cond;
            condBox.classList.remove('hidden');
        } else {
            condBox.classList.add('hidden');
        }

        // Documents
        if (!id) {
            docsSection.classList.add('hidden');
            return;
        }

        try {
            const res  = await fetch(`/api/filieres/${id}/documents`);
            const data = await res.json();
            if (data.length === 0) {
                docsSection.classList.add('hidden');
                return;
            }
            docsList.innerHTML = data.map(doc => `
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        ${isRtl ? (doc.title_ar || doc.title_fr) : doc.title_fr}
                        ${doc.is_required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                    </label>
                    <input type="file" name="document_${doc.id}" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-light cursor-pointer">
                </div>
            `).join('');
            docsSection.classList.remove('hidden');
        } catch (e) {
            docsSection.classList.add('hidden');
        }
    });
})();
</script>

@endsection
