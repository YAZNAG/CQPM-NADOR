@php
    $isEdit = $article->exists;
    $publishedAt = old('published_at', optional($article->published_at)->format('Y-m-d\TH:i'));
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.news.update', $article) : route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">{{ $isEdit ? 'Modifier l’actualité' : 'Créer une actualité' }}</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre français <span class="text-red-500">*</span></label>
                <input type="text" name="title_fr" value="{{ old('title_fr', $article->title_fr) }}" class="w-full border @error('title_fr') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('title_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre arabe <span class="text-red-500">*</span></label>
                <input type="text" name="title_ar" dir="rtl" value="{{ old('title_ar', $article->title_ar) }}" class="w-full border @error('title_ar') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('title_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Slug public</label>
                <input type="text" name="slug" value="{{ old('slug', $article->slug) }}" placeholder="titre-actualite" class="w-full border @error('slug') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Date de publication</label>
                <input type="datetime-local" name="published_at" value="{{ $publishedAt }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Résumé français</label>
                <textarea name="excerpt_fr" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('excerpt_fr', $article->excerpt_fr) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Résumé arabe</label>
                <textarea name="excerpt_ar" rows="3" dir="rtl" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('excerpt_ar', $article->excerpt_ar) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Contenu français <span class="text-red-500">*</span></label>
                <textarea name="content_fr" rows="7" class="w-full border @error('content_fr') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('content_fr', $article->content_fr) }}</textarea>
                @error('content_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Contenu arabe <span class="text-red-500">*</span></label>
                <textarea name="content_ar" rows="7" dir="rtl" class="w-full border @error('content_ar') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('content_ar', $article->content_ar) }}</textarea>
                @error('content_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Image et SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Image</label>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="w-full border @error('image') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm bg-white">
                <p class="text-gray-400 text-xs mt-1">JPG, JPEG, PNG, WEBP. Max 5 Mo.</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                @if($article->image_url)
                    <img src="{{ $article->image_url }}" alt="{{ $article->title_fr }}" class="mt-3 h-24 w-40 object-cover rounded-lg border border-gray-200">
                    <label class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-navy focus:ring-navy">
                        Supprimer l’image actuelle
                    </label>
                @endif
            </div>
            <div class="space-y-3">
                <input type="text" name="meta_title_fr" value="{{ old('meta_title_fr', $article->meta_title_fr) }}" placeholder="Meta title FR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                <input type="text" name="meta_title_ar" dir="rtl" value="{{ old('meta_title_ar', $article->meta_title_ar) }}" placeholder="Meta title AR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                <textarea name="meta_description_fr" rows="2" maxlength="255" placeholder="Meta description FR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('meta_description_fr', $article->meta_description_fr) }}</textarea>
                <textarea name="meta_description_ar" rows="2" maxlength="255" dir="rtl" placeholder="Meta description AR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('meta_description_ar', $article->meta_description_ar) }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Position <span class="text-red-500">*</span></label>
            <input type="number" min="0" name="position" value="{{ old('position', $article->position ?? 0) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
        </div>
        <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer self-end">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $article->exists ? $article->is_active : true) ? 'checked' : '' }} class="w-4 h-4 text-navy border-gray-300 rounded focus:ring-navy">
            <span class="text-sm text-gray-700">Actualité active</span>
        </label>
    </div>

    <div class="flex justify-between gap-3 bg-white rounded-xl border border-gray-200 px-5 py-4">
        <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-medium rounded-lg">Annuler</a>
        <button class="px-6 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg">{{ $isEdit ? 'Enregistrer' : 'Créer' }}</button>
    </div>
</form>
