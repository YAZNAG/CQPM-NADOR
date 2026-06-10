@extends('layouts.admin')

@section('title', 'Modifier un événement')
@section('page-title', 'Modifier un événement')
@section('page-subtitle', 'Événements > Modifier')

@section('content')
    <div class="mb-5">
        <a href="{{ route('events.show', $event) }}" target="_blank" class="inline-flex px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg">Voir l’événement</a>
    </div>
    @include('admin.events._form')
@endsection
