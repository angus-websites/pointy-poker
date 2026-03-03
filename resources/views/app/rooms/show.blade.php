<x-layouts::app :title="__('Room')">

    {{-- Top Bar --}}
    <div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">
                {{$room->name}}
            </flux:heading>
            <flux:text class="mt-2">
                Code to Join: <span class="font-mono ml-2 text-lg">{{ $room->getCode() }}</span>
            </flux:text>
        </div>
        <div>
            <flux:button>Copy Link</flux:button>
        </div>
    </div>
    <flux:separator variant="subtle"/>

    {{-- Grid --}}
    <main class="mt-10">
        <div class="mx-auto">
            <!-- Main 3 column grid -->
            <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-4 lg:gap-8">

                <!-- Left column -->
                <div class="grid grid-cols-1 gap-4 lg:col-span-3">
                    <section>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-white/10 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">
                            <livewire:rooms.admin-master :room="$room"/>
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
                                        @foreach(['1', '2', '3', '5', '8', '13', '21'] as $point)
                                        <li class="py-4 sm:px-0 text-left lg:text-center">
                                            <flux:heading size="xl" class=" font-mono">{{ $point }}</flux:heading>
                                            <flux:text class="mt-2">
                                                {{ match ($point) {
                                                    '1' => 'About half a day',
                                                    '2' => 'About a day',
                                                    '3' => 'Less than 2 days',
                                                    '5' => 'Half a week',
                                                    '8' => 'A week',
                                                    '13' => '2 Weeks',
                                                    '21' => 'A month or more',
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
