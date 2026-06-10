<tr class="hover:bg-gray-50 transition-colors">
    <td class="px-4 py-3.5">
        <div class="flex items-center gap-2" style="padding-left: {{ $depth * 24 }}px">
            @if($depth > 0)
                <span class="text-gray-300">└</span>
            @endif
            <div>
                <div class="font-semibold text-gray-900">{{ $menu->title_fr }}</div>
                <div class="text-xs text-gray-400" dir="rtl">{{ $menu->title_ar }}</div>
                <div class="text-[11px] text-gray-300 mt-0.5">slug: {{ $menu->slug }}</div>
            </div>
        </div>
    </td>
    <td class="px-4 py-3.5">
        <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-gray-600 text-xs font-medium">
            {{ $menu->type }}
        </span>
        <div class="text-xs text-gray-500 mt-1 max-w-64 truncate">{{ $menu->url ?: '#' }}</div>
        <div class="text-[11px] text-gray-400">{{ $menu->target }}</div>
    </td>
    <td class="px-4 py-3.5 text-center">
        <input type="number" form="menu-order-form" name="positions[{{ $menu->id }}]" value="{{ $menu->position }}" min="0"
               class="w-20 text-center border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy">
    </td>
    <td class="px-4 py-3.5 text-center">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full {{ $menu->show_in_header ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
            {{ $menu->show_in_header ? '✓' : '×' }}
        </span>
    </td>
    <td class="px-4 py-3.5 text-center">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full {{ $menu->show_in_footer ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
            {{ $menu->show_in_footer ? '✓' : '×' }}
        </span>
    </td>
    <td class="px-4 py-3.5 text-center">
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $menu->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $menu->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
            {{ $menu->is_active ? 'Actif' : 'Inactif' }}
        </span>
    </td>
    <td class="px-4 py-3.5">
        <div class="flex items-center justify-end gap-1.5 flex-wrap">
            <form method="POST" action="{{ route('admin.menus.toggle', $menu) }}">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="px-2.5 py-1.5 text-xs font-medium rounded-lg transition-all {{ $menu->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                    {{ $menu->is_active ? 'Désactiver' : 'Activer' }}
                </button>
            </form>
            <a href="{{ route('admin.menus.edit', $menu) }}"
               class="px-2.5 py-1.5 bg-navy/5 hover:bg-navy hover:text-white text-navy text-xs font-medium rounded-lg transition-all">
                Modifier
            </a>
            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}"
                  onsubmit="return confirm('Supprimer ce menu et ses sous-menus ?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-2.5 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 text-xs font-medium rounded-lg transition-all">
                    Suppr.
                </button>
            </form>
        </div>
    </td>
</tr>

@foreach($menu->children as $child)
    @include('admin.menus._row', ['menu' => $child, 'depth' => $depth + 1])
@endforeach
