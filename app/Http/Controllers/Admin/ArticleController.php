<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query()->ordered();

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

        $articles = $query->paginate(15)->withQueryString();

        return view('admin.news.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.news.create', ['article' => new Article(['is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['title'] = $data['title_fr'];
        $data['content'] = $data['content_fr'];
        $data['file_path'] = null;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        unset($data['image'], $data['remove_image']);

        Article::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité créée avec succès.');
    }

    public function edit(Article $article)
    {
        return view('admin.news.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validatedData($request, $article);
        $data['is_active'] = $request->boolean('is_active');
        $data['title'] = $data['title_fr'];
        $data['content'] = $data['content_fr'];

        if ($request->boolean('remove_image') && $article->image_path) {
            Storage::disk('public')->delete($article->image_path);
            $data['image_path'] = null;
            $data['file_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($article->image_path) {
                Storage::disk('public')->delete($article->image_path);
            }

            $data['image_path'] = $request->file('image')->store('news', 'public');
            $data['file_path'] = null;
        }

        unset($data['image'], $data['remove_image']);

        $article->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité mise à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        if ($article->file_path && $article->file_path !== $article->image_path) {
            Storage::disk('public')->delete($article->file_path);
        }

        $article->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité supprimée avec succès.');
    }

    private function validatedData(Request $request, ?Article $article = null): array
    {
        $slugSource = $request->filled('slug') ? $request->input('slug') : $request->input('title_fr');

        $request->merge([
            'slug' => Str::slug((string) $slugSource),
        ]);

        return $request->validate([
            'title_fr' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('articles', 'slug')->ignore($article)],
            'excerpt_fr' => ['nullable', 'string', 'max:500'],
            'excerpt_ar' => ['nullable', 'string', 'max:500'],
            'content_fr' => ['required', 'string'],
            'content_ar' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'meta_title_fr' => ['nullable', 'string', 'max:255'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_description_fr' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
            'position' => ['required', 'integer', 'min:0'],
            'remove_image' => ['nullable', 'boolean'],
        ], [
            'title_fr.required' => 'Le titre français est obligatoire.',
            'title_ar.required' => 'Le titre arabe est obligatoire.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'content_fr.required' => 'Le contenu français est obligatoire.',
            'content_ar.required' => 'Le contenu arabe est obligatoire.',
            'image.mimes' => 'L’image doit être au format JPG, JPEG, PNG ou WEBP.',
            'image.max' => 'L’image ne doit pas dépasser 5 Mo.',
        ]);
    }
}
