<x-layouts::master>
    @section('title', $title ?? null)
    <div class="min-h-screen flex flex-col">
        <x-public.header/>
        <div class="flex-1 flex">
            {{ $slot }}
        </div>
        <x-public.footer/>
    </div>
</x-layouts::master>
