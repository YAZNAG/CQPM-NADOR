@extends('layouts.admin')

@section('title', 'Articles & Actualités')
@section('page-title', 'Articles & Actualités')
@section('page-subtitle', 'Gérer les articles publiés sur le site public')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.articles.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvel article
    </a>
</div>

@if($articles->isEmpty())
<div class="bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center">
    <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
    </svg>
    <p class="text-gray-400 text-sm">Aucun article publié pour le moment.</p>
    <a href="{{ route('admin.articles.create') }}" class="mt-4 inline-block text-sm font-semibold text-navy underline">Créer le premier article</a>
</div>
@else
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 w-8">#</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Titre</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden sm:table-cell">Aperçu</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden md:table-cell">Pièce jointe</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden lg:table-cell">Date</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($articles as $article)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3.5 text-gray-400 font-mono text-xs">{{ $article->id }}</td>
                <td class="px-5 py-3.5">
                    <a href="{{ route('news.show', $article) }}" target="_blank"
                       class="font-semibold text-navy hover:text-sea transition-colors leading-snug line-clamp-2">
                        {{ $article->title }}
                    </a>
                </td>
                <td class="px-5 py-3.5 text-gray-400 hidden sm:table-cell">
                    <span class="line-clamp-1 text-xs">{{ Str::limit($article->content, 80) }}</span>
                </td>
                <td class="px-5 py-3.5 hidden md:table-cell">
                    @if($article->file_path)
                        @if($article->isImage())
                            <span class="inline-flex items-center gap-1 text-xs bg-sea-light text-sea font-medium px-2 py-0.5 rounded">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Image
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs bg-red-50 text-red-600 font-medium px-2 py-0.5 rounded">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M14,2H6A2,2,0,0,0,4,4V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V8Z"/></svg>
                                PDF
                            </span>
                        @endif
                    @else
                        <span class="text-gray-300 text-xs">—</span>
                    @endif
                </td>
                <td class="px-5 py-3.5 text-gray-400 text-xs hidden lg:table-cell whitespace-nowrap">
                    {{ $article->created_at->format('d/m/Y') }}
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.articles.edit', $article) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.articles.destroy', $article) }}"
                              onsubmit="return confirm('Supprimer cet article définitivement ?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 text-xs font-semibold rounded transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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

@if($articles->hasPages())
<div class="mt-5">
    {{ $articles->links() }}
</div>
@endif
@endif

@endsection
