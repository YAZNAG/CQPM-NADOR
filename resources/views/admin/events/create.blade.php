@extends('layouts.admin')

@section('title', 'Ajouter un événement')
@section('page-title', 'Ajouter un événement')
@section('page-subtitle', 'Événements > Ajouter')

@section('content')
    @include('admin.events._form')
@endsection
