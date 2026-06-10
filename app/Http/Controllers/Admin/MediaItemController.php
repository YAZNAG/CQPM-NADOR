<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MediaItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaItem::query()->ordered();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title_fr', 'like', "%{$search}%")
                    ->orWhere('title_ar', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('category_fr', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('media_type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $mediaItems = $query->paginate(18)->withQueryString();

        return view('admin.media.index', compact('mediaItems'));
    }

    public function create()
    {
        return view('admin.media.create', [
            'mediaItem' => new MediaItem(['is_active' => true, 'media_type' => 'image']),
            'types' => MediaItem::TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('media', 'public');
        }

        unset($data['image'], $data['remove_image']);

        MediaItem::create($data);

        return redirect()->route('admin.media.index')
            ->with('success', 'Média créé avec succès.');
    }

    public function edit(MediaItem $mediaItem)
    {
        return view('admin.media.edit', [
            'mediaItem' => $mediaItem,
            'types' => MediaItem::TYPES,
        ]);
    }

    public function update(Request $request, MediaItem $mediaItem)
    {
        $data = $this->validatedData($request, $mediaItem);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->boolean('remove_image') && $mediaItem->image_path) {
            Storage::disk('public')->delete($mediaItem->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($mediaItem->image_path) {
                Storage::disk('public')->delete($mediaItem->image_path);
            }

            $data['image_path'] = $request->file('image')->store('media', 'public');
        }

        unset($data['image'], $data['remove_image']);

        $mediaItem->update($data);

        return redirect()->route('admin.media.index')
            ->with('success', 'Média mis à jour avec succès.');
    }

    public function destroy(MediaItem $mediaItem)
    {
        if ($mediaItem->image_path) {
            Storage::disk('public')->delete($mediaItem->image_path);
        }

        $mediaItem->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Média supprimé avec succès.');
    }

    private function validatedData(Request $request, ?MediaItem $mediaItem = null): array
    {
        $slugSource = $request->filled('slug') ? $request->input('slug') : $request->input('title_fr');

        $request->merge([
            'slug' => Str::slug((string) $slugSource),
        ]);

        return $request->validate([
            'title_fr' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('media_items', 'slug')->ignore($mediaItem)],
            'description_fr' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'media_type' => ['required', Rule::in(MediaItem::TYPES)],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'alt_fr' => ['nullable', 'string', 'max:255'],
            'alt_ar' => ['nullable', 'string', 'max:255'],
            'category_fr' => ['nullable', 'string', 'max:255'],
            'category_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_fr' => ['nullable', 'string', 'max:255'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_description_fr' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'position' => ['required', 'integer', 'min:0'],
            'remove_image' => ['nullable', 'boolean'],
        ]);
    }
}
