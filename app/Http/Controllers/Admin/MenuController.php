<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::query()
            ->with(['children' => fn ($query) => $query->with('children')->ordered()])
            ->whereNull('parent_id')
            ->ordered()
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function create(): View
    {
        return view('admin.menus.create', [
            'menu' => new Menu([
                'type' => 'internal',
                'target' => '_self',
                'position' => Menu::max('position') + 1,
                'is_active' => true,
                'show_in_header' => true,
                'show_in_footer' => true,
            ]),
            'parentMenus' => Menu::ordered()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title_fr']);

        Menu::create($data);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu créé avec succès.');
    }

    public function edit(Menu $menu): View
    {
        return view('admin.menus.edit', [
            'menu' => $menu,
            'parentMenus' => Menu::whereKeyNot($menu->id)->ordered()->get(),
        ]);
    }

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $data = $this->validatedData($request, $menu);

        if ((int) ($data['parent_id'] ?? 0) === $menu->id) {
            return back()->withInput()->withErrors([
                'parent_id' => 'Un menu ne peut pas être son propre parent.',
            ]);
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu mis à jour avec succès.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu supprimé avec succès.');
    }

    public function toggle(Menu $menu): RedirectResponse
    {
        $menu->update(['is_active' => ! $menu->is_active]);

        return back()->with('success', 'Statut du menu mis à jour.');
    }

    public function updateOrder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'positions' => ['required', 'array'],
            'positions.*' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($data['positions'] as $id => $position) {
            Menu::whereKey($id)->update(['position' => (int) $position]);
        }

        Menu::clearMenuCache();

        return back()->with('success', 'Ordre des menus mis à jour.');
    }

    private function validatedData(Request $request, ?Menu $menu = null): array
    {
        $data = $request->validate([
            'parent_id' => ['nullable', 'exists:menus,id'],
            'title_fr' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(Menu::TYPES)],
            'url' => ['nullable', 'required_if:type,external', 'string', 'max:2048'],
            'position' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'show_in_header' => ['nullable', 'boolean'],
            'show_in_footer' => ['nullable', 'boolean'],
            'open_in_new_tab' => ['nullable', 'boolean'],
        ], [
            'title_fr.required' => 'Le titre en français est obligatoire.',
            'title_ar.required' => 'Le titre en arabe est obligatoire.',
            'type.required' => 'Le type de lien est obligatoire.',
            'url.required_if' => 'L\'URL est obligatoire pour un lien externe.',
            'position.integer' => 'La position doit être numérique.',
        ]);

        $data['parent_id'] = $data['parent_id'] ?? null;
        $data['url'] = $data['url'] ?? null;
        $data['target'] = $request->boolean('open_in_new_tab') ? '_blank' : '_self';
        $data['is_active'] = $request->boolean('is_active');
        $data['show_in_header'] = $request->boolean('show_in_header');
        $data['show_in_footer'] = $request->boolean('show_in_footer');

        unset($data['open_in_new_tab']);

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'menu';
        $slug = $base;
        $counter = 2;

        while (Menu::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
