<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\HashTag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['user', 'tags', 'likes', 'comments.user'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        $trendingTags = HashTag::select('hash_tags.*')
            ->join('post_tags', 'hash_tags.id', '=', 'post_tags.tag_id')
            ->join('posts', 'posts.id', '=', 'post_tags.post_id')
            ->where('posts.created_at', '>=', now()->subDays(7))
            ->groupBy('hash_tags.id', 'hash_tags.name', 'hash_tags.created_at', 'hash_tags.updated_at')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();

        return view('home', compact('posts', 'trendingTags'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
            'image' => 'nullable|image|max:5120', // 5MB max
            'tags' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $post = new Post([
                'content' => $validated['content'],
                'user_id' => auth()->id(),
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('posts', 'public');
                $post->images_url = Storage::url($path);
            }

            $post->save();

            // Handle tags
            if (!empty($validated['tags'])) {
                $tagNames = collect(explode(',', $validated['tags']))
                    ->map(fn($tag) => trim($tag))
                    ->filter();

                $tags = $tagNames->map(function ($tagName) {
                    return HashTag::firstOrCreate(['name' => $tagName]);
                });

                $post->tags()->attach($tags->pluck('id'));
            }

            DB::commit();
            return response()->json(['message' => 'Post created successfully', 'post' => $post]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create post'], 500);
        }
    }

    public function like(Post $post): JsonResponse
    {
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likesCount' => $post->likes()->count(),
        ]);
    }

    public function userPosts(): View
    {
        $posts = Post::with(['user', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.posts', compact('posts'));
    }
}
