<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'filiere_id',
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
        'observation',
    ];

    protected $casts = [
        'date_naissance'      => 'date',
        'declaration_honneur' => 'boolean',
    ];

    public const STATUSES = ['En attente', 'Incomplet', 'Validé', 'Rejeté'];

    public function filiere(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function uploadedDocuments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Validé'    => 'green',
            'Rejeté'    => 'red',
            'Incomplet' => 'orange',
            default     => 'amber',
        };
    }
}
