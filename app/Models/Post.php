<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'type',
        'images_url',
        'video_url'
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): hasMany
    {
        return $this->hasMany(Like::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(HashTag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function isLikedByUser(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->likes()
            ->where('liker_id', $user->id)
            ->where('like', true)
            ->exists();
    }
}
