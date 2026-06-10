@extends('layouts.app')

@section('title', $seo['title'])

@section('content')
@php $isRtl = app()->getLocale() === 'ar'; @endphp

<section class="bg-navy text-white">
    <div class="max-w-screen-xl mx-auto px-4 py-12 md:py-16">
        <a href="{{ route('events.index') }}" class="inline-flex text-white/55 hover:text-gold text-sm mb-5">{{ $isRtl ? 'كل الأنشطة' : 'Tous les événements' }}</a>
        <h1 class="text-3xl md:text-4xl font-extrabold leading-tight max-w-4xl">{{ $event->title }}</h1>
        <div class="mt-4 flex flex-wrap gap-4 text-white/55 text-sm">
            <span>{{ optional($event->starts_at)->format('d/m/Y H:i') }}</span>
            @if($event->location)<span>{{ $event->location }}</span>@endif
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4">
        <article class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm max-w-4xl mx-auto">
            @if($event->image_url)
                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full aspect-video object-cover">
            @endif
            <div class="p-6 md:p-8">
                @if($event->excerpt)<p class="text-lg text-navy font-semibold leading-relaxed mb-6">{{ $event->excerpt }}</p>@endif
                <div class="text-gray-700 leading-8 whitespace-pre-line">{{ $event->content }}</div>
            </div>
        </article>
    </div>
</section>
@endsection
