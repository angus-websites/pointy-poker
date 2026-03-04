<?php

use Livewire\Component;

new class extends Component
{
    public string $buttonText = 'Copy';
    public string $textToCopy = '';
};
?>

<div x-data="{ content: $wire.entangle('textToCopy'), buttonText: $wire.entangle('buttonText') }">
    <flux:button
        x-data="{ copied: false }"
        x-on:click="$clipboard(content);copied = true; setTimeout(() => copied = false, 2000);"
    >
        <flux:icon.clipboard
            variant="outline"
            x-show="!copied"
        />
        <flux:icon.clipboard-document-check
            variant="outline"
            x-cloak
            x-show="copied"
        />
        <span x-text="copied ? 'Copied' : buttonText"></span>
    </flux:button>
</div>
