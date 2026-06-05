<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
    }

    public function messages(): array
    {
        return [
            'type_formation.required'      => 'Le type de formation est obligatoire.',
            'nom.required'                 => 'Le nom est obligatoire.',
            'prenom.required'              => 'Le prénom est obligatoire.',
            'cin.required'                 => 'Le numéro de CIN est obligatoire.',
            'cin.regex'                    => 'Le numéro de CIN ne doit contenir que des lettres et des chiffres.',
            'section_candidature.required' => 'La section de candidature est obligatoire.',
            'genre.required'               => 'Le genre est obligatoire.',
            'genre.in'                     => 'Veuillez sélectionner un genre valide.',
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
    }
}
