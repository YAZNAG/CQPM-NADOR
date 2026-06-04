<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        'title',
        'file_path',
    ];

    public function getPublicUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}
