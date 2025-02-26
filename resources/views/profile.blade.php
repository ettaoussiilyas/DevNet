<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Developer Profile') }}
            </h2>
            @if($isOwnProfile)
                <a href="{{ route('profile.edit') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Edit Profile
                </a>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <img src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://via.placeholder.com/150' }}"
                                 alt="Profile"
                                 class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $user->biography }}</p>

                        @if(!$isOwnProfile)
                            <div class="mt-4 flex justify-center space-x-3">
                                <form action="{{ route('profile.connect', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-2 px-4 py-2 {{ $isConnected ? 'bg-gray-600' : 'bg-indigo-600' }} text-white rounded-lg hover:opacity-90 transition">
                                        <span>{{ $isConnected ? 'Disconnect' : 'Connect' }}</span>
                                    </button>
                                </form>
                                <a href="{{ route('messages.create', $user) }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    Message
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-4 border-t border-gray-200 pt-6">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">{{ $stats['connections_count'] }}</span>
                            <span class="text-sm text-gray-500">Connections</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">{{ $stats['posts_count'] }}</span>
                            <span class="text-sm text-gray-500">Posts</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">{{ $stats['projects_count'] }}</span>
                            <span class="text-sm text-gray-500">Projects</span>
                        </div>
                    </div>
                </div>

                <!-- Skills Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Technical Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->skillsArray as $skill)
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-sm font-medium">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Add your right column content here -->
        </div>
    </div>
</x-app-layout>
