<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        if ($post->isLikedBy($user)) {
            $post->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count()
        ]);
    }

}
