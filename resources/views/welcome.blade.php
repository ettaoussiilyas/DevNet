<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DevNet') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#F9F6E6]">
<!-- Navigation -->
<nav class="bg-white/80 backdrop-blur-sm border-b border-[#E1EACD] fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-[#8D77AB]">DevNet</span>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-[#8D77AB] hover:text-[#8D77AB]/80">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-full bg-[#BAD8B6] text-white hover:bg-[#BAD8B6]/90 transition">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-full bg-[#8D77AB] text-white hover:bg-[#8D77AB]/90 transition">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="relative min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Connect, Share & Grow with
                    <span class="text-[#8D77AB]">Developer Community</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Join our thriving community of developers. Share your knowledge, learn from others, and build your professional network.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-3 rounded-full bg-[#8D77AB] text-white hover:bg-[#8D77AB]/90 transition text-lg font-semibold">
                        Get Started
                    </a>
                    <a href="#features" class="px-8 py-3 rounded-full bg-[#BAD8B6] text-white hover:bg-[#BAD8B6]/90 transition text-lg font-semibold">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-[#E1EACD]/30 rounded-lg transform rotate-3"></div>
                <div class="relative bg-white p-6 rounded-lg shadow-xl">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4 p-4 bg-[#F9F6E6] rounded-lg">
                            <div class="w-10 h-10 rounded-full bg-[#BAD8B6] flex items-center justify-center">
                                <span class="text-white font-bold">D</span>
                            </div>
                            <div class="flex-1">
                                <div class="h-2 bg-[#E1EACD] rounded-full w-3/4"></div>
                                <div class="h-2 bg-[#E1EACD] rounded-full w-1/2 mt-2"></div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4 bg-[#F9F6E6] rounded-lg">
                            <div class="w-10 h-10 rounded-full bg-[#8D77AB] flex items-center justify-center">
                                <span class="text-white font-bold">N</span>
                            </div>
                            <div class="flex-1">
                                <div class="h-2 bg-[#E1EACD] rounded-full w-2/3"></div>
                                <div class="h-2 bg-[#E1EACD] rounded-full w-1/3 mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900">Why Join DevNet?</h2>
            <p class="text-gray-600 mt-4">Discover the benefits of being part of our community</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-[#E1EACD]">
                <div class="w-12 h-12 bg-[#BAD8B6] rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Connect with Peers</h3>
                <p class="text-gray-600">Build meaningful connections with developers from around the world.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-[#E1EACD]">
                <div class="w-12 h-12 bg-[#8D77AB] rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Share Knowledge</h3>
                <p class="text-gray-600">Share your expertise and learn from other developers' experiences.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-[#E1EACD]">
                <div class="w-12 h-12 bg-[#BAD8B6] rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Grow Together</h3>
                <p class="text-gray-600">Accelerate your career growth through collaboration and networking.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-[#E1EACD] mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <p class="text-gray-500">&copy; {{ date('Y') }} DevNet. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
