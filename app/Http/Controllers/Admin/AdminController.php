<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Document;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalApplications  = Application::count();
        $totalDocuments     = Document::count();
        $pendingCount       = Application::where('status', 'En attente')->count();
        $validatedCount     = Application::where('status', 'Validé')->count();
        $recentApplications = Application::latest()->take(6)->get();
        $settings           = SiteSetting::all_settings();

        return view('admin.dashboard', compact(
            'totalApplications',
            'totalDocuments',
            'pendingCount',
            'validatedCount',
            'recentApplications',
            'settings'
        ));
    }

    public function applications(Request $request)
    {
        $query = Application::latest();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type_formation', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(15)->withQueryString();
        $types        = Application::distinct()->pluck('type_formation')->sort()->values();

        return view('admin.applications.index', compact('applications', 'types'));
    }

    public function showApplication(Application $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => ['required', 'in:En attente,Validé,Rejeté'],
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', "Statut mis à jour : {$request->status}.");
    }

    public function destroyApplication(Application $application)
    {
        $application->delete();

        return redirect()->route('admin.applications.index')
            ->with('success', 'Candidature supprimée avec succès.');
    }

    public function documents()
    {
        $documents = Document::latest()->paginate(20);

        return view('admin.documents.index', compact('documents'));
    }

    public function settings()
    {
        $settings = SiteSetting::all_settings();

        return view('admin.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'annonce_titre' => ['required', 'string', 'max:255'],
            'annonce_texte' => ['required', 'string', 'max:1000'],
            'annonce_active' => ['nullable'],
        ]);

        SiteSetting::set('annonce_titre',  $request->annonce_titre);
        SiteSetting::set('annonce_texte',  $request->annonce_texte);
        SiteSetting::set('annonce_active', $request->has('annonce_active') ? '1' : '0');

        return back()->with('success', 'Paramètres du site mis à jour.');
    }
}
