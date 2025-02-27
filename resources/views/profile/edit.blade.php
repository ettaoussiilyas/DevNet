<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('patch')

                        <!-- Profile Photo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Profile Photo
                            </label>
                            <div class="mt-2 flex items-center space-x-4">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-2xl">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <input type="file" name="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div>
                            <x-input-label for="name" value="Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Professional Information -->
                        <div>
                            <x-input-label for="biography" value="About" />
                            <textarea id="biography" name="biography" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('biography', $user->biography) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('biography')" />
                        </div>

                        <div>
                            <x-input-label for="skills" value="Skills (comma separated)" />
                            <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', $user->skills)" placeholder="PHP, Laravel, JavaScript, Vue.js" />
                            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                        </div>

                        <div>
                            <x-input-label for="gitProfile" value="GitHub Profile URL" />
                            <x-text-input id="gitProfile" name="gitProfile" type="url" class="mt-1 block w-full" :value="old('gitProfile', $user->gitProfile)" placeholder="https://github.com/yourusername" />
                            <x-input-error class="mt-2" :messages="$errors->get('gitProfile')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Save Changes</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
