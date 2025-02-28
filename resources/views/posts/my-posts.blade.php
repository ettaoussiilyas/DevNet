<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Posts</h1>
            <button onclick="openPostModal()"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Create New Post
            </button>
        </div>

        <div class="space-y-6">
            @forelse($posts as $post)
                <!-- Use the same post card structure as in home.blade.php -->
            @empty
                <p class="text-center text-gray-500">You haven't created any posts yet.</p>
            @endforelse
        </div>

        {{ $posts->links() }}
    </div>

    <!-- Include the same post modal as in home.blade.php -->
</x-app-layout>
