@extends('layouts.app')
@php $isRtl = app()->getLocale() === 'ar'; @endphp
@section('title', $isRtl ? 'جولة افتراضية - CQPM Nador' : 'Visite Virtuelle - CQPM Nador')
@section('content')
<div class="bg-navy py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold text-white">{{ $isRtl ? 'جولة افتراضية' : 'Visite Virtuelle' }}</h1>
    </div>
</div>
<div class="max-w-4xl mx-auto px-4 py-16 text-center">
    <p class="text-gray-400">{{ $isRtl ? 'الجولة الافتراضية قادمة قريباً.' : 'La visite virtuelle sera disponible prochainement.' }}</p>
    <a href="{{ route('gallery.index') }}" class="mt-4 inline-block text-navy underline text-sm">
        {{ $isRtl ? 'عودة للمعرض' : 'Retour à la galerie' }}
    </a>
</div>
@endsection
