@extends('layouts.admin')

@section('title', 'Ajouter un média')
@section('page-title', 'Ajouter un média')
@section('page-subtitle', 'Galerie médias > Ajouter')

@section('content')
    @include('admin.media._form')
@endsection
