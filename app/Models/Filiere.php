<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Filiere extends Model
{
    protected $fillable = [
        'slug', 'title', 'title_fr', 'title_ar',
        'badge', 'level', 'description', 'duration',
        'description_fr', 'description_ar',
        'objectifs_fr', 'objectifs_ar',
        'programme_fr', 'programme_ar',
        'debouches_fr', 'debouches_ar',
        'conditions_acces_fr', 'conditions_acces_ar',
        'icon_path', 'image_path',
        'is_active', 'position',
        'meta_title_fr', 'meta_title_ar',
        'meta_description_fr', 'meta_description_ar',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function requiredDocuments(): HasMany
    {
        return $this->hasMany(FiliereRequiredDocument::class)->orderBy('position');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon_path ? Storage::url($this->icon_path) : null;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    public function getLocalizedTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'ar' ? $this->title_ar : $this->title_fr) ?: $this->title ?? '';
    }

    public function getLocalizedDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'ar' ? $this->description_ar : $this->description_fr) ?: $this->description;
    }

    public function getLocalizedConditionsAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->conditions_acces_ar : $this->conditions_acces_fr;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
