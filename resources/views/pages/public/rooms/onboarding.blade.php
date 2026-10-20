<x-layouts::public title="Pointy Poker">
    <x-page-container class="max-w-2xl mx-auto">
        <div class="mb-6 text-center">
            <flux:heading size="xl" level="1">
                Joining Room
            </flux:heading>
            <flux:text class="mt-2 text-lg">
                {{ $room->name }}
            </flux:text>
        </div>
        <flux:separator variant="subtle"/>

        <section class="my-10">
            <livewire:rooms.onboard-form :room="$room"/>
        </section>

    </x-page-container>
</x-layouts::public>
