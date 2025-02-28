<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'images_url',
        'video_url',
        'type'
    ];

    protected $withCount = ['likes', 'comments'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }


    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('liker_id', $user->id)->exists();
    }

    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(HashTag::class, 'post_hashtag');
    }
}
