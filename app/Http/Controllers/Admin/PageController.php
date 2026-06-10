<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query()->withCount('sections')->ordered();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title_fr', 'like', "%{$search}%")
                    ->orWhere('title_ar', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $pages = $query->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['show_in_menu'] = $request->boolean('show_in_menu');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('pages', 'public');
        }

        unset($data['image'], $data['remove_image']);

        Page::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page créée avec succès.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validatedData($request, $page);
        $data['is_active'] = $request->boolean('is_active');
        $data['show_in_menu'] = $request->boolean('show_in_menu');

        if ($request->boolean('remove_image') && $page->image_path) {
            Storage::disk('public')->delete($page->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($page->image_path) {
                Storage::disk('public')->delete($page->image_path);
            }

            $data['image_path'] = $request->file('image')->store('pages', 'public');
        }

        unset($data['image'], $data['remove_image']);

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page mise à jour avec succès.');
    }

    public function destroy(Page $page)
    {
        if ($page->image_path) {
            Storage::disk('public')->delete($page->image_path);
        }

        foreach ($page->sections as $section) {
            if ($section->image_path) {
                Storage::disk('public')->delete($section->image_path);
            }
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page supprimée avec succès.');
    }

    private function validatedData(Request $request, ?Page $page = null): array
    {
        $request->merge([
            'slug' => Str::slug((string) $request->input('slug')),
        ]);

        return $request->validate([
            'title_fr' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($page)],
            'content_fr' => ['nullable', 'string'],
            'content_ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'meta_title_fr' => ['nullable', 'string', 'max:255'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_description_fr' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'show_in_menu' => ['nullable', 'boolean'],
            'position' => ['required', 'integer', 'min:0'],
            'remove_image' => ['nullable', 'boolean'],
        ], [
            'title_fr.required' => 'Le titre français est obligatoire.',
            'title_ar.required' => 'Le titre arabe est obligatoire.',
            'slug.required' => 'Le slug est obligatoire.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'image.mimes' => 'L’image doit être au format JPG, JPEG, PNG ou WEBP.',
            'image.max' => 'L’image ne doit pas dépasser 5 Mo.',
            'meta_description_fr.max' => 'La meta description française ne doit pas dépasser 255 caractères.',
            'meta_description_ar.max' => 'La meta description arabe ne doit pas dépasser 255 caractères.',
            'position.integer' => 'La position doit être numérique.',
        ]);
    }
}
