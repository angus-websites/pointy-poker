<x-layouts::master>
    @section('title', $title ?? null)
    <div class="min-h-screen flex flex-col">

        <a href="/" wire:navigate>
            <x-public.mark class="h-15 my-5 w-auto"/>
        </a>


        <div class="flex-1 flex">

            {{ $slot }}
        </div>
        <x-public.footer/>
    </div>
</x-layouts::master>
