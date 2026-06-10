@extends('layouts.admin')

@section('title', 'Ajouter une actualité')
@section('page-title', 'Ajouter une actualité')
@section('page-subtitle', 'Actualités > Ajouter')

@section('content')
    @include('admin.news._form')
@endsection
