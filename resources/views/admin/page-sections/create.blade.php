@extends('layouts.admin')

@section('title', 'Ajouter une section')
@section('page-title', 'Ajouter une section')
@section('page-subtitle', 'Gestion du site > Pages > Sections > Ajouter')

@section('content')
    @include('admin.page-sections._form')
@endsection
