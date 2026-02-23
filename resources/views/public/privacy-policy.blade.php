<x-layouts::public title="Welcome to Bud">
    <x-page-container>
        <div>
            <x-page-title heading="Privacy Policy " subtitle="Updated January 2026"/>
        </div>

        <article class="mt-10 prose dark:prose-invert max-w-none prose-hr:border-zinc-800/5 dark:prose-hr:border-white/10">
            {!! $markdown !!}
        </article>
    </x-page-container>
</x-layouts::public>
