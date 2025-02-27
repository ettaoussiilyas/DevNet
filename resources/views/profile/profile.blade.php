<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center space-x-4">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-2xl">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                        @if(!$isOwnProfile)
                            <form action="{{ route('profile.connect', $user) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    {{ $isConnected ? 'Connected' : 'Connect' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Statistics</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <span class="block text-2xl font-bold">{{ $stats['connections_count'] }}</span>
                        <span class="text-gray-600 dark:text-gray-400">Connections</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl font-bold">{{ $stats['posts_count'] }}</span>
                        <span class="text-gray-600 dark:text-gray-400">Posts</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl font-bold">{{ $stats['projects_count'] }}</span>
                        <span class="text-gray-600 dark:text-gray-400">Projects</span>
                    </div>
                </div>
            </div>

            <!-- Skills & Bio -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->skillsArray as $skill)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-4">About</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->biography ?? 'No biography available.' }}</p>
                </div>
            </div>

            <!-- GitHub Profile -->
            @if($user->gitProfile)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">GitHub Profile</h3>
                    <a href="{{ $user->gitProfile }}" target="_blank" class="text-blue-500 hover:underline">
                        {{ $user->gitProfile }}
                    </a>
                </div>
            @endif

            @if($isOwnProfile)
                <div class="flex justify-end">
                    <a href="{{ route('profile.edit') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Edit Profile
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
