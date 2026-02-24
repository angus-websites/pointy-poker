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
        <flux:table>
            <flux:table.columns>
                <flux:table.column class="w-1/2">User</flux:table.column>
                <flux:table.column class="w-1/4">Status</flux:table.column>
                <flux:table.column class="w-1/4">Points</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach($room->participants as $participant)
                    <flux:table.row>
                        <flux:table.cell>{{ $participant->display_name }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge color="red" size="sm" inset="top bottom">Waiting</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell variant="strong">
                            <flux:text class="text-xs">Hidden</flux:text>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </section>
</x-layouts::app>
