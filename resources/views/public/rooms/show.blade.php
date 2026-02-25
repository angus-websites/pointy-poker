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
            <livewire:rooms.voting :room="$room" :guestId="$guestData['id']" />
        </section>

        {{-- Results --}}
        <section class="my-10">
            <flux:heading size="lg" level="2" class="mb-5">
                Results
            </flux:heading>
            <livewire:rooms.live-table :room="$room" :participantId="$guestData['id']"/>
        </section>
    </x-page-container>
</x-layouts::public>
