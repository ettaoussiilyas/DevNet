<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Profile Section -->
                <div class="lg:col-span-3">
                    <aside class="bg-white rounded-xl shadow p-6">
                        <div class="relative">
                            <div class="w-full h-24 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-t-lg"></div>
                            <div class="absolute top-12 left-6">
                                <img src="{{ auth()->user()->avatar }}" alt="Profile Picture"
                                     class="w-20 h-20 rounded-full border-4 border-white">
                            </div>
                        </div>
                        <div class="mt-16 text-center">
                            <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
                            <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                        </div>
                        <ul class="mt-6 space-y-4">
                            <li>
                                <a href="{{ route('profile') }}" class="block text-center text-blue-600 font-semibold">
                                    My Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('posts.my') }}" class="block text-center text-gray-600 hover:text-blue-600">
                                    My Posts
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="text-center">
                                    @csrf
                                    <button class="text-red-600 hover:underline">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </aside>
                </div>

                <!-- Post Feed -->
                <div class="lg:col-span-6 space-y-6">

                    <!-- Create Post -->
                    <section class="bg-white rounded-xl shadow p-6">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <textarea name="content" rows="3"
                                      class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-500"
                                      placeholder="What's on your mind?"></textarea>
                            <div class="mt-4 flex justify-between items-center">
                                <label class="cursor-pointer flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400"
                                         viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828a2 2 0 000-2.828l-4.828-4.828a2 2 0 00-2.828 2.828L15.172 7z" />
                                    </svg>
                                    <span>Add Image</span>
                                    <input type="file" name="image" class="hidden">
                                </label>
                                <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                                    Post
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- Posts -->
                    @foreach($posts as $post)
                        <article class="bg-white rounded-xl shadow p-6">
                            <!-- Post Header -->
                            <div class="flex items-center">
                                <img src="{{ $post->user->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full">
                                <div class="ml-3">
                                    <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="mt-4">
                                <p class="text-gray-800">{{ $post->content }}</p>
                                @if($post->images_url)
                                    <img src="{{ $post->images_url }}" alt="Post Image" class="mt-4 rounded-lg max-h-96 w-full object-cover">
                                @endif
                            </div>

                            <!-- Post Actions -->
                            <div class="mt-4 flex items-center space-x-4">
                                <button class="flex items-center like-button {{ $post->isLikedBy(auth()->user()) ? 'text-blue-600' : 'text-green-600' }}"
                                        data-post-id="{{ $post->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    <span class="ml-2 like-count">{{ $post->likes()->count() }}</span>
                                </button>

                                <button class="flex items-center comment-button" data-post-id="{{ $post->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    <span class="ml-2">{{ $post->comments()->count() }}</span>
                                </button>
                            </div>

                            <!-- Comments Section -->
                            <div id="comments-{{ $post->id }}" class="mt-4 hidden">
                                <form class="comment-form mb-4" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <div class="flex">
                                        <input type="text" name="content" class="flex-1 border rounded-lg p-2" placeholder="Write a comment...">
                                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg">Send</button>
                                    </div>
                                </form>

                                <div class="space-y-4 comments-container">
                                    @foreach($post->comments()->with('user')->latest()->get() as $comment)
                                        <div class="flex items-start space-x-3">
                                            <img src="{{ $comment->user->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full">
                                            <div class="flex-1 bg-gray-50 rounded-lg p-3">
                                                <p class="font-semibold">{{ $comment->user->name }}</p>
                                                <p class="text-gray-700">{{ $comment->content }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
