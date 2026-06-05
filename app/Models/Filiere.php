<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Filiere extends Model
{
    protected $fillable = [
        'title',
        'badge',
        'description',
        'duration',
        'icon_path',
    ];

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon_path ? Storage::url($this->icon_path) : null;
    }
}
