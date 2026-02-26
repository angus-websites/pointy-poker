<x-layouts::app :title="__('Room')">


    <div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">
                {{$room->name}}
            </flux:heading>
        </div>
        <div>
            <flux:button>Copy Link</flux:button>
        </div>
    </div>
    <flux:separator variant="subtle"/>

    {{-- Controls --}}
    <section class="my-10">
        <flux:heading size="lg" level="2" class="mb-5">
            Controls
        </flux:heading>
        <livewire:rooms.controls :room="$room"/>
    </section>

    {{-- Estimate --}}
    <section class="my-10">
        <div class="mb-5">
            <flux:heading size="lg" level="2">
                Available Points
            </flux:heading>
            <flux:text class="mt-1">
                A breakdown of the available points and what their values mean.
            </flux:text>
        </div>

        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
            @foreach(['1', '2', '3', '5', '8', '13', '20'] as $point)
                <flux:card size="sm">
                    <flux:heading size="lg font-mono">{{ $point }}</flux:heading>
                    <flux:text class="mt-2">
                        {{ match ($point) {
                            '1' => 'Very simple task, less than half a day\'s work.',
                            '2' => 'Simple task, about half a day\'s work.',
                            '3' => 'Moderately complex task, about a day\'s work.',
                            '5' => 'Complex task, about 2-3 days\' work.',
                            '8' => 'Very complex task, about a week\'s work.',
                            '13' => 'Extremely complex task, about two weeks\' work.',
                            '20' => 'Nearly impossible task, about a month\'s work or more.',
                            default => '',
                        } }}
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
        <livewire:rooms.live-table :room="$room"/>
    </section>
</x-layouts::app>
