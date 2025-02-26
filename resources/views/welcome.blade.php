<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DevNet') }}</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 overflow-x-hidden">
<!-- Header -->
@include('layouts.header')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-indigo-600 via-purple-500 to-pink-500 dark:from-gray-800 dark:via-gray-700 dark:to-gray-700 text-gray-100">
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-transparent to-black/50 opacity-50"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 relative z-10 text-center md:text-left">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center">
            <div class="space-y-6">
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                    Welcome to
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 via-indigo-300 to-pink-300">
                            DevNet
                        </span>
                </h1>
                <p class="text-lg text-gray-200 leading-relaxed">
                    Connect, collaborate, and create. Transform the future of technology with fellow developers worldwide. Join our growing community today.
                </p>
                <div class="mt-8 space-y-4 sm:space-x-4">
                    <a href="{{ route('register') }}" class="inline-block px-6 py-3 rounded-lg bg-purple-700 text-white hover:bg-purple-800 shadow-lg transition-all">
                        Get Started
                    </a>
                    <a href="#features" class="inline-block px-6 py-3 border border-gray-200 text-gray-200 rounded-lg hover:text-gray-100 hover:border-gray-100">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="relative bg-white dark:bg-gray-800 rounded-lg p-8 shadow-lg">
                    <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Why Choose DevNet?</h2>
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li><span class="font-bold text-indigo-400">50K+</span> Active Developers Worldwide</li>
                        <li><span class="font-bold text-purple-400">12K+</span> Shared Projects</li>
                        <li><span class="font-bold text-pink-400">Real-Time Collaboration</span> for Developers</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-gray-100">
                Discover Powerful Features
            </h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-3xl mx-auto mt-4">
                DevNet provides tools and services that empower developers to work better, share knowledge, and innovate faster.
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <svg class="w-12 h-12 text-indigo-500 mb-4" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" fill="currentColor"/>
                    <path d="M2 17l10 5 10-5M2 12l10 5 10-5" fill="currentColor"/>
                </svg>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                    Advanced Collaboration
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Work seamlessly on projects with real-time tools built for teamwork across the globe.
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <svg class="w-12 h-12 text-green-500 mb-4" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M6 3l6 3 6-3 6 3v4l-6 3-6-3-6 3-6-3V3z" fill="currentColor"/>
                    <path d="M6 12l6 3v6l6-2v-7l6 3v7l-6 3" fill="currentColor"/>
                </svg>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                    Streamlined Code Sharing
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Easily share your projects, libraries, and solutions to help others and get feedback.
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <svg class="w-12 h-12 text-pink-500 mb-4" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 4.354a4 4 0 110 5.292m4.606-4.606A4.979 4.979 0 0112 9.5M3 6v12m18-12v12M13 7a4 4 0 11-8 0 4 4 0 018 0z" fill="currentColor"/>
                </svg>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                    Global Developer Community
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Become part of a growing network that spans across countries and programming languages.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="relative py-20 bg-indigo-600 text-white">
    <div class="absolute inset-0 opacity-50 bg-gradient-to-br from-purple-700 via-indigo-700 to-indigo-800"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h2 class="text-4xl font-bold">
                Ready to Build the Future?
            </h2>
            <p class="max-w-2xl mx-auto mt-4 text-lg">
                Join thousands of developers on DevNet to innovate, connect, and share knowledge that powers the tech industry.
            </p>
            <a href="{{ route('register') }}" class="mt-8 inline-block px-8 py-4 bg-purple-800 hover:bg-purple-700 rounded-lg shadow-lg transition">
                Get Started for Free
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
@include('layouts.footer')
</body>
</html>
