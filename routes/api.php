<?php

use App\Models\Filiere;
use Illuminate\Support\Facades\Route;

Route::get('/filieres/{filiere}/documents', function (Filiere $filiere) {
    return response()->json(
        $filiere->requiredDocuments()
            ->select('id', 'title_fr', 'title_ar', 'is_required', 'position')
            ->get()
    );
});
