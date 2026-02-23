<x-layouts::public title="Welcome to Bud">
    <x-page-container>
        <div>
            <div class="mx-auto max-w-3xl md:text-center">
                <p class="text-base/7 font-semibold  text-emerald-600 dark:text-emerald-400">
                    Bud
                </p>
                <h1 class="mt-2 font-shantell text-5xl font-bold tracking-tight text-pretty text-gray-900 sm:text-5xl md:text-6xl lg:text-balance dark:text-white">
                    A simple boilerplate <span class="block text-emerald-500 dark:text-emerald-400 xl:inline">for</span> Laravel
                </h1>
                <p class="mt-6 text-lg/7 text-gray-500 dark:text-gray-400  max-w-md md:max-w-xl md:mx-auto">
                    Bud comes packed with authentication, privacy policy, Tailwind, Livewire and Flux
                </p>

                <div class="mx-auto mt-5 sm:flex md:justify-center md:mt-8">
                    <div class="rounded-md shadow-sm">
                        <a href="{{ route('register') }}"
                           class="flex w-full items-center justify-center rounded-md border border-transparent bg-emerald-500 dark:bg-emerald-400 dark:hover:bg-emerald-300 px-8 py-3 text-base font-medium text-white dark:text-emerald-800 hover:bg-emerald-600 md:px-10 md:py-4 md:text-lg">
                            Get
                            started
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </x-page-container>
</x-layouts::public>
