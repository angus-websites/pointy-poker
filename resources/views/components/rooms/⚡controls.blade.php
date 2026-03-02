<?php

use App\Enum\RoundStatus;
use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {

    #[Reactive]
    public RoundStatus $status;

    public bool $hasParticipants = false;


    public function getStatusMetaProperty(): array
    {
        return match ($this->status) {

            RoundStatus::IDLE => [
                'description' => 'Click "Begin voting" to start the round and allow users to submit their estimates.',
                'button' => [
                    'label' => 'Begin Voting',
                    'event' => 'begin-voting',
                    'color' => 'lime',
                ],
            ],

            RoundStatus::VOTING => [
                'description' => 'When all users have submitted their estimates, click "Reveal" to show the results.',
                'button' => [
                    'label' => 'Reveal',
                    'event' => 'reveal-round',
                    'color' => 'blue',
                ],
            ],

            RoundStatus::REVEALED => [
                'description' => 'Click "Reset" to clear estimates and start a new round.',
                'button' => [
                    'label' => 'Reset',
                    'event' => 'new-round',
                    'color' => 'amber',
                ],
            ],
        };
    }
};
?>

@php
    $meta = $this->statusMeta;
@endphp

<div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between">
    <div>
        <livewire:rooms.status-header :status="$this->status" :key="'status-'.$this->status?->value"/>

        <flux:text class="mt-1">
            {{ $meta['description'] }}
        </flux:text>
    </div>

    <div>
        <flux:button
            variant="primary"
            color="{{ $meta['button']['color'] }}"
            wire:click="$dispatch('{{ $meta['button']['event'] }}')"
            :disabled="(!$hasParticipants)"
        >
            {{ $meta['button']['label'] }}
        </flux:button>
    </div>
</div>
