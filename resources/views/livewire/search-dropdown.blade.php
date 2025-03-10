<div class="relative">
    <input 
        wire:model.live="search" 
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
    
    <!-- Debug info -->
    <div class="absolute top-12 right-0 bg-white p-2 text-xs">
        Search: "{{ $search }}"
    </div>
    
    <!-- Search Results Dropdown -->
    @if(strlen($search) >= 2)
        <div class="absolute mt-1 w-full bg-white rounded-md shadow-lg max-h-80 overflow-y-auto z-50 border border-[#E1EACD]">
            @if(count($searchResults['users']) > 0 || count($searchResults['posts']) > 0)
                <!-- Users Section -->
                @if(count($searchResults['users']) > 0)
                    <div class="px-4 py-2 text-xs font-semibold text-[#8D77AB] bg-[#E1EACD]/30">
                        People ({{ count($searchResults['users']) }})
                    </div>
                    @foreach($searchResults['users'] as $user)
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-[#E1EACD]/20">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="text-sm font-medium text-[#8D77AB]">{{ $user->name }}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
                
                <!-- Posts Section -->
                @if(count($searchResults['posts']) > 0)
                    <div class="px-4 py-2 text-xs font-semibold text-[#8D77AB] bg-[#E1EACD]/30">
                        Posts ({{ count($searchResults['posts']) }})
                    </div>
                    @foreach($searchResults['posts'] as $post)
                        <a href="{{ route('posts.show', $post->id) }}" class="block px-4 py-2 hover:bg-[#E1EACD]/20">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="text-sm font-medium text-[#8D77AB]">{{ $post->title }}</div>
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
        </div>
    @endif
</div>
