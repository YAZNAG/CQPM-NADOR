<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'subject',
        'message',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];
}
