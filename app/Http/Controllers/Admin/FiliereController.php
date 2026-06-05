<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::latest()->get();
        return view('admin.filieres.index', compact('filieres'));
    }

    public function create()
    {
        return view('admin.filieres.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'badge'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'duration'    => ['required', 'string', 'max:100'],
            'icon'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:2048'],
        ], [
            'title.required'       => 'Le titre de la filière est obligatoire.',
            'badge.required'       => 'Le badge / niveau est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'duration.required'    => 'La durée est obligatoire.',
            'icon.image'           => 'Le fichier doit être une image (JPG, PNG, SVG…).',
            'icon.max'             => 'L\'icône ne doit pas dépasser 2 Mo.',
        ]);

        $data['icon_path'] = null;
        if ($request->hasFile('icon')) {
            $data['icon_path'] = $request->file('icon')->store('filieres', 'public');
        }

        unset($data['icon']);
        Filiere::create($data);

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière créée avec succès.');
    }

    public function edit(Filiere $filiere)
    {
        return view('admin.filieres.edit', compact('filiere'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'badge'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'duration'    => ['required', 'string', 'max:100'],
            'icon'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:2048'],
        ], [
            'title.required'       => 'Le titre de la filière est obligatoire.',
            'badge.required'       => 'Le badge / niveau est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'duration.required'    => 'La durée est obligatoire.',
            'icon.image'           => 'Le fichier doit être une image (JPG, PNG, SVG…).',
            'icon.max'             => 'L\'icône ne doit pas dépasser 2 Mo.',
        ]);

        if ($request->hasFile('icon')) {
            if ($filiere->icon_path) {
                Storage::disk('public')->delete($filiere->icon_path);
            }
            $data['icon_path'] = $request->file('icon')->store('filieres', 'public');
        }

        unset($data['icon']);
        $filiere->update($data);

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière mise à jour avec succès.');
    }

    public function destroy(Filiere $filiere)
    {
        if ($filiere->icon_path) {
            Storage::disk('public')->delete($filiere->icon_path);
        }
        $filiere->delete();

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière supprimée avec succès.');
    }
}
