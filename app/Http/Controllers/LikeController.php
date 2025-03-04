<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class LikeController extends Controller
{
    // Add this to your controller
    
    // In your controller class
    protected $notificationService;
    
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    
    // In your like method
    public function like(Post $post)
    {
        $user = Auth::user();
    
        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
        } else {
            $post->likes()->create([
                'user_id' => $user->id,
            ]);
        }
    
        // Create notification for post owner
        $this->notificationService->createLikeNotification($post->user, Auth::user(), $post);
    
        return back();
    }
}
