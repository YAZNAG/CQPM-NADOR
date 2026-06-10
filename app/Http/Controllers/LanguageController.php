<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (! in_array($locale, ['fr', 'ar'], true)) {
            abort(404);
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return back();
    }
}
