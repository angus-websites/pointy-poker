@props([
    'mode' => 'auto', // auto | light | dark
])

<?php
$logoService = app(\App\Services\LogoService::class);
$logoName = $logoService->getLogoName();
?>

<div class="text-center">
    @if ($mode === 'light')
        <img {{ $attributes->class('h-10 mx-auto') }}
             src="{{ asset("assets/images/logo/{$logoName}-light.png") }}" alt="Pointy Poker Logo">
    @elseif ($mode === 'dark')
        <img {{ $attributes->class('h-10 mx-auto') }}
             src="{{ asset("assets/images/logo/{$logoName}.png") }}" alt="Pointy Poker Logo">
    @else
        {{-- auto (Tailwind dark mode) --}}
        <img {{ $attributes->class('dark:hidden h-10 mx-auto') }}
             src="{{ asset("assets/images/logo/{$logoName}.png") }}" alt="Pointy Poker Logo">

        <img {{ $attributes->class('hidden dark:block h-10 mx-auto') }}
             src="{{ asset("assets/images/logo/{$logoName}-light.png") }}" alt="Pointy Poker Logo">
    @endif
</div>
