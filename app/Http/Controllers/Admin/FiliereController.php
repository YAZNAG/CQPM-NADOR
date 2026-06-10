<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::orderBy('position')->get();
        return view('admin.filieres.index', compact('filieres'));
    }

    public function show(Filiere $filiere)
    {
        $filiere->load('requiredDocuments');
        return view('admin.filieres.show', compact('filiere'));
    }

    public function create()
    {
        return view('admin.filieres.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_fr'           => ['required', 'string', 'max:255'],
            'title_ar'           => ['nullable', 'string', 'max:255'],
            'badge'              => ['required', 'string', 'max:255'],
            'level'              => ['nullable', 'string', 'max:255'],
            'description_fr'     => ['required', 'string', 'max:3000'],
            'description_ar'     => ['nullable', 'string', 'max:3000'],
            'objectifs_fr'       => ['nullable', 'string'],
            'objectifs_ar'       => ['nullable', 'string'],
            'programme_fr'       => ['nullable', 'string'],
            'programme_ar'       => ['nullable', 'string'],
            'debouches_fr'       => ['nullable', 'string'],
            'debouches_ar'       => ['nullable', 'string'],
            'conditions_acces_fr'=> ['nullable', 'string'],
            'conditions_acces_ar'=> ['nullable', 'string'],
            'duration'           => ['required', 'string', 'max:100'],
            'position'           => ['nullable', 'integer'],
            'is_active'          => ['nullable', 'boolean'],
            'meta_title_fr'      => ['nullable', 'string', 'max:255'],
            'meta_title_ar'      => ['nullable', 'string', 'max:255'],
            'meta_description_fr'=> ['nullable', 'string'],
            'meta_description_ar'=> ['nullable', 'string'],
            'icon'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:2048'],
            'image'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $slug = Str::slug($data['title_fr']);
        $base = $slug; $i = 1;
        while (Filiere::where('slug', $slug)->exists()) { $slug = $base . '-' . $i++; }

        $data['slug']        = $slug;
        $data['title']       = $data['title_fr'];
        $data['description'] = $data['description_fr'];
        $data['is_active']   = $request->boolean('is_active', true);
        $data['icon_path']   = null;
        $data['image_path']  = null;

        if ($request->hasFile('icon')) {
            $data['icon_path'] = $request->file('icon')->store('filieres', 'public');
        }
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('filieres', 'public');
        }

        unset($data['icon'], $data['image']);
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
            'title_fr'           => ['required', 'string', 'max:255'],
            'title_ar'           => ['nullable', 'string', 'max:255'],
            'badge'              => ['required', 'string', 'max:255'],
            'level'              => ['nullable', 'string', 'max:255'],
            'description_fr'     => ['required', 'string', 'max:3000'],
            'description_ar'     => ['nullable', 'string', 'max:3000'],
            'objectifs_fr'       => ['nullable', 'string'],
            'objectifs_ar'       => ['nullable', 'string'],
            'programme_fr'       => ['nullable', 'string'],
            'programme_ar'       => ['nullable', 'string'],
            'debouches_fr'       => ['nullable', 'string'],
            'debouches_ar'       => ['nullable', 'string'],
            'conditions_acces_fr'=> ['nullable', 'string'],
            'conditions_acces_ar'=> ['nullable', 'string'],
            'duration'           => ['required', 'string', 'max:100'],
            'position'           => ['nullable', 'integer'],
            'is_active'          => ['nullable', 'boolean'],
            'meta_title_fr'      => ['nullable', 'string', 'max:255'],
            'meta_title_ar'      => ['nullable', 'string', 'max:255'],
            'meta_description_fr'=> ['nullable', 'string'],
            'meta_description_ar'=> ['nullable', 'string'],
            'icon'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:2048'],
            'image'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data['title']       = $data['title_fr'];
        $data['description'] = $data['description_fr'];
        $data['is_active']   = $request->boolean('is_active', true);

        if ($request->hasFile('icon')) {
            if ($filiere->icon_path) Storage::disk('public')->delete($filiere->icon_path);
            $data['icon_path'] = $request->file('icon')->store('filieres', 'public');
        }
        if ($request->hasFile('image')) {
            if ($filiere->image_path) Storage::disk('public')->delete($filiere->image_path);
            $data['image_path'] = $request->file('image')->store('filieres', 'public');
        }

        unset($data['icon'], $data['image']);
        $filiere->update($data);

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière mise à jour avec succès.');
    }

    public function destroy(Filiere $filiere)
    {
        if ($filiere->icon_path)  Storage::disk('public')->delete($filiere->icon_path);
        if ($filiere->image_path) Storage::disk('public')->delete($filiere->image_path);
        $filiere->delete();

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Filière supprimée avec succès.');
    }
}
