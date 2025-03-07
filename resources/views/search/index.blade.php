<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8D77AB] leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#F9F6E6] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-[#8D77AB] mb-4">
                        Search results for: "{{ $query }}"
                    </h3>
                    
                    <!-- We'll implement the full search results page later -->
                    <p class="text-[#8D77AB]/70">
                        This page will show more detailed search results.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>