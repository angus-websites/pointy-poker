<x-layouts::master>
    @section('title', $title ?? null)
    <div class="min-h-screen flex flex-col">
        <x-app.header/>
        <div class="flex-1 flex">
            <x-container class="mt-10 md:mt-15">
            {{ $slot }}
            </x-container>
        </div>
        <x-public.footer/>
    </div>
</x-layouts::master>
