@extends('layouts.admin')

@section('title', 'Modifier un média')
@section('page-title', 'Modifier un média')
@section('page-subtitle', 'Galerie médias > Modifier')

@section('content')
    <div class="mb-5">
        <a href="{{ route('media.show', $mediaItem) }}" target="_blank" class="inline-flex px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg">Voir le média</a>
    </div>
    @include('admin.media._form')
@endsection
