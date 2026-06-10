@extends('layouts.app')

@php
    $isRtl = app()->getLocale() === 'ar';
    $slugTitles = [
        'admission'              => ['fr' => 'Admission',              'ar' => 'التسجيل'],
        'admission-conditions'   => ['fr' => 'Conditions d\'accès',   'ar' => 'شروط الالتحاق'],
        'admission-pieces'       => ['fr' => 'Pièces à fournir',      'ar' => 'الوثائق المطلوبة'],
        'admission-calendrier'   => ['fr' => 'Calendrier',             'ar' => 'الروزنامة'],
        'admission-faq'          => ['fr' => 'FAQ',                    'ar' => 'الأسئلة الشائعة'],
        'contact'                => ['fr' => 'Contact',                'ar' => 'اتصل بنا'],
        'contact-localisation'   => ['fr' => 'Localisation',           'ar' => 'الموقع الجغرافي'],
        'formations-initiale'    => ['fr' => 'Formation Initiale',     'ar' => 'التكوين الأساسي'],
        'formations-qualification'=> ['fr' => 'Formation Qualification','ar' => 'تكوين التأهيل'],
        'formations-specialisation'=> ['fr' => 'Spécialisation',       'ar' => 'التخصص'],
        'formations-continue'    => ['fr' => 'Formation Continue',     'ar' => 'التكوين المستمر'],
    ];
    $t = $slugTitles[$slug] ?? ['fr' => ucfirst(str_replace('-', ' ', $slug)), 'ar' => ''];
    $pageTitle = $isRtl ? ($t['ar'] ?: $t['fr']) : $t['fr'];
@endphp

@section('title', $pageTitle . ' - CQPM Nador')

@section('content')

<div class="bg-navy py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $pageTitle }}</h1>
        <p class="text-white/50 text-xs mt-2">CQPM Nador</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-16 text-center">
    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <h2 class="text-xl font-semibold text-gray-600 mb-2">{{ $isRtl ? 'هذه الصفحة قيد التحديث' : 'Page en cours de mise à jour' }}</h2>
    <p class="text-gray-400 text-sm">{{ $isRtl ? 'سيتم نشر المحتوى قريباً. شكراً لصبركم.' : 'Le contenu sera publié prochainement. Merci de votre patience.' }}</p>
    <a href="{{ route('home') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-lg hover:bg-navy-light transition-all">
        {{ $isRtl ? 'العودة للرئيسية' : 'Retour à l\'accueil' }}
    </a>
</div>

@endsection
