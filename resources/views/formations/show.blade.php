@extends('layouts.app')

@php
    $isRtl  = app()->getLocale() === 'ar';
    $locale = app()->getLocale();
    $title  = $isRtl ? ($filiere->title_ar ?: $filiere->title_fr) : ($filiere->title_fr ?: $filiere->title);
    $desc   = $isRtl ? ($filiere->description_ar ?: $filiere->description_fr) : ($filiere->description_fr ?: $filiere->description);
    $objectifs  = $isRtl ? $filiere->objectifs_ar  : $filiere->objectifs_fr;
    $programme  = $isRtl ? $filiere->programme_ar  : $filiere->programme_fr;
    $debouches  = $isRtl ? $filiere->debouches_ar  : $filiere->debouches_fr;
    $conditions = $isRtl ? $filiere->conditions_acces_ar : $filiere->conditions_acces_fr;
@endphp

@section('title', $title . ' - CQPM Nador')

@section('content')

{{-- Hero --}}
<div class="bg-navy py-10">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="flex items-center gap-2 text-xs text-white/50 mb-4 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-white">{{ $isRtl ? 'الرئيسية' : 'Accueil' }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('formations.index') }}" class="hover:text-white">{{ $isRtl ? 'التكوينات' : 'Formations' }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80">{{ $title }}</span>
        </nav>
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-block bg-gold text-navy text-xs font-bold px-3 py-1 rounded-full">{{ $filiere->badge }}</span>
                    @if($filiere->level)
                    <span class="inline-block bg-white/10 text-white text-xs px-3 py-1 rounded-full">{{ $filiere->level }}</span>
                    @endif
                    <span class="inline-flex items-center gap-1 text-white/60 text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $filiere->duration }}
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $title }}</h1>
                <p class="text-white/60 mt-2 max-w-2xl text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            <a href="{{ route('candidature.form', ['filiere' => $filiere->slug]) }}"
               class="shrink-0 inline-flex items-center gap-2 px-6 py-3 bg-gold hover:bg-yellow-500 text-navy font-bold rounded-lg text-sm transition-all shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                {{ $isRtl ? 'التسجيل / Inscription' : 'Inscription / التسجيل' }}
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main content --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Image --}}
            @if($filiere->image_path)
            <div class="rounded-2xl overflow-hidden shadow-md">
                <img src="{{ $filiere->image_url }}" alt="{{ $title }}" class="w-full h-64 object-cover">
            </div>
            @endif

            {{-- Objectifs --}}
            @if($objectifs)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="bg-navy px-6 py-4">
                    <h2 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        {{ $isRtl ? 'الأهداف' : 'Objectifs de la formation' }}
                    </h2>
                </div>
                <div class="p-6 prose prose-sm max-w-none text-gray-700 whitespace-pre-line">{{ $objectifs }}</div>
            </div>
            @endif

            {{-- Programme --}}
            @if($programme)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="bg-sea px-6 py-4">
                    <h2 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        {{ $isRtl ? 'البرنامج البيداغوجي' : 'Programme pédagogique' }}
                    </h2>
                </div>
                <div class="p-6 prose prose-sm max-w-none text-gray-700 whitespace-pre-line">{{ $programme }}</div>
            </div>
            @endif

            {{-- Débouchés --}}
            @if($debouches)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="bg-green-700 px-6 py-4">
                    <h2 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $isRtl ? 'فرص العمل' : 'Débouchés professionnels' }}
                    </h2>
                </div>
                <div class="p-6 prose prose-sm max-w-none text-gray-700 whitespace-pre-line">{{ $debouches }}</div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Conditions d'accès --}}
            @if($conditions)
            <div class="bg-white rounded-2xl border border-amber-200 overflow-hidden">
                <div class="bg-amber-500 px-5 py-4">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        {{ $isRtl ? 'شروط الالتحاق' : 'Conditions d\'accès' }}
                    </h3>
                </div>
                <div class="p-5 text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $conditions }}</div>
            </div>
            @endif

            {{-- Pièces obligatoires --}}
            @if($filiere->requiredDocuments->isNotEmpty())
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="bg-navy px-5 py-4">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        {{ $isRtl ? 'الوثائق المطلوبة' : 'Pièces à fournir' }}
                    </h3>
                </div>
                <ul class="divide-y divide-gray-100">
                    @foreach($filiere->requiredDocuments as $doc)
                    <li class="px-5 py-3 flex items-start gap-3">
                        <span class="mt-0.5 w-5 h-5 shrink-0 rounded-full {{ $doc->is_required ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center text-xs font-bold">
                            {{ $doc->is_required ? '!' : '○' }}
                        </span>
                        <div>
                            <span class="text-sm font-medium text-gray-800">{{ $isRtl ? ($doc->title_ar ?: $doc->title_fr) : $doc->title_fr }}</span>
                            @if($doc->is_required)
                            <span class="ml-1 text-xs text-red-500">*</span>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="px-5 py-3 bg-gray-50 text-xs text-gray-400">
                    <span class="text-red-500">*</span> {{ $isRtl ? 'وثيقة إلزامية' : 'Pièce obligatoire' }}
                </div>
            </div>
            @endif

            {{-- Bouton inscription --}}
            <div class="bg-gold/10 border-2 border-gold rounded-2xl p-5 text-center">
                <p class="text-navy font-semibold mb-3">{{ $isRtl ? 'سجل الآن في هذا المسلك' : 'Inscrivez-vous à cette filière' }}</p>
                <a href="{{ route('candidature.form', ['filiere' => $filiere->slug]) }}"
                   class="block w-full py-3 bg-gold hover:bg-yellow-500 text-navy font-bold rounded-lg text-sm transition-all shadow">
                    {{ $isRtl ? 'التسجيل / Inscription' : 'Inscription / التسجيل' }}
                </a>
            </div>

            {{-- Infos rapides --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h4 class="font-semibold text-gray-900 text-sm mb-4">{{ $isRtl ? 'معلومات سريعة' : 'Informations' }}</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ $isRtl ? 'المستوى' : 'Niveau' }}</span>
                        <span class="font-medium text-navy">{{ $filiere->badge }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ $isRtl ? 'المدة' : 'Durée' }}</span>
                        <span class="font-medium text-navy">{{ $filiere->duration }}</span>
                    </div>
                    @if($filiere->level)
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ $isRtl ? 'التأهيل' : 'Qualification' }}</span>
                        <span class="font-medium text-navy">{{ $filiere->level }}</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
