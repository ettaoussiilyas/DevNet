<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex gap-8">
            <!-- Left Sidebar - Profile Card -->
            <div class="w-1/4">
                <div class="bg-white rounded-lg shadow sticky top-8">
                    <!-- Cover Image -->
                    <div class="h-24 bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-lg"></div>

                    <!-- Profile Section -->
                    <div class="px-4 pb-4 relative">
                        <!-- Avatar -->
                        <div class="absolute -top-10 left-1/2 transform -translate-x-1/2">
                            <img src="{{ auth()->user()->avatar }}"
                                 class="w-20 h-20 rounded-full border-4 border-white shadow-lg">
                        </div>

                        <!-- User Info -->
                        <div class="pt-12 text-center">
                            <h2 class="font-bold text-xl">{{ auth()->user()->name }}</h2>
                            <p class="text-gray-600 text-sm">{{ auth()->user()->email }}</p>

                            <!-- Stats -->
                            <div class="mt-4 grid grid-cols-3 gap-4 border-t pt-4">
                                <div>
                                    <div class="font-bold">{{ auth()->user()->posts()->count() }}</div>
                                    <div class="text-xs text-gray-500">Posts</div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ auth()->user()->connections()->count() }}</div>
                                    <div class="text-xs text-gray-500">Connections</div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ auth()->user()->likes()->count() }}</div>
                                    <div class="text-xs text-gray-500">Likes</div>
                                </div>
                            </div>

                            <!-- Quick Links -->
                            <div class="mt-4 space-y-2">
                                <a href="{{ route('profile') }}"
                                   class="block text-sm text-blue-600 hover:text-blue-800">
                                    View Full Profile
                                </a>
                                <a href="{{ route('posts.my') }}"
                                   class="block text-sm text-blue-600 hover:text-blue-800">
                                    My Posts
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Create Post Card -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-4">
                        <button onclick="openPostModal()"
                                class="w-full bg-gray-50 rounded-lg p-4 text-left text-gray-500 hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-4">
                                <img src="{{ auth()->user()->avatar }}" class="w-10 h-10 rounded-full">
                                <span>What's on your mind?</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Posts Feed -->
                <div class="space-y-6">
                    @foreach($posts as $post)
                        <div class="bg-white rounded-lg shadow">
                            <!-- Post Header -->
                            <div class="p-4 flex items-center space-x-4">
                                <img src="{{ $post->user->avatar }}" class="w-10 h-10 rounded-full">
                                <div>
                                    <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                    <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="px-4 pb-4">
                                <p class="text-gray-800">{{ $post->content }}</p>
                                @if($post->image)
                                    <div class="mt-4">
                                        <img src="{{ Storage::url($post->image) }}"
                                             alt="Post image"
                                             class="rounded-lg max-h-96 w-full object-cover">
                                    </div>
                                @endif
                            </div>

                            <!-- Post Actions -->
                            <div class="px-4 py-3 border-t flex items-center justify-between">
                                <div class="flex space-x-4">
                                    <!-- Like Button -->
                                    <button onclick="toggleLike({{ $post->id }})"
                                            class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 like-button {{ $post->isLikedBy(auth()->user()) ? 'text-blue-600' : '' }}"
                                            data-post-id="{{ $post->id }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                        <span class="like-count" data-post-id="{{ $post->id }}">
                                            {{ $post->likes()->count() }}
                                        </span>
                                    </button>

                                    <!-- Comment Button -->
                                    <button onclick="toggleComments({{ $post->id }})"
                                            class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <span>{{ $post->comments()->count() }}</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Comments Section -->
                            <div id="comments-{{ $post->id }}" class="hidden border-t">
                                <!-- Comments List -->
                                <div class="comments-list" data-post-id="{{ $post->id }}">
                                    @foreach($post->comments as $comment)
                                        <div class="flex space-x-3 p-4 border-t">
                                            <img src="{{ $comment->user->avatar }}" class="w-8 h-8 rounded-full">
                                            <div>
                                                <p class="font-semibold">{{ $comment->user->name }}</p>
                                                <p class="text-gray-600">{{ $comment->content }}</p>
                                                <p class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Comment Form -->
                                <form class="p-4 border-t comment-form" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <textarea name="content"
                                              class="w-full rounded-lg border-gray-300 resize-none focus:border-blue-500 focus:ring focus:ring-blue-200"
                                              rows="2"
                                              placeholder="Write a comment..."></textarea>
                                    <button type="submit"
                                            class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Comment
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('partials.post-modal')

    <script>
        function toggleComments(postId) {
            const commentsSection = document.getElementById(`comments-${postId}`);
            commentsSection.classList.toggle('hidden');
        }

        function toggleLike(postId) {
            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    const likeButton = document.querySelector(`.like-button[data-post-id="${postId}"]`);
                    const likeCount = document.querySelector(`.like-count[data-post-id="${postId}"]`);

                    if (data.liked) {
                        likeButton.classList.add('text-blue-600');
                    } else {
                        likeButton.classList.remove('text-blue-600');
                    }
                    likeCount.textContent = data.count;
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const commentForms = document.querySelectorAll('.comment-form');
            commentForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const postId = this.dataset.postId;
                    const content = this.querySelector('textarea').value;

                    fetch(`/posts/${postId}/comment`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ content })
                    })
                        .then(response => response.json())
                        .then(data => {
                            const commentsList = document.querySelector(`.comments-list[data-post-id="${postId}"]`);
                            const commentHTML = `
                            <div class="flex space-x-3 p-4 border-t">
                                <img src="${data.user.avatar}" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-semibold">${data.user.name}</p>
                                    <p class="text-gray-600">${data.content}</p>
                                    <p class="text-gray-400 text-sm">Just now</p>
                                </div>
                            </div>
                        `;
                            commentsList.insertAdjacentHTML('beforeend', commentHTML);
                            this.querySelector('textarea').value = '';
                        });
                });
            });
        });
    </script>
</x-app-layout>
