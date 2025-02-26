<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Developer Profile') }}
            </h2>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Edit Profile
            </button>
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
                            <img src="{{ Auth::user()->avatar ?? 'https://via.placeholder.com/150' }}"
                                 alt="Profile"
                                 class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            <span class="absolute bottom-2 right-2 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></span>
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                        <p class="text-indigo-600 font-medium">Full Stack Developer</p>

                        <div class="mt-4 flex justify-center space-x-3">
                            <button class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                <span>Connect</span>
                            </button>
                            <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                Message
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-4 border-t border-gray-200 pt-6">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">{{ Auth::user()->connections_count ?? 0 }}</span>
                            <span class="text-sm text-gray-500">Connections</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">{{ Auth::user()->posts_count ?? 0 }}</span>
                            <span class="text-sm text-gray-500">Posts</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">0</span>
                            <span class="text-sm text-gray-500">Projects</span>
                        </div>
                    </div>
                </div>

                <!-- Skills Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Technical Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['PHP', 'JavaScript', 'Laravel', 'Vue.js', 'MySQL', 'Docker', 'AWS'] as $skill)
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-sm font-medium">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Projects -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Projects</h3>
                        <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">View all</a>
                    </div>
                    <div class="space-y-6">
                        @foreach(range(1, 3) as $project)
                            <div class="flex items-start space-x-4 p-4 rounded-lg border border-gray-200 hover:border-indigo-200 transition">
                                <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">DevNet</h4>
                                    <p class="mt-1 text-sm text-gray-500">A social network for developers built with Laravel and Vue.js</p>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <span class="flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            0
                                        </span>
                                        <span class="flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            0
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                        <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">View all</a>
                    </div>
                    <div class="space-y-6">
                        @foreach(range(1, 3) as $activity)
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="">
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-800">
                                        <span class="font-medium">You</span> updated your profile picture
                                    </p>
                                    <span class="text-sm text-gray-500">2 hours ago</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
