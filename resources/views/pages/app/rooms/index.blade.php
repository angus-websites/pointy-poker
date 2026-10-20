<x-layouts::app :title="__('My Rooms')">


    <div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">
                My rooms
            </flux:heading>
            <flux:text class="mt-2 text-base">
                Here you can find all the rooms you've created and create new ones.
            </flux:text>
        </div>
        <div>
            <livewire:rooms.create-room/>
        </div>
    </div>

    <flux:separator variant="subtle"/>

    <div class="mt-5">
        <livewire:rooms.show-all/>
    </div>
</x-layouts::app>
