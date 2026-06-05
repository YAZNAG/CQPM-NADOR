<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Document;
use App\Models\SiteSetting;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $tab = $request->get('tab', 'en_attente');

        $statusMap = [
            'en_attente' => 'En attente',
            'accepte'    => 'Validé',
            'refuse'     => 'Rejeté',
        ];

        $statusFilter = $statusMap[$tab] ?? 'En attente';
        $tab = array_key_exists($tab, $statusMap) ? $tab : 'en_attente';

        $query = Application::where('status', $statusFilter)->latest();

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

        $applications = $query->paginate(15)->withQueryString();
        $types        = Application::distinct()->pluck('type_formation')->sort()->values();

        $counts = [
            'en_attente' => Application::where('status', 'En attente')->count(),
            'accepte'    => Application::where('status', 'Validé')->count(),
            'refuse'     => Application::where('status', 'Rejeté')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'types', 'tab', 'counts'));
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

        $tabMap = [
            'En attente' => 'en_attente',
            'Validé'     => 'accepte',
            'Rejeté'     => 'refuse',
        ];
        $tab = $tabMap[$request->status] ?? 'en_attente';

        return redirect()->route('admin.applications.index', ['tab' => $tab])
            ->with('success', "Statut mis à jour : {$request->status}.");
    }

    public function destroyApplication(Application $application)
    {
        $application->delete();

        return redirect()->route('admin.applications.index')
            ->with('success', 'Candidature supprimée avec succès.');
    }

    public function exportAdmisPdf()
    {
        $accepted = Application::where('status', 'Validé')
            ->orderBy('type_formation')
            ->orderBy('nom')
            ->get()
            ->groupBy('type_formation');

        $pdf = Pdf::loadView('admin.applications.pdf', compact('accepted'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'DejaVu Sans', 'isHtml5ParserEnabled' => true]);

        return $pdf->download('liste-admis-' . date('Y-m-d') . '.pdf');
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
            'annonce_titre'  => ['required', 'string', 'max:255'],
            'annonce_texte'  => ['required', 'string', 'max:1000'],
            'annonce_active' => ['nullable'],
        ]);

        SiteSetting::set('annonce_titre',  $request->annonce_titre);
        SiteSetting::set('annonce_texte',  $request->annonce_texte);
        SiteSetting::set('annonce_active', $request->has('annonce_active') ? '1' : '0');

        return back()->with('success', 'Paramètres du site mis à jour.');
    }
}
