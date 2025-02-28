<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Sidebar - Profile Card -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-24">
                        <div class="relative">
                            <div class="h-20 bg-gradient-to-r from-blue-600 to-blue-700"></div>
                            <div class="absolute -bottom-8 left-6">
                                <img src="{{ auth()->user()->avatar }}"
                                     class="w-16 h-16 rounded-full border-4 border-white shadow-sm object-cover"
                                     alt="{{ auth()->user()->name }}">
                            </div>
                        </div>

                        <div class="pt-12 pb-4 px-6">
                            <h2 class="text-base font-semibold text-gray-800">{{ auth()->user()->name }}</h2>
                            <p class="text-sm text-gray-500 truncate">{{ auth()->user()->email }}</p>

                            <hr class="my-4">

                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Profile views</span>
                                    <span class="text-sm font-medium text-blue-600">127</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Post impressions</span>
                                    <span class="text-sm font-medium text-blue-600">{{ auth()->user()->posts()->count() * 12 }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('profile') }}"
                                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                                    <span>View full profile</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content - Post Feed -->
                <div class="lg:col-span-6 space-y-4">
                    <!-- Create Post Card -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center space-x-4" onclick="openPostModal()">
                            <img src="{{ auth()->user()->avatar }}" class="w-10 h-10 rounded-full object-cover">
                            <button class="flex-1 text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-full text-gray-500 text-sm">
                                Start a post...
                            </button>
                        </div>

                        <div class="flex items-center justify-around mt-4 pt-4 border-t">
                            <button type="button" onclick="togglePostType('image')"
                                    class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium">Photo</span>
                            </button>
                            <button type="button" onclick="togglePostType('video')"
                                    class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium">Video</span>
                            </button>
                            <button type="button" onclick="togglePostType('article')"
                                    class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>
                                </svg>
                                <span class="text-sm font-medium">Article</span>
                            </button>
                        </div>
                    </div>

                    <!-- Posts Feed -->
                    @foreach($posts as $post)
                        <div class="bg-white rounded-xl shadow-sm">
                            <div class="p-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $post->user->avatar }}" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-800">{{ $post->user->name }}</h3>
                                        <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 text-sm text-gray-600">
                                    {{ $post->content }}
                                </div>

                                @if($post->images_url)
                                    <div class="mt-4">
                                        <img src="{{ $post->images_url }}" class="rounded-lg max-h-96 w-full object-cover" alt="Post image">
                                    </div>
                                @endif

                                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center space-x-4">
                                        <span>{{ $post->likes->count() }} likes</span>
                                        <span>{{ $post->comments_count }} comments</span>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t flex items-center justify-around">
                                    <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                        <span>Like</span>
                                    </button>
                                    <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                        <span>Comment</span>
                                    </button>
                                    <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                        <span>Share</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>

                <!-- Right Sidebar - Trending Tags -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                        <h3 class="text-base font-semibold text-gray-800 mb-4">Trending Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($trendingTags as $tag)
                                <a href="{{ route('tags.show', $tag) }}"
                                   class="px-3 py-1 rounded-full text-sm bg-gray-50 text-gray-700 hover:bg-gray-100 transition">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
