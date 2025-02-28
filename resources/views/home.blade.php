<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Create Post Button -->
        <button onclick="openPostModal()"
                class="w-full bg-white rounded-lg shadow p-4 text-left text-gray-500 hover:bg-gray-50 mb-6">
            What's on your mind?
        </button>

        <!-- Add this inside the modal header 3alam-->
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold">Create Post</h2>
            <button type="button" onclick="closePostModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Posts Feed -->
        <div class="space-y-6">
            @foreach($posts as $post)
                <div class="bg-white rounded-lg shadow">
                    <div class="p-4">
                        <!-- Post Header -->
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="{{ $post->user->avatar }}" class="w-10 h-10 rounded-full">
                            <div>
                                <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <!-- Post Content -->
                        @if($post->type === 'snippet')
                            <div class="mb-4">{{ $post->content }}</div>
                            <pre class="bg-gray-800 text-white p-4 rounded"><code>{{ $post->code }}</code></pre>
                        @else
                            <p class="mb-4">{{ $post->content }}</p>
                            @if($post->image)
                                <img src="{{ $post->image }}" class="rounded-lg max-h-96 w-full object-cover">
                            @endif
                        @endif

                        <!-- Post Actions -->
                        <div class="flex items-center space-x-4 mt-4 pt-4 border-t">
                            <form action="{{ route('posts.like', $post) }}" method="POST" class="inline like-form">
                                @csrf
                                <button type="submit"
                                        class="text-gray-500 hover:text-blue-500 {{ $post->likes()->where('liker_id', auth()->id())->exists() ? 'text-blue-500' : '' }}">
                                    Like ({{ $post->likes()->count() }})
                                </button>
                            </form>
                            <button onclick="toggleComments('{{ $post->id }}')" class="text-gray-500 hover:text-blue-500">
                                Comment ({{ $post->comments_count }})
                            </button>
                        </div>


                        <div id="comments-{{ $post->id }}" class="hidden mt-4 border-t pt-4">
                            <form action="{{ route('posts.comment', $post) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="flex gap-2">
                                    <textarea name="content"
                                        class="flex-1 rounded-lg border-gray-300"
                                        placeholder="Write a comment...">
                                        {{ old('content') }}
                                    </textarea>
                                    <button type="submit"
                                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                        Post
                                    </button>
                                </div>
                            </form>

                            <div class="space-y-4">
                                @foreach($post->comments as $comment)
                                    <div class="flex gap-3">
                                        <img src="{{ $comment->user->avatar }}" class="w-8 h-8 rounded-full">
                                        <div class="flex-1">
                                            <p class="font-semibold">{{ $comment->user->name }}</p>
                                            <p class="text-gray-600">{{ $comment->content }}</p>
                                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Create Post Modal -->
    <div id="postModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg max-w-xl w-full mx-4">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold">Create Post</h2>
            </div>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4">
                    <!-- Post Type Selection -->
                    <div class="mb-4">
                        <select name="type" class="w-full rounded-lg" onchange="togglePostType(this.value)">
                            <option value="normal">Normal Post</option>
                            <option value="snippet">Code Snippet</option>
                        </select>
                    </div>

                    <!-- Content -->
                    <textarea name="content" rows="4" class="w-full rounded-lg mb-4"
                              placeholder="What's on your mind?"></textarea>

                    <!-- Code Editor (hidden by default) -->
                    <div id="codeEditor" class="hidden">
                        <textarea name="code" rows="8" class="w-full rounded-lg mb-4 font-mono"
                                  placeholder="Paste your code here"></textarea>
                        <select name="language" class="w-full rounded-lg mb-4">
                            <option value="php">PHP</option>
                            <option value="javascript">JavaScript</option>
                            <option value="python">Python</option>
                        </select>
                    </div>

                    <!-- Image Upload -->
                    <div id="imageUpload">
                        <input type="file" name="image" accept="image/*" class="w-full">
                    </div>
                </div>
                <div class="p-4 border-t">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
