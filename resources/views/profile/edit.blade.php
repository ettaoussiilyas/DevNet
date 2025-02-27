<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('patch')

                        <!-- Profile Photo Section -->
                        <div class="flex flex-col items-center space-y-4">
                            <div class="relative group">
                                <div class="relative w-32 h-32 rounded-full overflow-hidden border-4 border-white dark:border-gray-700 shadow-lg">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}"
                                             alt="{{ $user->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                                            <span class="text-4xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif

                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <label for="avatar" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </label>
                                    </div>
                                </div>

                                @if($user->avatar)
                                    <!-- Delete Button -->
                                    <button type="button"
                                            onclick="document.getElementById('remove_avatar').submit()"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-2 shadow-lg hover:bg-red-600 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <input type="file"
                                   name="avatar"
                                   id="avatar"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewImage(this)">

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Click the image to update your profile photo
                            </p>
                            @error('avatar')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="space-y-2">
                            <x-input-label for="name" value="Name" />
                            <x-text-input id="name"
                                          name="name"
                                          type="text"
                                          class="mt-1 block w-full"
                                          :value="old('name', $user->name)"
                                          required
                                          autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email"
                                          name="email"
                                          type="email"
                                          class="mt-1 block w-full"
                                          :value="old('email', $user->email)"
                                          required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Biography -->
                        <div class="space-y-2">
                            <x-input-label for="biography" value="About Me" />
                            <textarea id="biography"
                                      name="biography"
                                      rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            >{{ old('biography', $user->biography) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('biography')" />
                        </div>

                        <!-- Skills -->
                        <div class="space-y-2">
                            <x-input-label for="skills" value="Skills" />
                            <x-text-input id="skills"
                                          name="skills"
                                          type="text"
                                          class="mt-1 block w-full"
                                          :value="old('skills', $user->skills)"
                                          placeholder="PHP, Laravel, JavaScript, Vue.js" />
                            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                        </div>

                        <!-- GitHub Profile -->
                        <div class="space-y-2">
                            <x-input-label for="gitProfile" value="GitHub Profile" />
                            <x-text-input id="gitProfile"
                                          name="gitProfile"
                                          type="url"
                                          class="mt-1 block w-full"
                                          :value="old('gitProfile', $user->gitProfile)"
                                          placeholder="https://github.com/username" />
                            <x-input-error class="mt-2" :messages="$errors->get('gitProfile')" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit"
                                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg
                                           hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-2
                                           focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                Save Changes
                            </button>

                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-green-600 dark:text-green-400">
                                    ✓ Saved successfully
                                </p>
                            @endif
                        </div>
                    </form>

                    <!-- Separate Avatar Deletion Form -->
                    <form id="remove_avatar" method="POST" action="{{ route('profile.avatar.delete') }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const container = input.closest('.relative').querySelector('img, div');
                    if (container.tagName === 'IMG') {
                        container.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-full', 'h-full', 'object-cover');
                        container.parentNode.replaceChild(img, container);
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
