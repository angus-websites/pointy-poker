<x-layouts::public title="Welcome to Pointy Poker">
    <x-page-container>
        <div class="grid grid-cols-1 gap-y-12">

            {{-- Intro --}}
            <section class="mx-auto max-w-3xl md:text-center">
                <p class="text-base/7 font-semibold  text-sky-600 dark:text-sky-400">
                    Pointy Poker
                </p>
                <h1 class="mt-2 font-shantell text-5xl font-bold tracking-tight text-pretty text-gray-900 sm:text-5xl md:text-6xl lg:text-balance dark:text-white">
                    Fast and easy planning <span class="block text-sky-500 dark:text-sky-400 xl:inline">poker</span> for teams
                </h1>
                <p class="mt-6 text-lg/7 text-gray-500 dark:text-gray-400  max-w-md md:max-w-xl md:mx-auto">
                    Pointy Poker allows you to quickly create a planning poker session, invite your team, and start estimating your user stories in no time.
                </p>
            </section>

            {{-- Join form --}}
            <section>
                <div class="mx-auto max-w-xl md:text-center">
                    <livewire:rooms.join-form/>

                </div>
            </section>

            {{-- Get started --}}
            <section>
                <p class="text-center block mb-2.5 text-base font-medium text-heading">Or</p>

                <div class="mx-auto mt-5 sm:flex md:justify-center md:mt-8">
                    <div class="rounded-md shadow-sm">
                        <a href="{{ route('rooms.index') }}"
                           class="flex w-full items-center justify-center rounded-md border border-transparent bg-sky-500 hover:bg-sky-600 dark:bg-sky-500 dark:hover:bg-sky-600 px-8 py-3 text-base font-medium text-white  md:px-10 md:py-4 md:text-lg">
                            Create a room
                        </a>
                    </div>
                </div>
            </section>




        </div>
    </x-page-container>
</x-layouts::public>
