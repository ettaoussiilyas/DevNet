@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#BAD8B6] text-start text-base font-medium text-[#8D77AB] bg-[#BAD8B6]/50 focus:outline-none focus:text-[#8D77AB] focus:bg-[#BAD8B6]/70 focus:border-[#BAD8B6] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-[#8D77AB] hover:bg-[#E1EACD] hover:border-[#E1EACD] focus:outline-none focus:text-[#8D77AB] focus:bg-[#E1EACD] focus:border-[#E1EACD] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
