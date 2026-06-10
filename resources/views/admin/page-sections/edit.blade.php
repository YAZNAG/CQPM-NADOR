@extends('layouts.admin')

@section('title', 'Modifier une section')
@section('page-title', 'Modifier une section')
@section('page-subtitle', 'Gestion du site > Pages > Sections > Modifier')

@section('content')
    @include('admin.page-sections._form')
@endsection
