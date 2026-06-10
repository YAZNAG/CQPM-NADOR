<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\SiteSetting;

class FilierePublicController extends Controller
{
    public function formations()
    {
        $filieres = Filiere::where('is_active', true)->orderBy('position')->get();
        $settings = SiteSetting::all_settings();
        return view('formations.index', compact('filieres', 'settings'));
    }

    public function filieres()
    {
        $filieres = Filiere::where('is_active', true)->orderBy('position')->get();
        $settings = SiteSetting::all_settings();
        return view('formations.filieres', compact('filieres', 'settings'));
    }

    public function show(Filiere $filiere)
    {
        if (!$filiere->is_active) {
            abort(404);
        }
        $filiere->load('requiredDocuments');
        $settings = SiteSetting::all_settings();
        return view('formations.show', compact('filiere', 'settings'));
    }
}
