@php
    $isEdit = $page->exists;
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.pages.update', $page) : route('admin.pages.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">{{ $isEdit ? 'Modifier la page' : 'Créer une page' }}</h2>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre français <span class="text-red-500">*</span></label>
                <input type="text" name="title_fr" value="{{ old('title_fr', $page->title_fr) }}"
                       class="w-full border @error('title_fr') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('title_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre arabe <span class="text-red-500">*</span></label>
                <input type="text" name="title_ar" dir="rtl" value="{{ old('title_ar', $page->title_ar) }}"
                       class="w-full border @error('title_ar') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('title_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Slug <span class="text-red-500">*</span></label>
                <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" placeholder="centre"
                       class="w-full border @error('slug') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Position <span class="text-red-500">*</span></label>
                <input type="number" name="position" min="0" value="{{ old('position', $page->position ?? 0) }}"
                       class="w-full border @error('position') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('position')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Contenu français</label>
                <textarea name="content_fr" rows="5"
                          class="w-full border @error('content_fr') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('content_fr', $page->content_fr) }}</textarea>
                @error('content_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Contenu arabe</label>
                <textarea name="content_ar" rows="5" dir="rtl"
                          class="w-full border @error('content_ar') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('content_ar', $page->content_ar) }}</textarea>
                @error('content_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Image principale</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                       class="w-full border @error('image') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm bg-white">
                <p class="text-gray-400 text-xs mt-1">Formats acceptés : JPG, JPEG, PNG, WEBP. Taille max : 5 Mo.</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                @if($page->image_path)
                    <img src="{{ $page->image_url }}" alt="{{ $page->title_fr }}" class="h-24 w-40 object-cover rounded-lg border border-gray-200">
                    <label class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-navy focus:ring-navy">
                        Supprimer l’image actuelle
                    </label>
                @else
                    <div class="h-24 w-40 rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-xs text-gray-400">Aucune image</div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Meta title français</label>
                <input type="text" name="meta_title_fr" value="{{ old('meta_title_fr', $page->meta_title_fr) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Meta title arabe</label>
                <input type="text" name="meta_title_ar" dir="rtl" value="{{ old('meta_title_ar', $page->meta_title_ar) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Meta description français</label>
                <textarea name="meta_description_fr" rows="3" maxlength="255"
                          class="w-full border @error('meta_description_fr') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('meta_description_fr', $page->meta_description_fr) }}</textarea>
                @error('meta_description_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Meta description arabe</label>
                <textarea name="meta_description_ar" rows="3" maxlength="255" dir="rtl"
                          class="w-full border @error('meta_description_ar') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('meta_description_ar', $page->meta_description_ar) }}</textarea>
                @error('meta_description_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Options d’affichage</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $page->exists ? $page->is_active : true) ? 'checked' : '' }}
                       class="w-4 h-4 text-navy border-gray-300 rounded focus:ring-navy">
                <span class="text-sm text-gray-700">Page active</span>
            </label>
            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                <input type="checkbox" name="show_in_menu" value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}
                       class="w-4 h-4 text-navy border-gray-300 rounded focus:ring-navy">
                <span class="text-sm text-gray-700">Afficher dans les menus CMS</span>
            </label>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white rounded-xl border border-gray-200 px-5 py-4">
        <a href="{{ route('admin.pages.index') }}"
           class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-medium rounded-lg transition-all">
            Annuler
        </a>
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
            {{ $isEdit ? 'Enregistrer les modifications' : 'Créer la page' }}
        </button>
    </div>
</form>
