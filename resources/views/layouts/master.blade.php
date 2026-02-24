<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <!-- Angus was here 2026 -->
    <head>
        @include('partials.head')
    </head>
    <body class="bg-[#F2FCFF] dark:bg-zinc-800">
        {{ $slot }}
    </body>
    <flux:toast />
    @fluxScripts
</html>

