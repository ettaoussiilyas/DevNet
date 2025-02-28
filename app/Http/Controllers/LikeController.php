<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function toggle(Post $post): RedirectResponse
    {
        $userId = auth()->id();

        $like = Like::where('liker_id', $userId)
            ->where('post_id', $post->id)
            ->first();

        if ($like) {
            $like->delete();
            $message = 'Post unliked successfully';
        } else {
            Like::create([
                'liker_id' => $userId,
                'post_id' => $post->id,
                'like' => true
            ]);
            $message = 'Post liked successfully';
        }

        return back()->with('success', $message);
    }
}
