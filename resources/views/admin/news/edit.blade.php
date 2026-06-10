@extends('layouts.admin')

@section('title', 'Modifier une actualité')
@section('page-title', 'Modifier une actualité')
@section('page-subtitle', 'Actualités > Modifier')

@section('content')
    <div class="mb-5">
        <a href="{{ route('news.show', $article) }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg">Voir l’actualité</a>
    </div>
    @include('admin.news._form')
@endsection
