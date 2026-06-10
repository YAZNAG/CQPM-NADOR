@extends('layouts.app')

@section('title', $seo['title'])

@section('content')
@php
    $isRtl = app()->getLocale() === 'ar';
    $siteSigle = ($settings ?? [])['sigle'] ?? 'CQPM Nador';
@endphp

<section class="bg-navy text-white">
    <div class="max-w-screen-xl mx-auto px-4 py-14">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3">{{ $isRtl ? 'المعرض' : 'Galerie médias' }}</h1>
        <p class="text-white/65 max-w-2xl">{{ $seo['description'] }}</p>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($mediaItems as $mediaItem)
                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                    <a href="{{ route('media.show', $mediaItem) }}" class="block aspect-video bg-navy overflow-hidden flex items-center justify-center">
                        @if($mediaItem->image_url)
                            <img src="{{ $mediaItem->image_url }}" alt="{{ $mediaItem->alt }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        @else
                            <span class="text-gold font-bold text-lg">{{ $mediaItem->media_type === 'video' ? 'VIDEO' : $siteSigle }}</span>
                        @endif
                    </a>
                    <div class="p-5">
                        @if($mediaItem->category)<span class="text-xs font-semibold text-gold">{{ $mediaItem->category }}</span>@endif
                        <h2 class="mt-2 font-bold text-navy text-lg"><a href="{{ route('media.show', $mediaItem) }}" class="hover:text-sea">{{ $mediaItem->title }}</a></h2>
                        @if($mediaItem->description)<p class="text-gray-500 text-sm mt-3">{{ Str::limit($mediaItem->description, 130) }}</p>@endif
                    </div>
                </article>
            @empty
                <div class="lg:col-span-3 bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center text-gray-400">
                    {{ $isRtl ? 'لا توجد وسائط منشورة حاليا.' : 'Aucun média publié pour le moment.' }}
                </div>
            @endforelse
        </div>
        @if($mediaItems->hasPages())<div class="mt-8">{{ $mediaItems->links() }}</div>@endif
    </div>
</section>
@endsection
