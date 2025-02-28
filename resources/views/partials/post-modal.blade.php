<div id="post-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden" style="z-index: 50;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="border-b px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Create Post</h3>
                <button onclick="closePostModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="space-y-4">
                    <!-- Post Type Tabs -->
                    <div class="flex space-x-4 border-b">
                        <button type="button"
                                onclick="switchTab('text')"
                                id="text-tab"
                                class="px-4 py-2 border-b-2 border-blue-500 text-blue-600">
                            Text Post
                        </button>
                        <button type="button"
                                onclick="switchTab('code')"
                                id="code-tab"
                                class="px-4 py-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                            Code Snippet
                        </button>
                        <button type="button"
                                onclick="switchTab('image')"
                                id="image-tab"
                                class="px-4 py-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                            Image Post
                        </button>
                    </div>

                    <!-- Text Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea id="content"
                                  name="content"
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="What's on your mind?"></textarea>
                    </div>

                    <!-- Code Snippet (initially hidden) -->
                    <div id="code-section" class="hidden">
                        <label for="code" class="block text-sm font-medium text-gray-700">Code Snippet</label>
                        <textarea id="code"
                                  name="code"
                                  rows="6"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono"
                                  placeholder="Paste your code here..."></textarea>
                    </div>

                    <!-- Image Upload (initially hidden) -->
                    <div id="image-section" class="hidden">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file"
                               id="image"
                               name="image"
                               accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100">
                    </div>

                    <input type="hidden" name="type" id="post-type" value="text">
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end">
                    <button type="button"
                            onclick="closePostModal()"
                            class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openPostModal() {
        document.getElementById('post-modal').classList.remove('hidden');
    }

    function closePostModal() {
        document.getElementById('post-modal').classList.add('hidden');
    }

    function switchTab(type) {
        // Update hidden input
        document.getElementById('post-type').value = type;

        // Reset all tabs
        document.getElementById('text-tab').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('code-tab').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('image-tab').classList.remove('border-blue-500', 'text-blue-600');

        // Reset all sections
        document.getElementById('code-section').classList.add('hidden');
        document.getElementById('image-section').classList.add('hidden');

        // Update active tab
        document.getElementById(`${type}-tab`).classList.add('border-blue-500', 'text-blue-600');

        // Show relevant section
        if (type === 'code') {
            document.getElementById('code-section').classList.remove('hidden');
        } else if (type === 'image') {
            document.getElementById('image-section').classList.remove('hidden');
        }
    }

    // Close modal when clicking outside
    document.getElementById('post-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePostModal();
        }
    });
</script>
