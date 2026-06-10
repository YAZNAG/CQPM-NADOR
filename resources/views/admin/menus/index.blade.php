@extends('layouts.admin')

@section('title', 'Menus')
@section('page-title', 'Gestion des menus')
@section('page-subtitle', 'Gestion du site > Menus')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h2 class="text-sm font-semibold text-gray-900">Navigation du site</h2>
        <p class="text-xs text-gray-500 mt-1">Gérez les menus du header, du footer et leurs sous-menus.</p>
    </div>
    <a href="{{ route('admin.menus.create') }}"
       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter un menu
    </a>
</div>

<form id="menu-order-form" method="POST" action="{{ route('admin.menus.order') }}" class="hidden">
    @csrf
    @method('PATCH')
</form>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="font-semibold text-gray-900 text-sm">Liste des menus</h3>
            <p class="text-gray-400 text-xs mt-0.5">Modifiez les positions puis enregistrez l'ordre.</p>
        </div>
        <button type="submit" form="menu-order-form"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gold hover:bg-gold-dark text-navy text-sm font-bold rounded-lg transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Enregistrer l'ordre
        </button>
    </div>

    @if($menus->isEmpty())
        <div class="py-14 text-center">
            <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <p class="text-gray-400 text-sm">Aucun menu créé.</p>
            <a href="{{ route('admin.menus.create') }}" class="mt-3 inline-block text-sm font-semibold text-navy underline">Créer le premier menu</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        <th class="text-left px-4 py-3">Menu</th>
                        <th class="text-left px-4 py-3">Lien</th>
                        <th class="text-center px-4 py-3">Position</th>
                        <th class="text-center px-4 py-3">Header</th>
                        <th class="text-center px-4 py-3">Footer</th>
                        <th class="text-center px-4 py-3">Statut</th>
                        <th class="text-right px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($menus as $menu)
                        @include('admin.menus._row', ['menu' => $menu, 'depth' => 0])
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
