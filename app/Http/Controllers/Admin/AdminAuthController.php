<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'L\'adresse e-mail est obligatoire.',
            'email.email'       => 'L\'adresse e-mail n\'est pas valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $validEmail    = env('ADMIN_EMAIL', 'admin@cqpm-nador.ma');
        $validPassword = env('ADMIN_PASSWORD', '');

        if ($request->email === $validEmail && $request->password === $validPassword) {
            $request->session()->regenerate();
            session(['admin_authenticated' => true]);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Connexion réussie. Bienvenue dans l\'espace administrateur.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['credentials' => 'Identifiants incorrects. Veuillez réessayer.']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        $request->session()->regenerate();

        return redirect()->route('admin.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
