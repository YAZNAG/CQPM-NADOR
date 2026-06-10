@php
    $isEdit = $event->exists;
    $startsAt = old('starts_at', optional($event->starts_at)->format('Y-m-d\TH:i'));
    $endsAt = old('ends_at', optional($event->ends_at)->format('Y-m-d\TH:i'));
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.events.update', $event) : route('admin.events.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4"><h2 class="text-white font-semibold text-sm">{{ $isEdit ? 'Modifier l’événement' : 'Créer un événement' }}</h2></div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre français *</label>
                <input name="title_fr" value="{{ old('title_fr', $event->title_fr) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                @error('title_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Titre arabe *</label>
                <input name="title_ar" dir="rtl" value="{{ old('title_ar', $event->title_ar) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                @error('title_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Slug</label>
                <input name="slug" value="{{ old('slug', $event->slug) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Position</label>
                <input type="number" min="0" name="position" value="{{ old('position', $event->position ?? 0) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Début</label>
                <input type="datetime-local" name="starts_at" value="{{ $startsAt }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Fin</label>
                <input type="datetime-local" name="ends_at" value="{{ $endsAt }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                @error('ends_at')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Lieu français</label>
                <input name="location_fr" value="{{ old('location_fr', $event->location_fr) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Lieu arabe</label>
                <input name="location_ar" dir="rtl" value="{{ old('location_ar', $event->location_ar) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Résumé français</label>
                <textarea name="excerpt_fr" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('excerpt_fr', $event->excerpt_fr) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Résumé arabe</label>
                <textarea name="excerpt_ar" rows="3" dir="rtl" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('excerpt_ar', $event->excerpt_ar) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Contenu français</label>
                <textarea name="content_fr" rows="6" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('content_fr', $event->content_fr) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Contenu arabe</label>
                <textarea name="content_ar" rows="6" dir="rtl" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('content_ar', $event->content_ar) }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Image</label>
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white">
            @if($event->image_url)
                <img src="{{ $event->image_url }}" alt="{{ $event->title_fr }}" class="mt-3 h-24 w-40 object-cover rounded-lg border">
                <label class="mt-3 flex items-center gap-2 text-sm text-gray-600"><input type="checkbox" name="remove_image" value="1"> Supprimer l’image actuelle</label>
            @endif
        </div>
        <div class="space-y-3">
            <input name="meta_title_fr" value="{{ old('meta_title_fr', $event->meta_title_fr) }}" placeholder="Meta title FR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <input name="meta_title_ar" dir="rtl" value="{{ old('meta_title_ar', $event->meta_title_ar) }}" placeholder="Meta title AR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
            <textarea name="meta_description_fr" rows="2" maxlength="255" placeholder="Meta description FR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('meta_description_fr', $event->meta_description_fr) }}</textarea>
            <textarea name="meta_description_ar" rows="2" maxlength="255" dir="rtl" placeholder="Meta description AR" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">{{ old('meta_description_ar', $event->meta_description_ar) }}</textarea>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->exists ? $event->is_active : true) ? 'checked' : '' }} class="w-4 h-4 text-navy border-gray-300 rounded">
            <span class="text-sm text-gray-700">Événement actif</span>
        </label>
    </div>

    <div class="flex justify-between gap-3 bg-white rounded-xl border border-gray-200 px-5 py-4">
        <a href="{{ route('admin.events.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-medium rounded-lg">Annuler</a>
        <button class="px-6 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg">{{ $isEdit ? 'Enregistrer' : 'Créer' }}</button>
    </div>
</form>
