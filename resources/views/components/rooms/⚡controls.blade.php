<?php

use App\Enum\RoundStatus;
use App\Models\Room;
use Flux\Flux;
use Livewire\Component;

new class extends Component {

    public Room $room;

    public ?RoundStatus $status = null;

    public function mount()
    {
        // Ensure a round exists
        if (!$this->room->round()) {
            $this->room->rounds()->create([
                'status' => RoundStatus::IDLE,
            ]);
        }

        $this->status = $this->room->round()?->status;
    }

    public function getStatusMetaProperty(): array
    {
        return match ($this->status) {

            RoundStatus::IDLE => [
                'title' => 'Waiting to start',
                'description' => 'Click "Begin voting" to start the round and allow users to submit their estimates.',
                'button' => [
                    'label' => 'Begin Voting',
                    'action' => 'beginVoting',
                    'color' => 'lime',
                ],
                'icon' => 'clock',
                'colorClasses' => 'text-amber-600 dark:text-amber-500',
            ],

            RoundStatus::VOTING => [
                'title' => 'Voting in progress',
                'description' => 'When all users have submitted their estimates, click "Reveal" to show the results.',
                'button' => [
                    'label' => 'Reveal',
                    'action' => 'reveal',
                    'color' => 'blue',
                ],
                'icon' => 'clock',
                'colorClasses' => 'text-amber-700 dark:text-amber-500',
            ],

            RoundStatus::REVEALED => [
                'title' => 'Showing results',
                'description' => 'Click "Reset" to clear estimates and start a new round.',
                'button' => [
                    'label' => 'Reset',
                    'action' => 'newRound',
                    'color' => 'amber',
                ],
                'icon' => 'clock',
                'colorClasses' => 'text-amber-700 dark:text-amber-500',
            ],
        };
    }

    public function beginVoting()
    {
        $this->updateStatus(RoundStatus::VOTING);
    }

    public function reveal()
    {
        $this->updateStatus(RoundStatus::REVEALED);
    }

    public function newRound()
    {
        $this->room->rounds()->create([
            'status' => RoundStatus::IDLE,
        ]);

        $this->status = RoundStatus::IDLE;
    }

    protected function updateStatus(RoundStatus $status): void
    {
        $round = $this->room->round();

        if (!$round) {
            Flux::toast('No active round found', 'error');
            return;
        }

        $round->update(['status' => $status]);
        $this->status = $status;
    }

    public function hasParticipants(): bool
    {
        return $this->room->participants()->exists(); // more efficient than count()
    }
};
?>

@php
    $meta = $this->statusMeta;
@endphp

<div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between">
    <div>
        <div class="flex items-center gap-x-2">

            {{-- Status Icon --}}
            <flux:icon name="{{ $meta['icon'] }}" class="size-5  {{$meta['colorClasses']}}"/>

            <flux:heading size="lg" level="2">
                {{ $meta['title'] }}
            </flux:heading>
        </div>

        <flux:text class="mt-1">
            {{ $meta['description'] }}
        </flux:text>
    </div>

    <div>
        <flux:button
            variant="primary"
            color="{{ $meta['button']['color'] }}"
            wire:click="{{ $meta['button']['action'] }}"
            :disabled="(!$this->hasParticipants())"
        >
            {{ $meta['button']['label'] }}
        </flux:button>
    </div>
</div>
