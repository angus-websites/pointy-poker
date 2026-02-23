<x-layouts::minimal :title="$title ?? null">
    <div class="flex flex-1 items-center justify-center bg-muted p-6 md:p-10">
        <div class="flex w-full max-w-md flex-col gap-6">
            <flux:card>
                {{ $slot }}
            </flux:card>
        </div>
    </div>
</x-layouts::minimal>
