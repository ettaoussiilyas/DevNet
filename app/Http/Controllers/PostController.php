<?php

namespace App\Http\Controllers;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return view('home', compact('posts'));
    }

    public function userPosts()
    {
        $posts = Post::with(['user', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('posts.my-posts', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'type' => 'required|in:post,snippet',
            'images_url' => 'nullable|image|max:5120', // 5MB max
            'video_url' => 'nullable|url'
        ]);

        $post = new Post($validated);
        $post->user_id = auth()->id();

        if ($request->hasFile('images_url')) {
            $post->images_url = $request->file('images_url')->store('posts/images', 'public');
        }

        $post->save();

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully!');
    }

    public function like(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create([
                'user_id' => auth()->id()
            ]);
        }

        return back();
    }

    public function comment(Post $post, Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        return back();
    }
}
