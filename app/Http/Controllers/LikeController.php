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

        $existingLike = $post->likes()->where('liker_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            $post->likes()->create([
                'liker_id' => $user->id,
                'like' => true
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count()
        ]);
    }


}
