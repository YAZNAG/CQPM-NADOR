@extends('layouts.admin')

@section('title', 'Ajouter une page')
@section('page-title', 'Ajouter une page')
@section('page-subtitle', 'Gestion du site > Pages > Ajouter')

@section('content')
    @include('admin.pages._form')
@endsection
