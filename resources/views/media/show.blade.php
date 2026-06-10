@extends('layouts.app')

@section('title', $seo['title'])

@section('content')
@php
    $isRtl = app()->getLocale() === 'ar';
    $mediaSettings = $settings ?? \App\Models\SiteSetting::all_settings();
    $siteSigle = $mediaSettings['sigle'] ?? 'CQPM Nador';
@endphp

<section class="bg-navy text-white">
    <div class="max-w-screen-xl mx-auto px-4 py-12 md:py-16">
        <a href="{{ route('media.index') }}" class="inline-flex text-white/55 hover:text-gold text-sm mb-5">{{ $isRtl ? 'كل الوسائط' : 'Toute la galerie' }}</a>
        <h1 class="text-3xl md:text-4xl font-extrabold leading-tight max-w-4xl">{{ $mediaItem->title }}</h1>
        @if($mediaItem->category)<p class="text-gold text-sm mt-3">{{ $mediaItem->category }}</p>@endif
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4">
        <article class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm max-w-5xl mx-auto">
            <div class="bg-navy flex items-center justify-center">
                @if($mediaItem->media_type === 'video' && $mediaItem->video_url)
                    <a href="{{ $mediaItem->video_url }}" target="_blank" rel="noopener noreferrer" class="block w-full aspect-video flex items-center justify-center text-gold font-bold text-xl hover:bg-white/5 transition-colors">
                        {{ $isRtl ? 'فتح الفيديو' : 'Ouvrir la vidéo' }}
                    </a>
                @elseif($mediaItem->image_url)
                    <img src="{{ $mediaItem->image_url }}" alt="{{ $mediaItem->alt }}" class="w-full max-h-[680px] object-contain">
                @else
                    <div class="aspect-video w-full flex items-center justify-center text-gold font-bold">{{ $siteSigle }}</div>
                @endif
            </div>
            @if($mediaItem->description)
                <div class="p-6 md:p-8 text-gray-700 leading-8 whitespace-pre-line">{{ $mediaItem->description }}</div>
            @endif
        </article>
    </div>
</section>
@endsection
