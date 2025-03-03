<nav x-data="{ open: false }" class="bg-[#1a1a2e] border-b border-[#16213e]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side -->
            <div class="flex items-center">
                <!-- Logo and Brand -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <!-- DevNet Logo -->
                        <svg class="h-8 w-8 text-[#0ea5e9]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-2xl font-bold bg-gradient-to-r from-[#0ea5e9] to-[#06b6d4] text-transparent bg-clip-text">DevNet</span>
                    </a>
                </div>

                <!-- Main Navigation -->
                <div class="hidden sm:ml-8 sm:flex sm:space-x-6">
                    
                    <x-nav-link :href="'/'" :active="request()->is('/')"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-200
                        {{ request()->is('/')
                            ? 'bg-[#0ea5e9] text-white'
                            : 'text-gray-300 hover:bg-[#16213e] hover:text-white' }}">
                        {{ __('Feed') }}
                    </x-nav-link>

                    <x-nav-link :href="route('posts.myPosts')" :active="request()->routeIs('posts.myPosts')"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-200
                        {{ request()->routeIs('posts.myPosts')
                            ? 'bg-[#0ea5e9] text-white'
                            : 'text-gray-300 hover:bg-[#16213e] hover:text-white' }}">
                        {{ __('My Posts') }}
                    </x-nav-link>

                    <x-nav-link :href="route('connections.index')" :active="request()->routeIs('connections.index')"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-200
                        {{ request()->routeIs('connections.index')
                            ? 'bg-[#0ea5e9] text-white'
                            : 'text-gray-300 hover:bg-[#16213e] hover:text-white' }}">
                        {{ __('Network') }}
                    </x-nav-link>

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-200
                        {{ request()->routeIs('dashboard')
                            ? 'bg-[#0ea5e9] text-white'
                            : 'text-gray-300 hover:bg-[#1a1a2e] hover:text-white' }}">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center">
                <!-- Search Bar -->
                <div class="hidden md:flex items-center mr-4">
                    <div class="relative">
                        <input type="text"
                               class="bg-[#16213e] text-gray-300 text-sm rounded-full w-64 px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-[#0ea5e9] focus:bg-[#1e293b]"
                               placeholder="Search DevNet...">
                        <div class="absolute left-3 top-2.5">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                @auth
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-2 text-sm font-medium text-gray-300 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                    <!-- User Avatar -->
                                    <div class="w-8 h-8 rounded-full bg-[#0ea5e9] flex items-center justify-center text-white font-semibold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="bg-[#1a1a2e] border border-[#16213e] rounded-md shadow-lg py-1">
                                    <x-dropdown-link :href="route('profile.edit')"
                                                     class="text-white hover:bg-[#16213e] hover:text-white px-4 py-2 text-sm">
                                        {{ __('Profile Settings') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                         onclick="event.preventDefault(); this.closest('form').submit();"
                                                         class="text-white hover:bg-[#16213e] hover:text-white px-4 py-2 text-sm">
                                            {{ __('Sign Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-[#16213e] focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="'/'" :active="request()->is('/')"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-[#16213e]">
                {{ __('Home') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-[#16213e]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('posts.myPosts')" :active="request()->routeIs('posts.myPosts')"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-[#16213e]">
                {{ __('My Posts') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('connections.index')" :active="request()->routeIs('connections.index')"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-[#16213e]">
                {{ __('Network') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')"
                                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-[#16213e]">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}" class="block px-3 py-2">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                           class="text-gray-300 hover:text-white hover:bg-[#16213e] block px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Sign Out') }}
                    </x-responsive-nav-link>
                </form>
            @endauth
        </div>
    </div>
</nav>
