@extends('layouts.app')

@php
    $isRtl = app()->getLocale() === 'ar';
    $locale = app()->getLocale();
@endphp

@section('title', $isRtl ? 'التكوينات - CQPM Nador' : 'Formations - CQPM Nador')

@section('content')

{{-- Hero --}}
<div class="bg-navy py-12">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="flex items-center gap-2 text-xs text-white/50 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">{{ $isRtl ? 'الرئيسية' : 'Accueil' }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80">{{ $isRtl ? 'التكوينات' : 'Formations' }}</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $isRtl ? 'مسالك التكوين' : 'Filières de Formation' }}</h1>
        <p class="text-white/60 mt-3 max-w-2xl">{{ $isRtl ? 'اكتشف مسالك التكوين المهني البحري المعتمدة من طرف قطاع الصيد البحري' : 'Découvrez les filières de formation professionnelle maritime agréées par le Département de la Pêche Maritime' }}</p>
    </div>
</div>

{{-- Types de formation --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['url' => route('formations.initiale'),      'fr' => 'Formation Initiale',      'ar' => 'التكوين الأساسي',    'icon' => '🎓'],
                ['url' => route('formations.qualification'),  'fr' => 'Qualification',           'ar' => 'التأهيل',            'icon' => '📋'],
                ['url' => route('formations.specialisation'), 'fr' => 'Spécialisation',          'ar' => 'التخصص',             'icon' => '🔬'],
                ['url' => route('formations.continue'),       'fr' => 'Formation Continue',      'ar' => 'التكوين المستمر',    'icon' => '🔄'],
            ] as $type)
            <a href="{{ $type['url'] }}"
               class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-200 hover:border-navy hover:bg-navy/5 transition-all group text-center">
                <span class="text-2xl">{{ $type['icon'] }}</span>
                <span class="text-sm font-semibold text-gray-700 group-hover:text-navy">{{ $isRtl ? $type['ar'] : $type['fr'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- Filières --}}
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-navy">{{ $isRtl ? 'جميع المسالك' : 'Toutes les filières' }}</h2>
        <p class="text-gray-500 mt-2">{{ $isRtl ? 'اضغط على مسلك للاطلاع على التفاصيل والتسجيل' : 'Cliquez sur une filière pour voir les détails et vous inscrire' }}</p>
    </div>

    @if($filieres->isEmpty())
    <div class="text-center text-gray-400 py-16">{{ $isRtl ? 'لا توجد مسالك متاحة حالياً.' : 'Aucune filière disponible pour le moment.' }}</div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($filieres as $filiere)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col">
            {{-- Image --}}
            <div class="relative h-44 bg-gradient-to-br from-navy to-sea overflow-hidden">
                @if($filiere->image_path)
                <img src="{{ $filiere->image_url }}" alt="{{ $filiere->localized_title }}" class="w-full h-full object-cover opacity-80">
                @else
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1C9.26 23.65 10.63 24 12 24s2.74-.35 4-1c1.26.65 2.63 1 4 1h2v-2h-2z"/></svg>
                </div>
                @endif
                <div class="absolute top-3 {{ $isRtl ? 'left-3' : 'right-3' }}">
                    <span class="inline-block bg-gold text-navy text-xs font-bold px-2 py-1 rounded">{{ $filiere->badge }}</span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-5 flex-1 flex flex-col">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-xs text-gray-500">{{ $filiere->duration }}</span>
                </div>
                <h3 class="font-bold text-navy text-lg leading-snug mb-2">{{ $filiere->localized_title }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed flex-1 line-clamp-3">{{ $filiere->localized_description }}</p>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('formations.filiere.show', $filiere->slug) }}"
                       class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded-lg transition-all">
                        {{ $isRtl ? 'التفاصيل' : 'Voir détails' }}
                    </a>
                    <a href="{{ route('candidature.form', ['filiere' => $filiere->slug]) }}"
                       class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 bg-gold hover:bg-yellow-500 text-navy text-xs font-bold rounded-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        {{ $isRtl ? 'تسجيل' : 'Inscription' }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- CTA --}}
<div class="bg-navy py-12">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold text-white mb-3">{{ $isRtl ? 'هل أنت مستعد للتسجيل؟' : 'Prêt à vous inscrire ?' }}</h3>
        <p class="text-white/60 mb-6">{{ $isRtl ? 'التسجيلات مفتوحة. أودع ملفك الآن.' : 'Les inscriptions sont ouvertes. Déposez votre dossier maintenant.' }}</p>
        <a href="{{ route('candidature.form') }}"
           class="inline-flex items-center gap-2 px-8 py-3 bg-gold hover:bg-yellow-500 text-navy font-bold rounded-lg text-sm transition-all">
            {{ $isRtl ? 'التسجيل في المباراة' : 'S\'inscrire au concours' }}
        </a>
    </div>
</div>

@endsection
