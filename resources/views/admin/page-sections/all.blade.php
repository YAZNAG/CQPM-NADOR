@extends('layouts.admin')

@section('title', 'Toutes les sections')
@section('page-title', 'Toutes les sections')
@section('page-subtitle', 'Gestion du site > Sections')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-900 text-sm">Sections de toutes les pages</h3>
        <p class="text-gray-400 text-xs mt-0.5">Pour ajouter ou réordonner, ouvrez les sections de la page concernée.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-4 py-3">Page</th>
                    <th class="text-left px-4 py-3">Clé</th>
                    <th class="text-left px-4 py-3">Type</th>
                    <th class="text-left px-4 py-3">Titre</th>
                    <th class="text-center px-4 py-3">Statut</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sections as $section)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3.5 font-semibold text-navy">{{ $section->page?->title_fr }}</td>
                    <td class="px-4 py-3.5 font-mono text-xs">{{ $section->section_key }}</td>
                    <td class="px-4 py-3.5">{{ $section->section_type }}</td>
                    <td class="px-4 py-3.5">{{ $section->title_fr ?: '—' }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <span class="inline-flex px-2 py-1 rounded-full {{ $section->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs font-semibold">
                            {{ $section->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-right">
                        @if($section->page)
                            <a href="{{ route('admin.pages.sections.edit', [$section->page, $section]) }}" class="inline-flex px-3 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded transition-all">Modifier</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400">Aucune section trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($sections->hasPages())
<div class="mt-5">
    {{ $sections->links() }}
</div>
@endif

@endsection
