<footer aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <x-container class="pt-16 pb-8">
        <div class="border-t border-gray-200 dark:border-zinc-700 pt-8 flex items-center justify-between gap-6">
            <!-- System Info (Far Left) -->
            <x-public.footer.system-info-link/>

            <!-- Branding Section -->
            <p class="text-base text-gray-500 flex-1">
                &copy; {{ date('Y') }} {{ config('app.name') }} | Made by Angus
            </p>

            <!-- Dark Mode Toggle (Far Right) -->
            <x-public.footer.dark-mode-toggle/>
        </div>
    </x-container>
</footer>
