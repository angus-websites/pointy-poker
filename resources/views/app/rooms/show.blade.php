<x-layouts::app :title="__('Room')">


    <div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">
                {{$room->name}}
            </flux:heading>
        </div>
        <div>
            <flux:button variant="primary">Copy Link</flux:button>
        </div>
    </div>
    <flux:separator variant="subtle"/>

    {{-- Controls --}}
    <section class="my-10">
        <flux:heading size="lg" level="2" class="mb-5">
            Controls
        </flux:heading>
        <div>
            <flux:button>Reset</flux:button>
            <flux:button>Show results</flux:button>
        </div>
    </section>

    {{-- Estimate --}}
    <section class="my-10">
        <flux:heading size="lg" level="2" class="mb-5">
            Available Points
        </flux:heading>

        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 xl:grid-cols-8 gap-4">
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
        <livewire:rooms.live-table :room="$room"/>
    </section>
</x-layouts::app>
