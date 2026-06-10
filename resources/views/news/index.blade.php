@extends('layouts.app')

@section('title', $seo['title'])

@section('content')
@php
    $isRtl = app()->getLocale() === 'ar';
    $siteSigle = ($settings ?? [])['sigle'] ?? 'CQPM Nador';
@endphp

<section class="bg-navy text-white">
    <div class="max-w-screen-xl mx-auto px-4 py-14">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3">{{ $isRtl ? 'الأخبار' : 'Actualités' }}</h1>
        <p class="text-white/65 max-w-2xl">{{ $seo['description'] }}</p>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($articles as $article)
                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                    <a href="{{ route('news.show', $article) }}" class="block">
                        <div class="aspect-video bg-navy overflow-hidden flex items-center justify-center">
                            @if($article->image_url)
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            @else
                                <span class="text-gold font-bold text-lg">{{ $siteSigle }}</span>
                            @endif
                        </div>
                    </a>
                    <div class="p-5">
                        <time class="text-xs font-semibold text-gold">{{ optional($article->published_at ?: $article->created_at)->format('d/m/Y') }}</time>
                        <h2 class="mt-3 font-bold text-navy text-lg leading-snug">
                            <a href="{{ route('news.show', $article) }}" class="hover:text-sea transition-colors">{{ $article->title }}</a>
                        </h2>
                        <p class="text-gray-500 text-sm leading-relaxed mt-3">{{ $article->excerpt }}</p>
                        <a href="{{ route('news.show', $article) }}" class="inline-flex mt-4 text-sm font-bold text-gold hover:text-gold-dark">
                            {{ $isRtl ? 'اقرأ المزيد' : 'Lire la suite' }}
                        </a>
                    </div>
                </article>
            @empty
                <div class="lg:col-span-3 bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center text-gray-400">
                    {{ $isRtl ? 'لا توجد أخبار منشورة حاليا.' : 'Aucune actualité publiée pour le moment.' }}
                </div>
            @endforelse
        </div>

        @if($articles->hasPages())
            <div class="mt-8">{{ $articles->links() }}</div>
        @endif
    </div>
</section>
@endsection
