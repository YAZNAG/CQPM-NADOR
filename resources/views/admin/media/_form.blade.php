@php
    $isEdit = $mediaItem->exists;
    $selectedType = old('media_type', $mediaItem->media_type ?: 'image');
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.media.update', $mediaItem) : route('admin.media.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4"><h2 class="text-white font-semibold text-sm">{{ $isEdit ? 'Modifier le média' : 'Créer un média' }}</h2></div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre français *</label>
                <input name="title_fr" value="{{ old('title_fr', $mediaItem->title_fr) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                @error('title_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre arabe *</label>
                <input name="title_ar" dir="rtl" value="{{ old('title_ar', $mediaItem->title_ar) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                @error('title_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Slug</label>
                <input name="slug" value="{{ old('slug', $mediaItem->slug) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Type</label>
                <select name="media_type" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white">
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ $selectedType === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Catégorie FR</label>
                <input name="category_fr" value="{{ old('category_fr', $mediaItem->category_fr) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Catégorie AR</label>
                <input name="category_ar" dir="rtl" value="{{ old('category_ar', $mediaItem->category_ar) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Description FR</label>
                <textarea name="description_fr" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('description_fr', $mediaItem->description_fr) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Description AR</label>
                <textarea name="description_ar" rows="4" dir="rtl" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('description_ar', $mediaItem->description_ar) }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Image</label>
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white">
            @if($mediaItem->image_url)
                <img src="{{ $mediaItem->image_url }}" alt="{{ $mediaItem->alt }}" class="mt-3 h-24 w-40 object-cover rounded-lg border">
                <label class="mt-3 flex items-center gap-2 text-sm text-gray-600"><input type="checkbox" name="remove_image" value="1"> Supprimer l’image actuelle</label>
            @endif
        </div>
        <div class="space-y-3">
            <input type="url" name="video_url" value="{{ old('video_url', $mediaItem->video_url) }}" placeholder="URL vidéo" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <input name="alt_fr" value="{{ old('alt_fr', $mediaItem->alt_fr) }}" placeholder="Texte alternatif FR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <input name="alt_ar" dir="rtl" value="{{ old('alt_ar', $mediaItem->alt_ar) }}" placeholder="Texte alternatif AR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="space-y-3">
            <input name="meta_title_fr" value="{{ old('meta_title_fr', $mediaItem->meta_title_fr) }}" placeholder="Meta title FR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <textarea name="meta_description_fr" rows="2" maxlength="255" placeholder="Meta description FR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('meta_description_fr', $mediaItem->meta_description_fr) }}</textarea>
        </div>
        <div class="space-y-3">
            <input name="meta_title_ar" dir="rtl" value="{{ old('meta_title_ar', $mediaItem->meta_title_ar) }}" placeholder="Meta title AR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <textarea name="meta_description_ar" rows="2" maxlength="255" dir="rtl" placeholder="Meta description AR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('meta_description_ar', $mediaItem->meta_description_ar) }}</textarea>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Position</label>
            <input type="number" min="0" name="position" value="{{ old('position', $mediaItem->position ?? 0) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
        </div>
        <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer self-end">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $mediaItem->exists ? $mediaItem->is_active : true) ? 'checked' : '' }} class="w-4 h-4 text-navy border-gray-300 rounded">
            <span class="text-sm text-gray-700">Média actif</span>
        </label>
    </div>

    <div class="flex justify-between gap-3 bg-white rounded-xl border border-gray-200 px-5 py-4">
        <a href="{{ route('admin.media.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-medium rounded-lg">Annuler</a>
        <button class="px-6 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg">{{ $isEdit ? 'Enregistrer' : 'Créer' }}</button>
    </div>
</form>
