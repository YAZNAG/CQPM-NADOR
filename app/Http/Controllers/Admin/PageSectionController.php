<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PageSectionController extends Controller
{
    public function index(Page $page)
    {
        $sections = $page->sections()->ordered()->get();

        return view('admin.page-sections.index', compact('page', 'sections'));
    }

    public function create(Page $page)
    {
        return view('admin.page-sections.create', [
            'page' => $page,
            'section' => new PageSection(['is_active' => true]),
            'types' => PageSection::TYPES,
        ]);
    }

    public function store(Request $request, Page $page)
    {
        $data = $this->validatedData($request, $page);
        $data['page_id'] = $page->id;
        $data['is_active'] = $request->boolean('is_active');
        $data['extra_data'] = $this->decodeExtraData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('sections', 'public');
        }

        unset($data['image'], $data['remove_image']);

        PageSection::create($data);

        return redirect()->route('admin.pages.sections.index', $page)
            ->with('success', 'Section créée avec succès.');
    }

    public function edit(Page $page, PageSection $section)
    {
        $this->ensureSectionBelongsToPage($page, $section);

        return view('admin.page-sections.edit', [
            'page' => $page,
            'section' => $section,
            'types' => PageSection::TYPES,
        ]);
    }

    public function update(Request $request, Page $page, PageSection $section)
    {
        $this->ensureSectionBelongsToPage($page, $section);

        $data = $this->validatedData($request, $page, $section);
        $data['is_active'] = $request->boolean('is_active');
        $data['extra_data'] = $this->decodeExtraData($request);

        if ($request->boolean('remove_image') && $section->image_path) {
            Storage::disk('public')->delete($section->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($section->image_path) {
                Storage::disk('public')->delete($section->image_path);
            }

            $data['image_path'] = $request->file('image')->store('sections', 'public');
        }

        unset($data['image'], $data['remove_image']);

        $section->update($data);

        return redirect()->route('admin.pages.sections.index', $page)
            ->with('success', 'Section mise à jour avec succès.');
    }

    public function destroy(Page $page, PageSection $section)
    {
        $this->ensureSectionBelongsToPage($page, $section);

        if ($section->image_path) {
            Storage::disk('public')->delete($section->image_path);
        }

        $section->delete();

        return redirect()->route('admin.pages.sections.index', $page)
            ->with('success', 'Section supprimée avec succès.');
    }

    public function toggle(Page $page, PageSection $section)
    {
        $this->ensureSectionBelongsToPage($page, $section);

        $section->update(['is_active' => ! $section->is_active]);

        return back()->with('success', 'Statut de la section mis à jour.');
    }

    public function updateOrder(Request $request, Page $page)
    {
        $data = $request->validate([
            'positions' => ['required', 'array'],
            'positions.*' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($data['positions'] as $sectionId => $position) {
            $page->sections()->whereKey($sectionId)->update(['position' => $position]);
        }

        Page::clearCmsCache();

        return back()->with('success', 'Ordre des sections mis à jour.');
    }

    public function all()
    {
        $sections = PageSection::with('page')->ordered()->paginate(20);

        return view('admin.page-sections.all', compact('sections'));
    }

    private function validatedData(Request $request, Page $page, ?PageSection $section = null): array
    {
        return $request->validate([
            'section_key' => [
                'required',
                'string',
                'max:100',
                Rule::unique('page_sections', 'section_key')
                    ->where('page_id', $page->id)
                    ->ignore($section),
            ],
            'section_type' => ['required', Rule::in(PageSection::TYPES)],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'subtitle_fr' => ['nullable', 'string', 'max:255'],
            'subtitle_ar' => ['nullable', 'string', 'max:255'],
            'content_fr' => ['nullable', 'string'],
            'content_ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'button_text_fr' => ['nullable', 'string', 'max:255'],
            'button_text_ar' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:2048'],
            'second_button_text_fr' => ['nullable', 'string', 'max:255'],
            'second_button_text_ar' => ['nullable', 'string', 'max:255'],
            'second_button_url' => ['nullable', 'string', 'max:2048'],
            'extra_data' => ['nullable', 'json'],
            'position' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'remove_image' => ['nullable', 'boolean'],
        ], [
            'section_key.required' => 'La clé de section est obligatoire.',
            'section_key.unique' => 'Cette clé existe déjà pour cette page.',
            'section_type.required' => 'Le type de section est obligatoire.',
            'section_type.in' => 'Le type de section sélectionné est invalide.',
            'image.mimes' => 'L’image doit être au format JPG, JPEG, PNG ou WEBP.',
            'image.max' => 'L’image ne doit pas dépasser 5 Mo.',
            'video_url.url' => 'L’URL vidéo doit être valide.',
            'extra_data.json' => 'Les données complémentaires doivent être un JSON valide.',
            'position.integer' => 'La position doit être numérique.',
        ]);
    }

    private function decodeExtraData(Request $request): ?array
    {
        if (! $request->filled('extra_data')) {
            return null;
        }

        return json_decode($request->input('extra_data'), true);
    }

    private function ensureSectionBelongsToPage(Page $page, PageSection $section): void
    {
        abort_unless($section->page_id === $page->id, 404);
    }
}
