@extends('layouts.admin')

@section('title', 'Filières de Formation')
@section('page-title', 'Filières de Formation')
@section('page-subtitle', 'Gérer les filières affichées sur la page d\'accueil')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.filieres.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle filière
    </a>
</div>

@if($filieres->isEmpty())
<div class="bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center">
    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
    </svg>
    <p class="text-gray-400 text-sm">Aucune filière créée pour le moment.</p>
    <a href="{{ route('admin.filieres.create') }}"
       class="mt-4 inline-block text-sm font-semibold text-navy underline">
        Créer la première filière
    </a>
</div>
@else
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Icône</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Filière</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden sm:table-cell">Badge / Niveau</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden md:table-cell">Durée</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden lg:table-cell">Description</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($filieres as $filiere)
            <tr class="hover:bg-gray-50 transition-colors">

                {{-- Icon --}}
                <td class="px-5 py-3.5">
                    <div class="w-10 h-10 bg-sea-light rounded-lg flex items-center justify-center overflow-hidden shrink-0">
                        @if($filiere->icon_path)
                        <img src="{{ $filiere->icon_url }}"
                             alt="{{ $filiere->title }}"
                             class="w-full h-full object-cover">
                        @else
                        <svg class="w-5 h-5 text-sea" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        @endif
                    </div>
                </td>

                {{-- Title --}}
                <td class="px-5 py-3.5">
                    <span class="font-semibold text-navy text-sm">{{ $filiere->title }}</span>
                </td>

                {{-- Badge --}}
                <td class="px-5 py-3.5 hidden sm:table-cell">
                    <span class="inline-block text-xs bg-navy/10 text-navy px-2 py-0.5 rounded font-medium">
                        {{ $filiere->badge }}
                    </span>
                </td>

                {{-- Duration --}}
                <td class="px-5 py-3.5 hidden md:table-cell">
                    <span class="text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $filiere->duration }}
                    </span>
                </td>

                {{-- Description excerpt --}}
                <td class="px-5 py-3.5 hidden lg:table-cell">
                    <span class="text-xs text-gray-400 line-clamp-1">
                        {{ Str::limit($filiere->description, 80) }}
                    </span>
                </td>

                {{-- Actions --}}
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.filieres.edit', $filiere) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.filieres.destroy', $filiere) }}"
                              onsubmit="return confirm('Supprimer la filière « {{ $filiere->title }} » définitivement ?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 text-xs font-semibold rounded transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
