@php
    $isEdit = $section->exists;
    $selectedType = old('section_type', $section->section_type ?: 'custom');
    $extraDataValue = old('extra_data', $section->extra_data ? json_encode($section->extra_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '');
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.pages.sections.update', [$page, $section]) : route('admin.pages.sections.store', $page) }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">{{ $isEdit ? 'Modifier la section' : 'Créer une section' }}</h2>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Clé de section <span class="text-red-500">*</span></label>
                <input type="text" name="section_key" value="{{ old('section_key', $section->section_key) }}" placeholder="hero, statistiques, formations"
                       class="w-full border @error('section_key') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('section_key')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Type <span class="text-red-500">*</span></label>
                <select name="section_type"
                        class="w-full border @error('section_type') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ $selectedType === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @error('section_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre français</label>
                <input type="text" name="title_fr" value="{{ old('title_fr', $section->title_fr) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre arabe</label>
                <input type="text" name="title_ar" dir="rtl" value="{{ old('title_ar', $section->title_ar) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Sous-titre français</label>
                <input type="text" name="subtitle_fr" value="{{ old('subtitle_fr', $section->subtitle_fr) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Sous-titre arabe</label>
                <input type="text" name="subtitle_ar" dir="rtl" value="{{ old('subtitle_ar', $section->subtitle_ar) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Contenu français</label>
                <textarea name="content_fr" rows="5"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('content_fr', $section->content_fr) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Contenu arabe</label>
                <textarea name="content_ar" rows="5" dir="rtl"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">{{ old('content_ar', $section->content_ar) }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Médias et boutons</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Image</label>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                       class="w-full border @error('image') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm bg-white">
                <p class="text-gray-400 text-xs mt-1">Stockage : storage/app/public/sections. Taille max : 5 Mo.</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                @if($section->image_path)
                    <img src="{{ $section->image_url }}" alt="{{ $section->title_fr }}" class="mt-3 h-24 w-40 object-cover rounded-lg border border-gray-200">
                    <label class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-navy focus:ring-navy">
                        Supprimer l’image actuelle
                    </label>
                @endif
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Vidéo URL</label>
                <input type="url" name="video_url" value="{{ old('video_url', $section->video_url) }}" placeholder="https://..."
                       class="w-full border @error('video_url') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('video_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Texte bouton FR</label>
                <input type="text" name="button_text_fr" value="{{ old('button_text_fr', $section->button_text_fr) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Texte bouton AR</label>
                <input type="text" name="button_text_ar" dir="rtl" value="{{ old('button_text_ar', $section->button_text_ar) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Lien bouton</label>
                <input type="text" name="button_url" value="{{ old('button_url', $section->button_url) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
            <div></div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Deuxième bouton FR</label>
                <input type="text" name="second_button_text_fr" value="{{ old('second_button_text_fr', $section->second_button_text_fr) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Deuxième bouton AR</label>
                <input type="text" name="second_button_text_ar" dir="rtl" value="{{ old('second_button_text_ar', $section->second_button_text_ar) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Deuxième lien bouton</label>
                <input type="text" name="second_button_url" value="{{ old('second_button_url', $section->second_button_url) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Données complémentaires JSON</h3>
        <textarea name="extra_data" rows="8" spellcheck="false"
                  class="font-mono w-full border @error('extra_data') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy"
                  placeholder='[{"label_fr":"Diplômés","label_ar":"الخريجون","value":"1500+"}]'>{{ $extraDataValue }}</textarea>
        <p class="text-gray-400 text-xs mt-1">Utilisé pour les statistiques, galeries ou cartes personnalisées. Laissez vide si non nécessaire.</p>
        @error('extra_data')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Options</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Position <span class="text-red-500">*</span></label>
                <input type="number" name="position" min="0" value="{{ old('position', $section->position ?? 0) }}"
                       class="w-full border @error('position') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('position')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer self-end">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section->exists ? $section->is_active : true) ? 'checked' : '' }}
                       class="w-4 h-4 text-navy border-gray-300 rounded focus:ring-navy">
                <span class="text-sm text-gray-700">Section active</span>
            </label>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white rounded-xl border border-gray-200 px-5 py-4">
        <a href="{{ route('admin.pages.sections.index', $page) }}"
           class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-medium rounded-lg transition-all">
            Annuler
        </a>
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
            {{ $isEdit ? 'Enregistrer les modifications' : 'Créer la section' }}
        </button>
    </div>
</form>
