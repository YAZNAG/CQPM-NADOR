<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'type_formation',
        'nom',
        'prenom',
        'cin',
        'section_candidature',
        'genre',
        'email',
        'telephone',
        'lieu_naissance',
        'date_naissance',
        'niveau_scolaire',
        'region',
        'ville',
        'adresse_postale',
        'declaration_honneur',
        'status',
    ];

    protected $casts = [
        'date_naissance'      => 'date',
        'declaration_honneur' => 'boolean',
    ];

    public const STATUSES = ['En attente', 'Validé', 'Rejeté'];

    public function getFullNameAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Validé'  => 'green',
            'Rejeté'  => 'red',
            default   => 'amber',
        };
    }
}
