<x-layouts::app :title="__('Room')">

    <div class="mb-6">
        <flux:heading size="xl" level="1">
            {{$room->name}}
        </flux:heading>
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
                <flux:table.row>
                    <flux:table.cell>Jon</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="green" size="sm" inset="top bottom">Voted</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">
                        <flux:text class="text-xs">Hidden</flux:text>
                    </flux:table.cell>
                </flux:table.row>

                <flux:table.row>
                    <flux:table.cell>Jon</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="red" size="sm" inset="top bottom">Waiting</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">
                        <flux:text class="text-xs">Hidden</flux:text>
                    </flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        </flux:table>
    </section>
</x-layouts::app>
