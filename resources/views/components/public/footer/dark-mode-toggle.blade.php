<flux:tooltip content="Toggle dark mode">
    <flux:button
        square
        variant="subtle"
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
