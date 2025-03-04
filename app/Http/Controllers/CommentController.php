<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $notificationService;
    
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);
        
        // Create notification for post owner if the commenter is not the post owner
        if (Auth::id() !== $post->user_id) {
            $this->notificationService->createCommentNotification($post->user, Auth::user(), $post);
        }

        return response()->json([
            'comment' => $comment->load('user'),
            'comments_count' => $post->comments()->count()
        ]);
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['success' => true]);
    }
}
