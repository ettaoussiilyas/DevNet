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
            'type' => 'required|in:text,code,image',
            'code' => 'nullable|required_if:type,code|string',
            'image' => 'nullable|required_if:type,image|image|max:5120', // 5MB max
        ]);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->content = $validated['content'];
        $post->type = $validated['type'];

        if ($validated['type'] === 'code') {
            $post->code = $validated['code'];
        } elseif ($validated['type'] === 'image' && $request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image = Storage::url($path);
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
        $user = auth()->user();

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if($existingLike) {
            $existingLike->delete();
            return back()->with('success', 'You unliked this post!');
        }

        return back()->with('success', 'You liked this post!');
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
