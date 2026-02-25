<x-layouts::public title="Pointy Poker">
    <x-page-container>
        <div class="mb-6">
            <flux:heading size="xl" level="1">
                {{$room->name}}
            </flux:heading>
            <flux:text class="mt-2 text-lg">
                Your name: {{ $guestData["name"] }}
            </flux:text>
        </div>
        <flux:separator variant="subtle"/>

        {{-- Estimate --}}
        <section class="my-10">
            <flux:heading size="lg" level="2" class="mb-5">
                Estimate
            </flux:heading>
            <div class="grid grid-cols-3 md:grid-cols-5 gap-4">
                @foreach(['1', '2', '3', '5', '8', '13', '20'] as $point)
                    <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <flux:text class="mt-2 text-center">
                            {{ $point }}
                        </flux:text>
                    </flux:card>
                @endforeach
            </div>
        </section>

        {{-- Results --}}
        <section class="my-10">
            <flux:heading size="lg" level="2" class="mb-5">
                Results
            </flux:heading>
            <livewire:rooms.live-table :room="$room" :participantId="$guestData['name']"/>
        </section>
    </x-page-container>
</x-layouts::public>
