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
            <flux:button variant="primary">New Room</flux:button>
        </div>
    </div>

    <flux:separator variant="subtle"/>


    <ul class="mt-5 gap-y-4 flex flex-col">
        @foreach($rooms as $room)
            <li>
                <a href="{{route('rooms.show', ['slug' => $room->slug])}}" aria-label="Go to {{ $room->name }} room" wire:navigate>
                    <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <flux:heading class="flex items-center gap-2">{{ $room->name }}
                            <flux:icon name="arrow-up-right" class="ml-auto text-zinc-400" variant="micro"/>
                        </flux:heading>
                        <flux:text class="mt-2">
                            Created {{ $room->created_at->diffForHumans() }}
                        </flux:text>
                    </flux:card>
                </a>
            </li>
        @endforeach
    </ul>
</x-layouts::app>
