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
                        <section>
                            <div
                                class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-white/10 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">
                                <livewire:rooms.guest-master :participant="$participant" :room="$room"/>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </x-page-container>

</x-layouts::public>
