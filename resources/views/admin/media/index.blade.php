@extends('layouts.admin')

@section('title', 'Galerie médias')
@section('page-title', 'Galerie médias')
@section('page-subtitle', 'Gérer les images et vidéos publiques')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <h2 class="text-sm font-semibold text-gray-900">Médias</h2>
        <p class="text-xs text-gray-500 mt-1">Images, vidéos, catégories, textes alternatifs et SEO.</p>
    </div>
    <a href="{{ route('admin.media.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Ajouter un média
    </a>
</div>

<form method="GET" action="{{ route('admin.media.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 mb-5 grid grid-cols-1 md:grid-cols-5 gap-3">
    <div class="md:col-span-2">
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Recherche</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Titre, slug ou catégorie" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Type</label>
        <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white">
            <option value="">Tous</option>
            <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Images</option>
            <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Vidéos</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Statut</label>
        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white">
            <option value="">Tous</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actifs</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactifs</option>
        </select>
    </div>
    <div class="flex items-end gap-2">
        <button class="flex-1 px-4 py-2.5 bg-navy text-white text-sm font-semibold rounded-lg">Filtrer</button>
        <a href="{{ route('admin.media.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-semibold rounded-lg">Reset</a>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse($mediaItems as $mediaItem)
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-all">
            <div class="aspect-video bg-navy flex items-center justify-center overflow-hidden">
                @if($mediaItem->image_url)
                    <img src="{{ $mediaItem->image_url }}" alt="{{ $mediaItem->alt }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gold font-bold text-sm uppercase">{{ $mediaItem->media_type }}</span>
                @endif
            </div>
            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-navy text-sm">{{ $mediaItem->title_fr }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5" dir="rtl">{{ $mediaItem->title_ar }}</p>
                    </div>
                    <span class="inline-flex px-2 py-1 rounded-full {{ $mediaItem->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs font-semibold">{{ $mediaItem->is_active ? 'Actif' : 'Inactif' }}</span>
                </div>
                <div class="mt-3 flex items-center justify-between gap-2">
                    <a href="{{ route('media.show', $mediaItem) }}" target="_blank" class="font-mono text-xs text-sea hover:underline">/media/{{ $mediaItem->slug }}</a>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.media.edit', $mediaItem) }}" class="px-3 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-semibold rounded">Modifier</a>
                        <form method="POST" action="{{ route('admin.media.destroy', $mediaItem) }}" onsubmit="return confirm('Supprimer ce média ?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 text-xs font-semibold rounded">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="md:col-span-2 xl:col-span-3 bg-white border border-dashed border-gray-300 rounded-xl p-12 text-center text-gray-400">Aucun média trouvé.</div>
    @endforelse
</div>

@if($mediaItems->hasPages())
<div class="mt-5">{{ $mediaItems->links() }}</div>
@endif

@endsection
