<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{

    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'biography',
        'avatar',
        'skills',
        'gitProfile',
    ];

    protected $hidden = ['password'];

    // Posts created by user
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // UserController's connections
    public function connections()
    {
        return $this->belongsToMany(User::class, 'connections', 'sender_id', 'receiver_id')
            ->wherePivot('status', 'accepted');
    }


    // Messages sent by user
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messages received by user
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // UserController's notifications
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    // Get skills as array
//    public function getSkillsArrayAttribute(): array
//    {
//        return $this->skills ? explode(',', $this->skills) : [];
//    }
    public function getSkillsArrayAttribute(): array
    {
        return $this->skills ? array_map('trim', explode(',', $this->skills)) : [];
    }


    public function pendingConnections()
    {
        return $this->belongsToMany(User::class, 'connections', 'sender_id', 'receiver_id')
            ->wherePivot('status', 'pending');
    }

    public function receivedConnections()
    {
        return $this->belongsToMany(User::class, 'connections', 'receiver_id', 'sender_id')
            ->wherePivot('status', 'pending');
    }

    public function projects(): hasMany
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'liker_id');
    }

    /**
     * Get the user's connections
     */





}
