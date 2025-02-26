<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600">
                DevNet
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-8">
                @auth
                    {{-- Main Navigation Links --}}
                    <div class="flex items-center gap-6">
                        <a href="{{ url('/') }}"
                           class="text-gray-600 hover:text-indigo-600 transition-colors {{ request()->is('/') ? 'text-indigo-600 font-medium' : '' }}">
                            Feed
                        </a>
                        <a href="{{ route('profile') }}"
                           class="text-gray-600 hover:text-indigo-600 transition-colors {{ request()->routeIs('profile') ? 'text-indigo-600 font-medium' : '' }}">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-indigo-600 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>

                    {{-- Search Bar --}}
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input type="text"
                               class="w-60 pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                            Join DevNet
                        </a>
                    </div>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <button class="md:hidden">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </nav>

        {{-- Mobile Menu --}}
        <div class="hidden md:hidden py-4">
            @auth
                <div class="space-y-3">
                    <a href="{{ url('/') }}" class="block py-2 text-gray-600 hover:text-indigo-600">Feed</a>
                    <a href="{{ route('profile') }}" class="block py-2 text-gray-600 hover:text-indigo-600">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 text-gray-600 hover:text-indigo-600">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="space-y-3">
                    <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-indigo-600">Log in</a>
                    <a href="{{ route('register') }}" class="block py-2 text-gray-600 hover:text-indigo-600">Join DevNet</a>
                </div>
            @endauth
        </div>
    </div>
</header>
