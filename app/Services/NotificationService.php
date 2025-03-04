<?php

namespace App\Services;

use App\Events\NewNotification;
use App\Models\Notification;
use App\Models\User;
use App\Models\Post;

class NotificationService
{
    public function createNotification(User $user, User $sender, string $type, string $message, Post $post = null)
    {
        $notification = new Notification();
        $notification->user_id = $user->id;
        $notification->sender_id = $sender->id;
        $notification->type = $type;
        $notification->message = $message;
        $notification->read = false;
        
        if ($post) {
            $notification->post_id = $post->id;
        }
        
        $notification->save();
        
        // Broadcast the notification
        event(new NewNotification($notification));
        
        return $notification;
    }
    
    public function createLikeNotification(User $user, User $sender, Post $post)
    {
        $message = $sender->name . ' liked your post';
        return $this->createNotification($user, $sender, 'like', $message, $post);
    }
    
    public function createCommentNotification(User $user, User $sender, Post $post)
    {
        $message = $sender->name . ' commented on your post';
        return $this->createNotification($user, $sender, 'comment', $message, $post);
    }
    
    public function createConnectionNotification(User $user, User $sender)
    {
        $message = $sender->name . ' sent you a connection request';
        return $this->createNotification($user, $sender, 'connection', $message);
    }
}