<div class="relative">
    <input 
        wire:model.debounce.300ms="search" 
        type="text"
        class="bg-[#E1EACD] text-[#8D77AB] text-sm rounded-full w-64 px-4 py-2 pl-10
            focus:outline-none focus:ring-2 focus:ring-[#BAD8B6] focus:bg-[#F9F6E6]
            placeholder-[#8D77AB]/60"
        placeholder="Search DevNet...">
    
    <div class="absolute left-3 top-2.5">
        <svg class="h-5 w-5 text-[#8D77AB]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>
    
    <!-- Loading indicator -->
    <div wire:loading class="absolute right-3 top-2.5">
        <svg class="animate-spin h-5 w-5 text-[#8D77AB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
    
    <!-- Search Results Dropdown -->
    @if(strlen($search) >= 2)
        <div class="absolute mt-1 w-full bg-white rounded-md shadow-lg max-h-80 overflow-y-auto z-50 border border-[#E1EACD]">
            @if(count($searchResults['users']) > 0 || count($searchResults['posts']) > 0)
                <!-- Users Section -->
                @if(count($searchResults['users']) > 0)
                    <div class="px-4 py-2 text-xs font-semibold text-[#8D77AB] bg-[#E1EACD]/30">
                        People
                    </div>
                    @foreach($searchResults['users'] as $user)
                        <a href="{{ route('profile.show', $user->id) }}" class="block px-4 py-2 hover:bg-[#E1EACD]/20">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-[#BAD8B6] flex items-center justify-center text-[#8D77AB] font-semibold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-[#8D77AB]">{{ $user->name }}</div>
                                    @if($user->industry)
                                        <div class="text-xs text-[#8D77AB]/70">{{ $user->industry }}</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
                
                <!-- Posts Section -->
                @if(count($searchResults['posts']) > 0)
                    <div class="px-4 py-2 text-xs font-semibold text-[#8D77AB] bg-[#E1EACD]/30">
                        Posts
                    </div>
                    @foreach($searchResults['posts'] as $post)
                        <a href="{{ route('posts.show', $post->id) }}" class="block px-4 py-2 hover:bg-[#E1EACD]/20">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#8D77AB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-[#8D77AB]">{{ $post->title }}</div>
                                    <div class="text-xs text-[#8D77AB]/70">
                                        {{ \Illuminate\Support\Str::limit($post->description, 40) }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            @else
                <div class="px-4 py-3 text-sm text-[#8D77AB]/70 text-center">
                    No results found for "{{ $search }}"
                </div>
            @endif
            
            <!-- View All Results Link -->
            <div class="border-t border-gray-100 bg-gray-50 rounded-b-md">
                <a href="{{ route('search.index', ['q' => $search]) }}" class="block px-4 py-2 text-xs text-center text-[#8D77AB] hover:bg-gray-100 font-medium">
                    View all results
                </a>
            </div>
        </div>
    @endif
</div>
