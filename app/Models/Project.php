<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'name',
        'descreption',
        'technologies',
        'user_id'
    ];

    protected $casts = [
        'technologies' => 'array'  // Cast technologies to array
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
