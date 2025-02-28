<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $fillable = [
        'liker_id',
        'post_id',
        'like'
    ];

    protected $casts = [
        'like' => 'boolean'
    ];

    public function post():belongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'liker_id');
    }
}
