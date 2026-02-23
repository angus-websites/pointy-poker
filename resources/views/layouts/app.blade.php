<x-layouts::app.header :title="$title ?? null">
    <x-container class="mt-10 md:mt-15">
        {{ $slot }}
    </x-container>
</x-layouts::app.header>
