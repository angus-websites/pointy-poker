<?php

use App\Enum\RoundStatus;
use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {

    #[Reactive]
    public RoundStatus $status;

    public function getMetaProperty(): array
    {
        return match ($this->status) {

            RoundStatus::IDLE => [
                'title' => 'Waiting to start',
                'icon' => 'clock',
                'classes' => 'text-amber-600 dark:text-amber-500',
            ],

            RoundStatus::VOTING => [
                'title' => 'Voting in progress',
                'icon' => 'hourglass',
                'classes' => 'text-sky-700 dark:text-sky-500 animate-[spin_3s_linear_infinite]',
            ],

            RoundStatus::REVEALED => [
                'title' => 'Showing results',
                'icon' => 'sparkles',
                'classes' => 'text-sky-700 dark:text-sky-500',
            ],

            default => [
                'title' => 'No active round',
                'icon' => 'circle',
                'classes' => 'text-zinc-400',
            ],
        };
    }
};
?>

@php
    $meta = $this->meta;
@endphp

<div class="flex items-center gap-x-2">

    <flux:icon
        name="{{ $meta['icon'] }}"
        class="size-5 {{ $meta['classes'] }}"
    />

    <flux:heading size="lg" level="2">
        {{ $meta['title'] }}
    </flux:heading>

</div>
