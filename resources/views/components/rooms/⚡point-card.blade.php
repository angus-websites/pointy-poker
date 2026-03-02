<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public bool $enabled = true;

    #[Reactive]
    public bool $selected = false;
    public string $point;
};
?>

<flux:card
    wire:click="$dispatch('voted', { point: {{ $point }} })"
    size="sm"
    @class([
        'border transition' => true,

        // Cursor
        'hover:cursor-pointer' => $this->enabled,
        'cursor-not-allowed opacity-50' => !$this->enabled,

        // Selected
        'border-lime-600 dark:border-lime-300 bg-lime-600 dark:bg-lime-700' => $this->selected,

        // Default
        'border-transparent hover:bg-zinc-50 dark:hover:bg-zinc-700' => !$this->selected,
    ])
>
    <flux:text
        @class([
            'mt-2 text-center',
            'text-white' => $this->selected,
        ])
    >
        {{ $point }}
    </flux:text>
</flux:card>
