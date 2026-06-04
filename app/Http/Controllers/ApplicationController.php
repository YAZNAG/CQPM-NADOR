<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function create()
    {
        return view('candidature.form');
    }

    public function store(StoreApplicationRequest $request)
    {
        Application::create($request->validated());

        return redirect()->route('candidature.success')
            ->with('success', 'Votre candidature a été soumise avec succès.');
    }

    public function success()
    {
        return view('candidature.success');
    }
}
