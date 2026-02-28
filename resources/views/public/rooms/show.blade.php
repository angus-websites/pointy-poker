<x-layouts::public title="Pointy Poker">
    <x-page-container>
        {{-- Top Bar --}}
        <div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between mb-6">
            <div>
                <flux:heading size="xl" level="1">
                    {{$room->name}}
                </flux:heading>
                <flux:text class="mt-2 text-lg">
                    Your name: {{ $participant->name }}
                </flux:text>
            </div>
        </div>
        <flux:separator variant="subtle"/>

        {{-- Grid --}}
        <main class="mt-16">
            <div class="mx-auto">
                <!-- Main 3 column grid -->
                <div class="grid grid-cols-1 gap-4">

                    <!-- Main -->
                    <div class="col-span-full">
                        <section aria-labelledby="user-table-section-title">
                            <h2 id="user-table-section-title" class="sr-only">Users Table</h2>
                            <div
                                class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-white/10 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">
                                <div class="p-6 grid grid-cols-1 gap-y-10">

                                    {{-- Status bar --}}
                                    <livewire:rooms.status-bar :room="$room"/>

                                    {{-- Vote --}}
                                    <livewire:rooms.voting :room="$room" :participant="$participant"/>

                                    {{-- Live table --}}
                                    <livewire:rooms.live-table :room="$room"/>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </x-page-container>

</x-layouts::public>
