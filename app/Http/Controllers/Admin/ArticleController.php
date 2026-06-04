<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:50000'],
            'file'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:10240'],
        ], [
            'title.required'   => 'Le titre est obligatoire.',
            'content.required' => 'Le contenu est obligatoire.',
            'file.mimes'       => 'Le fichier doit être une image (JPG, PNG, GIF, WEBP) ou un PDF.',
            'file.max'         => 'Le fichier ne doit pas dépasser 10 Mo.',
        ]);

        $data['content'] = strip_tags($request->input('content'));
        $data['file_path'] = null;

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('articles', 'public');
        }

        unset($data['file']);
        Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article publié avec succès.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:50000'],
            'file'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:10240'],
        ], [
            'title.required'   => 'Le titre est obligatoire.',
            'content.required' => 'Le contenu est obligatoire.',
            'file.mimes'       => 'Le fichier doit être une image (JPG, PNG, GIF, WEBP) ou un PDF.',
            'file.max'         => 'Le fichier ne doit pas dépasser 10 Mo.',
        ]);

        $data['content'] = strip_tags($request->input('content'));

        if ($request->hasFile('file')) {
            if ($article->file_path) {
                Storage::disk('public')->delete($article->file_path);
            }
            $data['file_path'] = $request->file('file')->store('articles', 'public');
        }

        unset($data['file']);
        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        if ($article->file_path) {
            Storage::disk('public')->delete($article->file_path);
        }
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article supprimé avec succès.');
    }
}
