@extends('layouts.app')

@section('title', $seo['title'])

@section('content')
@php $isRtl = app()->getLocale() === 'ar'; @endphp

<section class="bg-navy text-white">
    <div class="max-w-screen-xl mx-auto px-4 py-14">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3">{{ $isRtl ? 'الأنشطة' : 'Événements' }}</h1>
        <p class="text-white/65 max-w-2xl">{{ $seo['description'] }}</p>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($events as $event)
                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                    <a href="{{ route('events.show', $event) }}" class="block">
                        <div class="aspect-video bg-navy overflow-hidden flex items-center justify-center">
                            @if($event->image_url)
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            @else
                                <span class="text-gold font-bold text-lg">{{ $isRtl ? 'نشاط' : 'Événement' }}</span>
                            @endif
                        </div>
                    </a>
                    <div class="p-5">
                        <time class="text-xs font-semibold text-gold">{{ optional($event->starts_at)->format('d/m/Y H:i') ?: ($isRtl ? 'قريبا' : 'Prochainement') }}</time>
                        <h2 class="mt-3 font-bold text-navy text-lg leading-snug"><a href="{{ route('events.show', $event) }}" class="hover:text-sea">{{ $event->title }}</a></h2>
                        @if($event->location)
                            <p class="text-xs text-gray-400 mt-2">{{ $event->location }}</p>
                        @endif
                        <p class="text-gray-500 text-sm leading-relaxed mt-3">{{ $event->excerpt }}</p>
                    </div>
                </article>
            @empty
                <div class="lg:col-span-3 bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center text-gray-400">
                    {{ $isRtl ? 'لا توجد أنشطة منشورة حاليا.' : 'Aucun événement publié pour le moment.' }}
                </div>
            @endforelse
        </div>
        @if($events->hasPages())<div class="mt-8">{{ $events->links() }}</div>@endif
    </div>
</section>
@endsection
