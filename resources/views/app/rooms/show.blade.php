<x-layouts::app :title="__('Room')">


    {{-- Top Bar --}}
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

    {{-- Grid --}}
    <main class="mt-16">
        <div class="mx-auto">
            <!-- Main 3 column grid -->
            <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-4 lg:gap-8">

                <!-- Left column -->
                <div class="grid grid-cols-1 gap-4 lg:col-span-3">
                    <section aria-labelledby="user-table-section-title">
                        <h2 id="user-table-section-title" class="sr-only">Users Table</h2>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-white/10 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">
                            <div class="p-6">

                                {{-- Control bar --}}
                                <livewire:rooms.controls :room="$room"/>

                                {{-- Live table --}}
                                <livewire:rooms.live-table :room="$room"/>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right column -->
                <div class="grid grid-cols-1 gap-4">
                    <section aria-labelledby="points-explained-section-title">
                        <h2 id="points-explained-section-title" class="sr-only">Points Explained</h2>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-white/10 dark:shadow-none dark:inset-ring dark:inset-ring-white/10">
                            <div class="p-6">
                                <flux:heading size="lg" level="2" class="text-center mb-5">
                                    Points Explained
                                </flux:heading>
                                    <ul role="list" class="divide-y divide-gray-200 dark:divide-white/10">
                                        @foreach(['1', '2', '3', '5', '8', '13', '20'] as $point)
                                        <li class="py-4 sm:px-0 text-left lg:text-center">
                                            <flux:heading size="xl" class=" font-mono">{{ $point }}</flux:heading>
                                            <flux:text class="mt-2">
                                                {{ match ($point) {
                                                    '1' => 'About an hour',
                                                    '2' => 'About half a day',
                                                    '3' => 'About a day',
                                                    '5' => 'About a week',
                                                    '8' => 'About two weeks',
                                                    '13' => 'About a month',
                                                    '20' => 'More than a month',
                                                    default => '',
                                                } }}
                                            </flux:text>
                                        </li>
                                        @endforeach
                                    </ul>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

</x-layouts::app>
