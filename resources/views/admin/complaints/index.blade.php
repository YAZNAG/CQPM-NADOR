@extends('layouts.admin')

@section('title', 'Réclamations')
@section('page-title', 'Réclamations & Renseignements')
@section('page-subtitle', 'Messages actifs reçus via le formulaire public')

@section('content')

{{-- ── Tab bar ─────────────────────────────────────────────────────────────── --}}
<div class="flex items-center gap-2 mb-5">
    <span class="inline-flex items-center gap-2 px-4 py-2 bg-navy text-white text-sm font-semibold rounded-lg shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Réclamations actives
        <span class="bg-white/20 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
            {{ $complaints->total() }}
        </span>
    </span>

    <a href="{{ route('admin.complaints.archived') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-gray-300 text-gray-600 hover:text-gray-900 text-sm font-medium rounded-lg transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2L19 8M10 12v4M14 12v4"/>
        </svg>
        Voir les archives
        @if($archivedCount > 0)
        <span class="bg-gray-100 text-gray-600 text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $archivedCount }}</span>
        @endif
    </a>
</div>

{{-- ── Main table ───────────────────────────────────────────────────────────── --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <h3 class="font-semibold text-gray-900 text-sm">Réclamations en attente de traitement</h3>
        </div>
    </div>

    @if($complaints->isEmpty())
    <div class="py-16 text-center">
        <div class="w-14 h-14 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-gray-500 text-sm font-medium">Aucune réclamation active.</p>
        <p class="text-gray-400 text-xs mt-1">Toutes les réclamations ont été traitées et archivées.</p>
        @if($archivedCount > 0)
        <a href="{{ route('admin.complaints.archived') }}"
           class="inline-flex items-center gap-1.5 mt-4 text-xs font-medium text-sea hover:text-navy transition-colors">
            Consulter les archives ({{ $archivedCount }}) →
        </a>
        @endif
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nom et prénom</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Contact</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Objet</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($complaints as $complaint)
                <tr class="hover:bg-gray-50 transition-colors">

                    <td class="px-5 py-3.5 whitespace-nowrap">
                        <div class="text-xs text-gray-500">{{ $complaint->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-400">{{ $complaint->created_at->format('H:i') }}</div>
                    </td>

                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 bg-navy/10 rounded-full flex items-center justify-center text-navy font-bold text-xs shrink-0">
                                {{ strtoupper(substr($complaint->full_name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-900 text-sm">{{ $complaint->full_name }}</span>
                        </div>
                    </td>

                    <td class="px-5 py-3.5 hidden md:table-cell">
                        <div class="text-xs text-gray-600">{{ $complaint->email }}</div>
                        <div class="text-xs text-gray-400">{{ $complaint->phone }}</div>
                    </td>

                    <td class="px-5 py-3.5">
                        <span class="text-sm text-gray-700 line-clamp-1">{{ $complaint->subject }}</span>
                    </td>

                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-2 flex-wrap">
                            {{-- Open --}}
                            <a href="{{ route('admin.complaints.show', $complaint) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-navy hover:bg-navy-dark text-white text-xs font-bold rounded-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ouvrir
                            </a>

                            {{-- Archive --}}
                            <form method="POST" action="{{ route('admin.complaints.archive', $complaint) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Marquer cette réclamation comme traitée et l\'archiver ?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="hidden sm:inline">Archiver — Traitée</span>
                                    <span class="sm:hidden">Archiver</span>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($complaints->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $complaints->links() }}
    </div>
    @endif

    @endif

</div>

@endsection
