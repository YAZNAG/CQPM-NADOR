<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FiliereRequiredDocument extends Model
{
    protected $fillable = [
        'filiere_id', 'title_fr', 'title_ar',
        'description_fr', 'description_ar',
        'is_required', 'file_type', 'position',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function applicationDocuments(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function getLocalizedTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'ar' ? $this->title_ar : $this->title_fr) ?: $this->title_fr ?? '';
    }
}
