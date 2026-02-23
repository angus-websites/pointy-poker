<div class="text-center">
    {{-- auto (Tailwind dark mode) --}}
    <img {{ $attributes->class('dark:hidden mx-auto') }}
         src="{{ asset('assets/images/logo/mark.png') }}" alt="Bud Logo">

    <img {{ $attributes->class('hidden dark:block mx-auto') }}
         src="{{ asset('assets/images/logo/mark-light.png') }}" alt="Bud Logo">
</div>
