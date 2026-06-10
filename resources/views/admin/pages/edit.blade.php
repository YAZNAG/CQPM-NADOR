@extends('layouts.admin')

@section('title', 'Modifier une page')
@section('page-title', 'Modifier une page')
@section('page-subtitle', 'Gestion du site > Pages > Modifier')

@section('content')
    <div class="mb-5 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.pages.sections.index', $page) }}"
           class="inline-flex items-center justify-center px-4 py-2 bg-sea-light hover:bg-sea hover:text-white text-sea text-sm font-semibold rounded-lg transition-all">
            Gérer les sections
        </a>
        <a href="{{ $page->slug === 'accueil' ? route('home') : route('pages.show', $page) }}" target="_blank"
           class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg transition-all">
            Voir la page
        </a>
    </div>

    @include('admin.pages._form')
@endsection
