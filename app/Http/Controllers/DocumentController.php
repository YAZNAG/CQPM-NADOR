<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function public()
    {
        $documents = Document::latest()->get();
        $settings  = \App\Models\SiteSetting::all_settings();
        return view('documents.index', compact('documents', 'settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file'  => ['required', 'file', 'mimes:pdf', 'max:15360'],
        ], [
            'title.required' => 'Le titre du document est obligatoire.',
            'file.required'  => 'Veuillez sélectionner un fichier PDF.',
            'file.mimes'     => 'Seuls les fichiers PDF sont acceptés.',
            'file.max'       => 'Le fichier ne doit pas dépasser 15 Mo.',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'title'     => $request->input('title'),
            'file_path' => $path,
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document téléversé avec succès.');
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document supprimé avec succès.');
    }
}
