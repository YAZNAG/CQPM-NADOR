@extends('layouts.admin')

@section('title', 'Nouvel article')
@section('page-title', 'Nouvel article')
@section('page-subtitle', 'Rédiger et publier un nouvel article ou actualité')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.articles.index') }}"
       class="inline-flex items-center gap-1 text-xs text-gray-400 hover:text-navy mb-5 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour à la liste
    </a>

    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data"
          class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        @csrf

        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h2 class="text-sm font-bold text-navy">Contenu de l'article</h2>
        </div>

        <div class="p-6 space-y-5">

            {{-- Title --}}
            <div>
                <label for="title" class="block text-xs font-semibold text-gray-700 mb-1.5">
                    Titre <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title"
                       value="{{ old('title') }}"
                       placeholder="Titre de l'article ou de l'actualité"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition @error('title') border-red-400 bg-red-50 @enderror">
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
                          placeholder="Rédigez le contenu en texte simple. Les retours à la ligne seront conservés."
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-y @error('content') border-red-400 bg-red-50 @enderror">{{ old('content') }}</textarea>
                @error('content')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- File --}}
            <div>
                <label for="file" class="block text-xs font-semibold text-gray-700 mb-1.5">
                    Pièce jointe <span class="text-gray-400 font-normal">(optionnel — image ou PDF, max 10 Mo)</span>
                </label>
                <input type="file" id="file" name="file"
                       accept=".jpg,.jpeg,.png,.gif,.webp,.pdf"
                       class="w-full text-sm text-gray-600 border border-gray-300 rounded-lg px-3 py-2 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-light cursor-pointer @error('file') border-red-400 @enderror">
                @error('file')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.articles.index') }}"
               class="px-4 py-2 text-sm text-gray-600 hover:text-navy font-medium transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Publier l'article
            </button>
        </div>
    </form>
</div>

@endsection
