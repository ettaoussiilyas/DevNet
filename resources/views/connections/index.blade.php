<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sage: '#BAD8B6',
                        cream: '#E1EACD',
                        ivory: '#F9F6E6',
                        purple: '#8D77AB'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-ivory">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-purple leading-tight">
            {{ __('My Posts ') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto pt-8 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Profile Card -->
            <div class="space-y-6 flex flex-col lg:col-span-1 lg:row-span-2">
                <div class="bg-cream rounded-xl shadow-sm overflow-hidden">
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-r from-sage to-purple relative overflow-hidden">
                            <img src="{{ asset('storage/'.$user->banner) }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-80">
                        </div>
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Profile"
                             class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-cream shadow-md"/>
                    </div>
                    <div class="pt-14 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-purple">{{ $user->name }}</h2>
                            <a href="{{ $user->github_url }}" target="_blank" class="text-purple hover:text-sage transition-colors">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        </div>
                        <p class="text-purple/70 text-sm mt-1">{{ $user->industry }}</p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="px-3 py-1.5 bg-sage/20 text-purple rounded-full text-xs">{{$user->skills}}</span>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="px-3 py-1.5 bg-sage/20 text-purple rounded-full text-xs">{{$user->programming_languages}}</span>
                        </div>

                        <p class="text-purple/60 text-sm mt-2">{{ $user->certifications }}</p>
                        <p class="text-purple/60 text-sm mt-2">{{ $user->bio }}</p>

                        <div class="mt-6 pt-6 border-t border-sage/30">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-sage/10 rounded-lg p-3 text-center">
                                    <span class="block text-2xl font-bold text-purple">{{ $user->connections }}</span>
                                    <span class="text-sm text-purple/70">Connections</span>
                                </div>
                                <div class="bg-sage/10 rounded-lg p-3 text-center">
                                    <span class="block text-2xl font-bold text-purple">{{ count($pendingRequests) }}</span>
                                    <span class="text-sm text-purple/70">Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                @if(count($pendingRequests) > 0)
                    <div class="bg-cream rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center text-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-sage" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                            </svg>
                            Pending Requests
                            <span class="ml-2 bg-sage/20 text-purple text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ count($pendingRequests) }}
                                </span>
                        </h3>

                        <div class="divide-y divide-sage/20">
                            @foreach($pendingRequests as $request)
                                @if($request->user)
                                    <div class="py-4 flex items-center justify-between hover:bg-sage/10 rounded-lg px-2">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('storage/' . $request->user->image) }}"
                                                 alt="{{ $request->user->name }}"
                                                 class="w-12 h-12 rounded-full object-cover border border-sage"/>
                                            <div>
                                                <h4 class="font-medium text-purple">{{ $request->user->name }}</h4>
                                                <p class="text-purple/60 text-sm">{{ $request->user->industry }}</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('connections.accept', $request->user) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-sage text-purple rounded-full hover:bg-purple hover:text-cream">
                                                    Accept
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('connections.reject', $request->user) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-sage text-purple rounded-full hover:bg-sage/20">
                                                    Ignore
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Suggested Connections -->
                <div class="bg-cream rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center text-purple">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-sage" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        People You May Know
                    </h3>

                    <div class="divide-y divide-sage/20">
                        @forelse($userss as $otherUser)
                            <div class="py-4 flex items-center justify-between hover:bg-sage/10 rounded-lg px-2">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $otherUser->image) }}"
                                         alt="{{ $otherUser->name }}"
                                         class="w-12 h-12 rounded-full object-cover border border-sage"/>
                                    <div>
                                        <h4 class="font-medium text-purple">{{ $otherUser->name }}</h4>
                                        <p class="text-purple/60 text-sm">{{ $otherUser->industry }}</p>
                                        @if($otherUser->skills)
                                            <div class="mt-1 flex flex-wrap gap-1">
                                                @foreach(array_slice(explode(',', $otherUser->skills), 0, 2) as $skill)
                                                    <span class="px-2 py-0.5 bg-sage/20 text-purple rounded-full text-xs">
                                                            {{ trim($skill) }}
                                                        </span>
                                                @endforeach
                                                @if(count(explode(',', $otherUser->skills)) > 2)
                                                    <span class="px-2 py-0.5 bg-sage/20 text-purple rounded-full text-xs">
                                                            +{{ count(explode(',', $otherUser->skills)) - 2 }}
                                                        </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(!Auth::user()->isConnectedOrPendingWith($otherUser))
                                    <form method="POST" action="{{ route('connections.send', $otherUser) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-sage text-purple rounded-full hover:bg-sage/20">
                                            Connect
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 border border-sage text-purple/60 rounded-full bg-sage/10">
                                            Pending
                                        </span>
                                @endif
                            </div>
                        @empty
                            <div class="py-10 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-purple/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="mt-4 text-purple/60 text-center">No suggestions available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
</html>
