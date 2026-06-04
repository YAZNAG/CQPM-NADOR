@extends('layouts.admin')

@section('title', 'Documents PDF')
@section('page-title', 'Gestion des documents PDF')
@section('page-subtitle', 'Téléversez et gérez les documents disponibles en téléchargement public')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Upload form --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden sticky top-6">
            <div class="bg-navy px-5 py-4">
                <h3 class="text-white font-semibold text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Ajouter un document
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                        Titre du document <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="Ex: Formulaire de candidature 2024"
                           class="w-full border @error('title') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                        Fichier PDF <span class="text-red-500">*</span>
                    </label>
                    <label class="block cursor-pointer">
                        <div class="border-2 border-dashed @error('file') border-red-300 bg-red-50 @else border-gray-200 hover:border-navy/30 @enderror rounded-xl p-6 text-center transition-all" id="drop-zone">
                            <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-xs text-gray-500 font-medium" id="file-label">Cliquez pour sélectionner</p>
                            <p class="text-xs text-gray-400 mt-0.5">PDF uniquement — max 10 Mo</p>
                        </div>
                        <input type="file" name="file" accept=".pdf" class="hidden" id="file-input"
                               onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Cliquez pour sélectionner'">
                    </label>
                    @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-navy hover:bg-navy-light text-white font-semibold rounded-lg text-sm transition-all shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Téléverser le document
                </button>
            </form>
        </div>
    </div>

    {{-- Documents list --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900 text-sm">Documents publiés</h3>
                <span class="bg-navy/10 text-navy text-xs font-bold px-2.5 py-1 rounded-full">{{ $documents->total() }}</span>
            </div>

            @if($documents->isEmpty())
            <div class="py-16 text-center">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-400 font-medium">Aucun document téléversé.</p>
                <p class="text-gray-300 text-sm mt-1">Utilisez le formulaire ci-contre pour ajouter des PDF.</p>
            </div>
            @else
            <div class="divide-y divide-gray-100">
                @foreach($documents as $doc)
                <div class="px-5 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors group">
                    <div class="w-10 h-10 bg-red-50 border border-red-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14,2H6A2,2,0,0,0,4,4V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V8ZM18,20H6V4h7V9h5ZM11,14H9V16H11Zm4-4H9v2H15Zm0,4H13V16H15Z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-900 text-sm truncate">{{ $doc->title }}</div>
                        <div class="flex items-center gap-3 mt-0.5">
                            <span class="text-gray-400 text-xs">Ajouté le {{ $doc->created_at->format('d/m/Y') }}</span>
                            <a href="{{ $doc->public_url }}" target="_blank"
                               class="text-xs text-sea hover:text-navy font-medium transition-colors inline-flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Télécharger
                            </a>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.documents.destroy', $doc) }}"
                          onsubmit="return confirm('Supprimer ce document ? Le fichier sera définitivement supprimé.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="opacity-0 group-hover:opacity-100 inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-500 text-xs font-medium rounded-lg transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            @if($documents->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $documents->links() }}
            </div>
            @endif

            @endif
        </div>
    </div>

</div>

@endsection
