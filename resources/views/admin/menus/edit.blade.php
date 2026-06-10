@extends('layouts.admin')

@section('title', 'Modifier le menu')
@section('page-title', 'Modifier le menu')
@section('page-subtitle', $menu->title_fr . ' / ' . $menu->title_ar)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.menus.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-navy transition-colors font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour aux menus
    </a>
</div>

@include('admin.menus._form')

@endsection
