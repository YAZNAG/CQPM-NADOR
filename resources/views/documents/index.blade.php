@extends('layouts.app')

@php $isRtl = app()->getLocale() === 'ar'; @endphp

@section('title', $isRtl ? 'الإعلانات والنتائج - CQPM Nador' : 'Avis & Résultats - CQPM Nador')

@section('content')

<div class="bg-navy py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $isRtl ? 'الإعلانات والنتائج' : 'Avis & Résultats' }}</h1>
        <p class="text-white/60 text-sm mt-2">{{ $isRtl ? 'تحميل الوثائق والاستمارات الرسمية' : 'Téléchargez les documents et formulaires officiels' }}</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-10">
    @if($documents->isEmpty())
    <div class="text-center py-16 text-gray-400">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        {{ $isRtl ? 'لا توجد وثائق متاحة حالياً.' : 'Aucun document disponible pour le moment.' }}
    </div>
    @else
    <div class="space-y-3">
        @foreach($documents as $doc)
        <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 text-sm truncate">{{ $doc->title }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $doc->created_at->format('d/m/Y') }}</p>
            </div>
            <a href="{{ \Illuminate\Support\Facades\Storage::url($doc->file_path) }}" target="_blank"
               class="shrink-0 inline-flex items-center gap-1.5 px-3 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                {{ $isRtl ? 'تحميل' : 'Télécharger' }}
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection
