<header x-data="{ open: false }">
    <div class="">
        <div
            class="mx-auto flex max-w-7xl items-center justify-between p-6 md:justify-start md:space-x-10 px-8">
            <div class="flex justify-start lg:w-0 lg:flex-1">
                <a href="{{ route('home') }}" class="flex items-center justify-center" wire:navigate>
                    <x-public.logo/>
                </a>
            </div>
            <div class="md:hidden">

                <flux:button square icon="bars-3" @click="open = true" aria-expanded="false">
                </flux:button>

            </div>
            <div class="hidden items-center justify-end md:flex md:flex-1 lg:w-0 space-x-5">
                @auth
                    <flux:button wire:navigate :href="route('dashboard')" variant="primary">Dashboard
                    </flux:button>
                @else
                    <flux:button wire:navigate :href="route('login')" variant="ghost">Login</flux:button>
                    @if (Route::has('register'))
                        <flux:button wire:navigate :href="route('register')" variant="primary">Register
                        </flux:button>
                    @endif
                @endauth

            </div>
        </div>

        <div
            x-show="open"
            x-transition
            x-transition.duration.75ms
            @click.outside="open = false"
            x-cloak
            class="absolute inset-x-0 top-0 z-30 origin-top-right transform p-2 md:hidden"
        >
            <div class="divide-y-2 divide-zinc-800 rounded-lg bg-white dark:bg-zinc-900 shadow-lg ring-1 ring-black/5">
                <div class="px-5 pt-5 pb-6">
                    <div class="flex items-center justify-between">
                        <flux:button class="w-full"
                                     icon="x-mark"
                                     @click="open = false"
                                     variant="ghost"
                        >


                        </flux:button>
                    </div>
                </div>
                <div class="px-5 py-6">
                    <div class="mt-6 space-y-4">
                        @auth
                            <flux:button wire:navigate :href="route('dashboard')" class="w-full" variant="primary">
                                Dashboard
                            </flux:button>
                        @else
                            @if (Route::has('register'))
                                <flux:button wire:navigate :href="route('register')" class="w-full" variant="primary">
                                    Register
                                </flux:button>
                            @endif
                            <flux:button wire:navigate :href="route('login')" variant="ghost" class="w-full">Login
                            </flux:button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

