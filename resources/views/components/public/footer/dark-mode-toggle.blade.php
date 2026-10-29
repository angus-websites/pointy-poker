<flux:tooltip content="Toggle dark mode">
    <flux:button
        square
        variant="subtle"
        aria-label="Toggle dark mode"
        class="min-h-11 min-w-11"
        x-data
        x-on:click="$flux.dark = ! $flux.dark"
    >
        <flux:icon.moon
             variant="solid"
             x-show="! $flux.dark"
        />
        <flux:icon.sun
            variant="solid"
            x-cloak
            x-show="$flux.dark"
        />
    </flux:button>
</flux:tooltip>
