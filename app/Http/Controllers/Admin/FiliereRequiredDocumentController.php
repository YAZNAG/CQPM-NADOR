<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\FiliereRequiredDocument;
use Illuminate\Http\Request;

class FiliereRequiredDocumentController extends Controller
{
    public function index(Filiere $filiere)
    {
        $filiere->load('requiredDocuments');
        return view('admin.filieres.show', compact('filiere'));
    }

    public function store(Request $request, Filiere $filiere)
    {
        $data = $request->validate([
            'title_fr'      => ['required', 'string', 'max:255'],
            'title_ar'      => ['nullable', 'string', 'max:255'],
            'description_fr'=> ['nullable', 'string'],
            'description_ar'=> ['nullable', 'string'],
            'is_required'   => ['nullable', 'boolean'],
            'file_type'     => ['nullable', 'string', 'max:100'],
            'position'      => ['nullable', 'integer'],
        ]);

        $data['filiere_id']  = $filiere->id;
        $data['is_required'] = $request->boolean('is_required', true);
        $data['position']    = $data['position'] ?? ($filiere->requiredDocuments()->count() + 1);

        FiliereRequiredDocument::create($data);

        return back()->with('success', 'Pièce ajoutée avec succès.');
    }

    public function update(Request $request, Filiere $filiere, FiliereRequiredDocument $document)
    {
        $data = $request->validate([
            'title_fr'      => ['required', 'string', 'max:255'],
            'title_ar'      => ['nullable', 'string', 'max:255'],
            'description_fr'=> ['nullable', 'string'],
            'description_ar'=> ['nullable', 'string'],
            'is_required'   => ['nullable', 'boolean'],
            'file_type'     => ['nullable', 'string', 'max:100'],
            'position'      => ['nullable', 'integer'],
        ]);

        $data['is_required'] = $request->boolean('is_required', true);
        $document->update($data);

        return back()->with('success', 'Pièce mise à jour.');
    }

    public function destroy(Filiere $filiere, FiliereRequiredDocument $document)
    {
        $document->delete();
        return back()->with('success', 'Pièce supprimée.');
    }
}
