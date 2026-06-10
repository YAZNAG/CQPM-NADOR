@php
    $isEdit = $menu->exists;
    $selectedParent = old('parent_id', $menu->parent_id);
    $selectedType = old('type', $menu->type ?: 'internal');
    $openInNewTab = old('open_in_new_tab', $menu->target === '_blank');
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.menus.update', $menu) : route('admin.menus.store') }}" class="space-y-5">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-navy px-5 py-4">
            <h2 class="text-white font-semibold text-sm">{{ $isEdit ? 'Modifier le menu' : 'Créer un menu' }}</h2>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    Titre en français <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title_fr" value="{{ old('title_fr', $menu->title_fr) }}"
                       class="w-full border @error('title_fr') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('title_fr')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    Titre en arabe <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title_ar" dir="rtl" value="{{ old('title_ar', $menu->title_ar) }}"
                       class="w-full border @error('title_ar') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('title_ar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    Type de lien <span class="text-red-500">*</span>
                </label>
                <select name="type"
                        class="w-full border @error('type') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy bg-white">
                    @foreach([
                        'internal' => 'Interne',
                        'external' => 'Externe',
                        'page' => 'Page',
                        'route' => 'Route Laravel',
                    ] as $value => $label)
                        <option value="{{ $value }}" {{ $selectedType === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    URL ou route
                </label>
                <input type="text" name="url" value="{{ old('url', $menu->url) }}" placeholder="/formations, https://exemple.ma ou home"
                       class="w-full border @error('url') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                <p class="text-gray-400 text-xs mt-1">Obligatoire pour un lien externe. Pour le type route, utilisez le nom de route Laravel.</p>
                @error('url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    Menu parent
                </label>
                <select name="parent_id"
                        class="w-full border @error('parent_id') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy bg-white">
                    <option value="">Aucun parent</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}" {{ (string) $selectedParent === (string) $parent->id ? 'selected' : '' }}>
                            {{ $parent->title_fr }} / {{ $parent->title_ar }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    Position <span class="text-red-500">*</span>
                </label>
                <input type="number" name="position" min="0" value="{{ old('position', $menu->position ?? 0) }}"
                       class="w-full border @error('position') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
                @error('position')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Options d'affichage</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                <input type="checkbox" name="open_in_new_tab" value="1" {{ $openInNewTab ? 'checked' : '' }}
                       class="w-4 h-4 text-navy border-gray-300 rounded focus:ring-navy">
                <span class="text-sm text-gray-700">Ouvrir dans nouvel onglet</span>
            </label>

            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                <input type="checkbox" name="show_in_header" value="1" {{ old('show_in_header', $menu->show_in_header) ? 'checked' : '' }}
                       class="w-4 h-4 text-navy border-gray-300 rounded focus:ring-navy">
                <span class="text-sm text-gray-700">Afficher dans header</span>
            </label>

            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                <input type="checkbox" name="show_in_footer" value="1" {{ old('show_in_footer', $menu->show_in_footer) ? 'checked' : '' }}
                       class="w-4 h-4 text-navy border-gray-300 rounded focus:ring-navy">
                <span class="text-sm text-gray-700">Afficher dans footer</span>
            </label>

            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-navy border-gray-300 rounded focus:ring-navy">
                <span class="text-sm text-gray-700">Menu actif</span>
            </label>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white rounded-xl border border-gray-200 px-5 py-4">
        <a href="{{ route('admin.menus.index') }}"
           class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-medium rounded-lg transition-all">
            Annuler
        </a>
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-semibold rounded-lg transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ $isEdit ? 'Enregistrer les modifications' : 'Créer le menu' }}
        </button>
    </div>
</form>
