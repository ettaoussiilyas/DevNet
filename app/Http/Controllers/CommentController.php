<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function store(Post $post, Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'count' => $post->comments()->count()
        ]);
    }

}
