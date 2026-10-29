<footer aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <x-container class="pt-6 pb-3 sm:pt-16 sm:pb-8">
        <div class="border-t border-gray-200 dark:border-zinc-700 pt-3 grid grid-cols-[auto_minmax(0,1fr)_auto] items-center gap-x-2 sm:flex sm:justify-between sm:gap-6 sm:pt-8">
            <x-public.footer.system-info-link/>

            <p class="flex min-w-0 flex-wrap items-center justify-center gap-x-3 text-center text-sm text-gray-500 dark:text-zinc-100/60 sm:flex-1 sm:justify-start sm:gap-y-2 sm:text-left sm:text-base">
                <span class="max-w-full break-words">&copy; {{ date('Y') }} {{ config('app.name') }}</span>
                <span aria-hidden="true" class="hidden sm:inline">|</span>
                <flux:link wire:navigate href="{{route('privacy-policy')}}" variant="ghost" class="inline-flex min-h-11 items-center sm:min-h-0">Privacy Policy</flux:link>
                <span aria-hidden="true" class="hidden sm:inline">|</span>
                <span class="inline-flex flex-wrap items-center justify-center gap-2">Made by Angus
                </span>
            </p>

            <div class="justify-self-end">
                <x-public.footer.dark-mode-toggle/>
            </div>
        </div>
    </x-container>
</footer>
