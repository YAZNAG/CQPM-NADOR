@extends('layouts.admin')

@section('title', 'Modifier l\'article')
@section('page-title', 'Modifier l\'article')
@section('page-subtitle', 'Mettre à jour le contenu de cet article')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.articles.index') }}"
       class="inline-flex items-center gap-1 text-xs text-gray-400 hover:text-navy mb-5 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour à la liste
    </a>

    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data"
          class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        @csrf @method('PUT')

        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h2 class="text-sm font-bold text-navy">Modifier l'article #{{ $article->id }}</h2>
            <span class="text-xs text-gray-400">Publié le {{ $article->created_at->format('d/m/Y') }}</span>
        </div>

        <div class="p-6 space-y-5">

            {{-- Title --}}
            <div>
                <label for="title" class="block text-xs font-semibold text-gray-700 mb-1.5">
                    Titre <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $article->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition @error('title') border-red-400 bg-red-50 @enderror">
                @error('title')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="block text-xs font-semibold text-gray-700 mb-1.5">
                    Contenu <span class="text-red-500">*</span>
                </label>
                <textarea id="content" name="content" rows="10"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-y @error('content') border-red-400 bg-red-50 @enderror">{{ old('content', $article->content) }}</textarea>
                @error('content')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current file --}}
            @if($article->file_path)
            <div class="p-3.5 bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-between gap-3">
                <div class="flex items-center gap-2 min-w-0">
                    @if($article->isImage())
                    <svg class="w-4 h-4 text-sea shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @else
                    <svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M14,2H6A2,2,0,0,0,4,4V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V8Z"/></svg>
                    @endif
                    <span class="text-xs text-gray-600 truncate">Pièce jointe actuelle : {{ basename($article->file_path) }}</span>
                </div>
                <a href="{{ $article->file_url }}" target="_blank"
                   class="text-xs text-sea hover:underline shrink-0">Voir</a>
            </div>
            @endif

            {{-- New file --}}
            <div>
                <label for="file" class="block text-xs font-semibold text-gray-700 mb-1.5">
                    {{ $article->file_path ? 'Remplacer la pièce jointe' : 'Pièce jointe' }}
                    <span class="text-gray-400 font-normal">(optionnel — image ou PDF, max 10 Mo)</span>
                </label>
                <input type="file" id="file" name="file"
                       accept=".jpg,.jpeg,.png,.gif,.webp,.pdf"
                       class="w-full text-sm text-gray-600 border border-gray-300 rounded-lg px-3 py-2 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-light cursor-pointer @error('file') border-red-400 @enderror">
                @error('file')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-3">
            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}"
                  onsubmit="return confirm('Supprimer cet article définitivement ?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1 text-xs text-red-500 hover:text-red-700 font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Supprimer cet article
                </button>
            </form>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.articles.index') }}"
                   class="px-4 py-2 text-sm text-gray-600 hover:text-navy font-medium transition-colors">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Enregistrer
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
