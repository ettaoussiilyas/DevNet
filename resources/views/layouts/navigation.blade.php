<nav x-data="{ open: false }" class="bg-[#8D77AB] border-b border-[#E1EACD]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side -->
            <div class="flex items-center">
                <!-- Logo and Brand -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <svg class="h-8 w-8 text-[#F9F6E6]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-2xl font-bold text-[#F9F6E6]">DevNet</span>
                    </a>
                </div>

                <!-- Main Navigation -->
                <div class="hidden sm:ml-8 sm:flex sm:space-x-6">
                    @foreach(['Profile' => '/profile', 'Feed' => '/', 'My Posts' => 'posts.myPosts', 'Network' => 'connections.index', 'Home' => 'dashboard'] as $label => $route)
                        <x-nav-link :href="$route === '/' || $route === '/profile' ? $route : route($route)"
                                    :active="$route === '/' ? request()->is('/') : ($route === '/profile' ? request()->is('profile') : request()->routeIs($route))"
                                    class="px-3 py-2 rounded-full text-sm font-medium transition-all duration-200
                                    {{ ($route === '/' ? request()->is('/') : ($route === '/profile' ? request()->is('profile') : request()->routeIs($route)))
                                    ? 'bg-[#BAD8B6] text-[#8D77AB]'
                                    : 'text-[#F9F6E6] hover:bg-[#E1EACD] hover:text-[#8D77AB]' }}">
                            {{ __($label) }}
                        </x-nav-link>
                    @endforeach
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center">

                <!-- Search Bar -->
                <div class="hidden md:flex items-center mr-4">
                    <div class="relative">
                        <input type="text"
                               class="bg-[#E1EACD] text-[#8D77AB] text-sm rounded-full w-64 px-4 py-2 pl-10
                                   focus:outline-none focus:ring-2 focus:ring-[#BAD8B6] focus:bg-[#F9F6E6]
                                   placeholder-[#8D77AB]/60"
                               placeholder="Search DevNet...">
                        <div class="absolute left-3 top-2.5">
                            <svg class="h-5 w-5 text-[#8D77AB]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <button class="flex items-center space-x-2 text-sm font-medium text-[#F9F6E6] hover:text-[#E1EACD] focus:outline-none transition duration-150 ease-in-out">
                                    <div class="w-8 h-8 rounded-full bg-[#BAD8B6] flex items-center justify-center text-[#8D77AB] font-semibold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>
                                    <svg class="h-4 w-4 text-[#F9F6E6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="bg-[#8D77AB] border border-[#E1EACD] rounded-md shadow-lg py-1">
                                    <x-dropdown-link :href="route('profile.edit')"
                                                     class="text-[#F9F6E6] hover:bg-[#BAD8B6] hover:text-[#8D77AB] px-4 py-2 text-sm">
                                        {{ __('Profile Settings') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                         onclick="event.preventDefault(); this.closest('form').submit();"
                                                         class="text-[#F9F6E6] hover:bg-[#BAD8B6] hover:text-[#8D77AB] px-4 py-2 text-sm">
                                            {{ __('Sign Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth

                <!-- icon of notificatio -->
                <!-- Replace the notification dropdown section with this improved version -->
                <!-- icon of notification -->
                <!-- Notification dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-[#F9F6E6] hover:text-[#E1EACD] focus:outline-none transition duration-150 ease-in-out">
                                <div class="relative">
                                    <!-- Bell Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <!-- Notification Badge -->
                                    <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs" style="display: none;">0</span>
                                </div>
                            </button>
                        </x-slot>
                
                        <x-slot name="content">
                            <div class="bg-white rounded-md shadow-lg border border-[#E1EACD] w-80">
                                <div class="flex items-center justify-between px-4 py-2 bg-[#8D77AB] text-[#F9F6E6] rounded-t-md">
                                    <h3 class="font-semibold">Notifications</h3>
                                    <button onclick="markAllAsRead()" class="text-xs hover:underline">Mark all as read</button>
                                </div>
                                <div id="notification-list" class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                                    <!-- Notifications will be loaded here -->
                                </div>
                                <div class="border-t border-gray-100 bg-gray-50 rounded-b-md">
                                    <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-center text-[#8D77AB] hover:bg-gray-100 font-medium">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Messages Icon -->
                <div class="ml-3 relative">
                    <a href="{{ route('messages.index') }}" class="flex items-center text-sm font-medium text-[#F9F6E6] hover:text-[#E1EACD] focus:outline-none transition duration-150 ease-in-out">
                        <div class="relative">
                            <!-- Message Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <!-- Message Badge -->
                            <span id="messages-badge" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs" style="display: none;">0</span>
                        </div>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-[#F9F6E6]
                               hover:text-[#8D77AB] hover:bg-[#E1EACD] focus:outline-none focus:ring-2
                               focus:ring-inset focus:ring-[#BAD8B6]">
                        <svg class="h-6 w-6" :class="{'hidden': open, 'inline-flex': !open }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg class="h-6 w-6" :class="{'inline-flex': open, 'hidden': !open }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden bg-[#8D77AB] border-t border-[#E1EACD]">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @foreach(['Feed' => '/', 'My Posts' => 'posts.myPosts', 'Network' => 'connections.index', 'Home' => 'dashboard'] as $label => $route)
                <x-responsive-nav-link :href="$route === '/' ? '/' : route($route)" :active="$route === '/' ? request()->is('/') : request()->routeIs($route)"
                                       class="block px-3 py-2 rounded-md text-base font-medium
                    {{ ($route === '/' ? request()->is('/') : request()->routeIs($route))
                        ? 'bg-[#BAD8B6] text-[#8D77AB]'
                        : 'text-[#F9F6E6] hover:bg-[#E1EACD] hover:text-[#8D77AB]' }}">
                    {{ __($label) }}
                </x-responsive-nav-link>
            @endforeach
        </div>
    </div>
</nav>
