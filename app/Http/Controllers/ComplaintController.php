<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function create()
    {
        $settings = SiteSetting::all_settings();

        return view('complaints.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'phone'     => ['required', 'string', 'max:30'],
            'subject'   => ['required', 'string', 'max:255'],
            'message'   => ['required', 'string', 'min:20'],
        ], [
            'full_name.required' => 'Le nom et prénom sont obligatoires.',
            'email.required'     => 'L\'adresse e-mail est obligatoire.',
            'email.email'        => 'Veuillez saisir une adresse e-mail valide.',
            'phone.required'     => 'Le numéro de téléphone est obligatoire.',
            'subject.required'   => 'L\'objet de la réclamation est obligatoire.',
            'message.required'   => 'Le message est obligatoire.',
            'message.min'        => 'Le message doit contenir au moins 20 caractères.',
        ]);

        Complaint::create($request->only('full_name', 'email', 'phone', 'subject', 'message'));

        return redirect()->route('reclamation.form')->with(
            'success',
            'Votre réclamation a bien été envoyée. Une réponse vous sera adressée par e-mail ou éventuellement par téléphone dans les plus brefs délais.'
        );
    }

    public function index()
    {
        $complaints = Complaint::where('is_archived', false)->latest()->paginate(20);
        $archivedCount = Complaint::where('is_archived', true)->count();
        return view('admin.complaints.index', compact('complaints', 'archivedCount'));
    }

    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    public function archive(Complaint $complaint)
    {
        $complaint->update(['is_archived' => true]);
        return redirect()->route('admin.complaints.index')
            ->with('success', 'La réclamation a été archivée avec succès.');
    }

    public function unarchive(Complaint $complaint)
    {
        $complaint->update(['is_archived' => false]);
        return redirect()->route('admin.complaints.archived')
            ->with('success', 'La réclamation a été restaurée dans les réclamations actives.');
    }

    public function archived()
    {
        $complaints = Complaint::where('is_archived', true)->latest()->paginate(20);
        $activeCount = Complaint::where('is_archived', false)->count();
        return view('admin.complaints.archived', compact('complaints', 'activeCount'));
    }
}
