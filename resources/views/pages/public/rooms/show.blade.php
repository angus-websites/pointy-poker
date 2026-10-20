<x-layouts::public :title="$room->name">
    <x-page-container>

        {{-- Top Bar --}}
        <livewire:rooms.guest-header :participant="$participant" :room="$room"/>

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
