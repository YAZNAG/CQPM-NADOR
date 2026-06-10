<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\Filiere;
use App\Models\FiliereRequiredDocument;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function create(Request $request)
    {
        $settings   = SiteSetting::all_settings();
        $filieres   = Filiere::where('is_active', true)->orderBy('position')->get();
        $selectedFiliere = null;

        if ($request->filled('filiere')) {
            $selectedFiliere = Filiere::where('slug', $request->filiere)
                ->where('is_active', true)
                ->with('requiredDocuments')
                ->first();
        }

        return view('candidature.form', compact('settings', 'filieres', 'selectedFiliere'));
    }

    public function store(Request $request)
    {
        // Base validation
        $baseRules = [
            'filiere_id'          => ['nullable', 'exists:filieres,id'],
            'type_formation'      => ['required', 'string', 'max:255'],
            'nom'                 => ['required', 'string', 'max:100'],
            'prenom'              => ['required', 'string', 'max:100'],
            'cin'                 => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9]+$/'],
            'section_candidature' => ['required', 'string', 'max:255'],
            'genre'               => ['required', 'in:Masculin,Féminin'],
            'email'               => ['required', 'email', 'max:255'],
            'telephone'           => ['required', 'string', 'max:20', 'regex:/^[0-9\+\s\-]+$/'],
            'lieu_naissance'      => ['required', 'string', 'max:150'],
            'date_naissance'      => ['required', 'date', 'before:-16 years'],
            'niveau_scolaire'     => ['required', 'string', 'max:100'],
            'region'              => ['required', 'string', 'max:150'],
            'ville'               => ['required', 'string', 'max:150'],
            'adresse_postale'     => ['required', 'string', 'max:500'],
            'declaration_honneur' => ['required', 'accepted'],
        ];

        // Dynamic document upload rules based on filiere
        $docRules = [];
        $requiredDocs = collect();

        if ($request->filled('filiere_id')) {
            $requiredDocs = FiliereRequiredDocument::where('filiere_id', $request->filiere_id)
                ->where('is_required', true)
                ->get();

            foreach ($requiredDocs as $doc) {
                $docRules["document_{$doc->id}"] = [
                    'required',
                    'file',
                    'mimes:pdf,jpg,jpeg,png',
                    'max:5120',
                ];
            }
        }

        $messages = [
            'type_formation.required'      => 'Le type de formation est obligatoire.',
            'nom.required'                 => 'Le nom est obligatoire.',
            'prenom.required'              => 'Le prénom est obligatoire.',
            'cin.required'                 => 'Le numéro de CIN est obligatoire.',
            'cin.regex'                    => 'Le numéro de CIN ne doit contenir que des lettres et des chiffres.',
            'section_candidature.required' => 'La section de candidature est obligatoire.',
            'genre.required'               => 'Le genre est obligatoire.',
            'email.required'               => 'L\'adresse e-mail est obligatoire.',
            'email.email'                  => 'L\'adresse e-mail n\'est pas valide.',
            'telephone.required'           => 'Le numéro de téléphone est obligatoire.',
            'telephone.regex'              => 'Le numéro de téléphone n\'est pas valide.',
            'lieu_naissance.required'      => 'Le lieu de naissance est obligatoire.',
            'date_naissance.required'      => 'La date de naissance est obligatoire.',
            'date_naissance.before'        => 'Vous devez avoir au moins 16 ans.',
            'niveau_scolaire.required'     => 'Le niveau scolaire est obligatoire.',
            'region.required'              => 'La région est obligatoire.',
            'ville.required'               => 'La ville est obligatoire.',
            'adresse_postale.required'     => 'L\'adresse postale est obligatoire.',
            'declaration_honneur.required' => 'Vous devez accepter la déclaration sur l\'honneur.',
            'declaration_honneur.accepted' => 'Vous devez accepter la déclaration sur l\'honneur.',
        ];

        foreach ($requiredDocs as $doc) {
            $messages["document_{$doc->id}.required"]  = "La pièce « {$doc->title_fr} » est obligatoire.";
            $messages["document_{$doc->id}.mimes"]     = "La pièce « {$doc->title_fr} » doit être un fichier PDF, JPG ou PNG.";
            $messages["document_{$doc->id}.max"]       = "La pièce « {$doc->title_fr} » ne doit pas dépasser 5 Mo.";
        }

        $validated = $request->validate(array_merge($baseRules, $docRules), $messages);

        DB::transaction(function () use ($request, $validated, $requiredDocs) {
            $application = Application::create([
                'filiere_id'          => $validated['filiere_id'] ?? null,
                'type_formation'      => $validated['type_formation'],
                'nom'                 => strtoupper($validated['nom']),
                'prenom'              => $validated['prenom'],
                'cin'                 => strtoupper($validated['cin']),
                'section_candidature' => $validated['section_candidature'],
                'genre'               => $validated['genre'],
                'email'               => $validated['email'],
                'telephone'           => $validated['telephone'],
                'lieu_naissance'      => $validated['lieu_naissance'],
                'date_naissance'      => $validated['date_naissance'],
                'niveau_scolaire'     => $validated['niveau_scolaire'],
                'region'              => $validated['region'],
                'ville'               => $validated['ville'],
                'adresse_postale'     => $validated['adresse_postale'],
                'declaration_honneur' => true,
                'status'              => 'En attente',
            ]);

            // Store uploaded documents
            foreach ($requiredDocs as $doc) {
                $key = "document_{$doc->id}";
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    $path = $file->store("applications/{$application->id}", 'public');
                    ApplicationDocument::create([
                        'application_id'               => $application->id,
                        'filiere_required_document_id' => $doc->id,
                        'file_path'                    => $path,
                        'original_name'                => $file->getClientOriginalName(),
                        'mime_type'                    => $file->getMimeType(),
                        'size'                         => $file->getSize(),
                    ]);
                }
            }
        });

        return redirect()->route('candidature.success')
            ->with('success', 'Votre candidature a été soumise avec succès.');
    }

    public function success()
    {
        return view('candidature.success');
    }
}
