<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Manage your personal information and projects</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-12 gap-6">
                <!-- Sidebar Navigation -->
                <div class="col-span-12 lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4">
                        <nav class="space-y-2">
                            <a href="#profile" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile Information
                            </a>
                            <a href="#projects" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Projects
                            </a>
                            <a href="#skills" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                Skills & Expertise
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-span-12 lg:col-span-9 space-y-6">
                    <!-- Profile Section -->
                    <section id="profile" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Profile Information</h2>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6">
                            @csrf
                            @method('patch')

                            <!-- Avatar Upload -->
                            <div class="flex flex-col items-center mb-8">
                                <div class="relative group">
                                    <div class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-indigo-500/30 dark:border-indigo-400/30 shadow-2xl">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                                <span class="text-5xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif

                                        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            <label for="avatar" class="cursor-pointer p-2 bg-white/20 rounded-full hover:bg-white/30 transition-colors">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>

                                    <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </div>
                            </div>

                            <!-- Form Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="space-y-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>

                                <!-- Email -->
                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>

                                <!-- GitHub Profile -->
                                <div class="space-y-2">
                                    <label for="gitProfile" class="block text-sm font-medium text-gray-700 dark:text-gray-300">GitHub Profile</label>
                                    <input type="url" id="gitProfile" name="gitProfile" value="{{ old('gitProfile', $user->gitProfile) }}"
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>

                                <!-- Skills -->
                                <div class="space-y-2">
                                    <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skills</label>
                                    <input type="text" id="skills" name="skills" value="{{ old('skills', $user->skills) }}"
                                           placeholder="e.g. PHP, Laravel, Vue.js"
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>

                                <!-- Biography -->
                                <div class="md:col-span-2 space-y-2">
                                    <label for="biography" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Biography</label>
                                    <textarea id="biography" name="biography" rows="4"
                                              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent dark:bg-gray-700 dark:text-white">{{ old('biography', $user->biography) }}</textarea>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="mt-6 flex justify-end">
                                <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg shadow-lg hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- Projects Section -->
                    <div id="projects" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        @include('project.edit', ['projects' => $projects])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const image = input.closest('.relative').querySelector('img') ||
                        input.closest('.relative').querySelector('div');
                    if (image.tagName === 'IMG') {
                        image.src = e.target.result;
                    } else {
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.classList.add('w-full', 'h-full', 'object-cover');
                        image.parentNode.replaceChild(newImg, image);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
