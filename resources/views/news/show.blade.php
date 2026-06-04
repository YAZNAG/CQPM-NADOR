@extends('layouts.app')
@section('title', $article->title)

@section('content')

{{-- ── Page Header ──────────────────────────────────────────────────────────── --}}
<div class="bg-navy" style="background: linear-gradient(135deg, #061E30 0%, #0B3C5D 100%);">
    <div class="max-w-screen-xl mx-auto px-4 py-10 md:py-14">
        <div class="max-w-3xl">
            <a href="{{ route('home') }}#actualites"
               class="inline-flex items-center gap-1.5 text-white/50 hover:text-gold text-xs font-medium mb-5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Actualités & Événements
            </a>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white leading-tight mb-4">
                {{ $article->title }}
            </h1>
            <div class="flex items-center gap-4 text-white/50 text-xs">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $article->created_at->translatedFormat('d F Y') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2m-4-3h4"/>
                    </svg>
                    CQPM Nador
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ── Article Body ──────────────────────────────────────────────────────────── --}}
<section class="bg-gray-50 py-10 md:py-14 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- ── Main content (2/3) ──────────────────────────────────────────── --}}
            <div class="lg:col-span-2">
                <article class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                    {{-- Image header (if attachment is an image) --}}
                    @if($article->file_path && $article->isImage())
                    <div class="w-full aspect-video overflow-hidden bg-gray-100">
                        <img src="{{ $article->file_url }}"
                             alt="{{ $article->title }}"
                             class="w-full h-full object-cover">
                    </div>
                    @endif

                    {{-- Text content --}}
                    <div class="p-6 md:p-8">
                        <div class="text-gray-700 text-sm md:text-base leading-[1.85] whitespace-pre-line">
                            {!! nl2br(e($article->content)) !!}
                        </div>
                    </div>

                    {{-- PDF attachment (if file is PDF) --}}
                    @if($article->file_path && $article->isPdf())
                    <div class="mx-6 md:mx-8 mb-8 p-4 bg-gray-50 border border-gray-200 rounded-xl flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2,0,0,0,4,4V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V8ZM18,20H6V4h7V9h5ZM11,14H9V16H11Zm4-4H9v2H15Zm0,4H13V16H15Z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-700 mb-0.5">Document joint</p>
                            <p class="text-xs text-gray-400 truncate">{{ basename($article->file_path) }}</p>
                        </div>
                        <a href="{{ $article->file_url }}" target="_blank" download
                           class="shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-navy hover:bg-gold hover:text-navy text-white text-xs font-bold rounded-lg transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Télécharger la pièce jointe
                        </a>
                    </div>
                    @endif

                </article>
            </div>

            {{-- ── Sidebar (1/3) ──────────────────────────────────────────────── --}}
            <div class="space-y-5">

                {{-- Info card --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1 h-5 bg-gold rounded-full"></div>
                        <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Informations</h3>
                    </div>
                    <dl class="space-y-3 text-xs">
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-400 font-medium">Publié le</dt>
                            <dd class="text-gray-700 font-semibold">{{ $article->created_at->format('d/m/Y') }}</dd>
                        </div>
                        @if($article->updated_at->ne($article->created_at))
                        <div class="flex justify-between gap-3 pt-2 border-t border-gray-100">
                            <dt class="text-gray-400 font-medium">Mis à jour</dt>
                            <dd class="text-gray-700">{{ $article->updated_at->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                        <div class="flex justify-between gap-3 pt-2 border-t border-gray-100">
                            <dt class="text-gray-400 font-medium">Source</dt>
                            <dd class="text-gray-700 font-semibold">CQPM Nador</dd>
                        </div>
                    </dl>
                </div>

                {{-- Back button --}}
                <a href="{{ route('home') }}#actualites"
                   class="flex items-center justify-center gap-2 w-full py-3 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Toutes les actualités
                </a>

                {{-- CTA --}}
                <div class="bg-navy rounded-2xl p-5 text-center">
                    <div class="w-10 h-10 bg-gold/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <p class="text-white text-xs font-semibold mb-1">Intéressé par nos formations ?</p>
                    <p class="text-white/50 text-xs mb-4">Les inscriptions 2024/2025 sont ouvertes.</p>
                    <a href="{{ route('candidature.form') }}"
                       class="inline-flex items-center justify-center w-full gap-2 py-2.5 bg-gold hover:bg-gold-dark text-navy text-xs font-bold rounded-lg transition-all">
                        S'inscrire au concours
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
