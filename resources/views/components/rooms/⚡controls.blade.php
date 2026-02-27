<?php

use App\Enum\RoundStatus;
use App\Models\Room;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public Room $room;

    public function mount()
    {
        // TODO move this somewhere
       // Ensure a round exists for the room
         if (!$this->room->round()) {
            $this->room->rounds()->create([
                'status' => RoundStatus::IDLE,
            ]);
         }
    }

    public function beginVoting()
    {
        $round = $this->room->round();
        if (!$round) {
            Flux::toast('No active round to begin voting in', 'error');
            return;
        }
        $round->update(['status' => RoundStatus::VOTING]);
    }

    public function reveal()
    {
        $round = $this->room->round();
        if (!$round) {
            Flux::toast('No active round to reveal', 'error');
            return;
        }
        $round->update(['status' => RoundStatus::REVEALED]);
    }

    public function newRound()
    {
        // Create new round
        // TODo move
        $this->room->rounds()->create([
            'status' => RoundStatus::IDLE,
        ]);

    }

    public function hasParticipants(): bool
    {
        return $this->room->participants()->count() > 0;
    }
};
?>

<div class="mb-10 flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between">
    <div>
        <flux:heading size="lg" level="2">
            {{ match ($room->round()->status) {
                RoundStatus::IDLE => 'Waiting to start',
                RoundStatus::VOTING => 'Voting in progress',
                RoundStatus::REVEALED => 'Showing results',
            } }}
        </flux:heading>
        <flux:text class="mt-1">
            {{ match ($room->round()->status) {
                RoundStatus::IDLE => 'Click "Begin voting" to start the round and allow users to submit their estimates.',
                RoundStatus::VOTING => 'When all users have submitted their estimates, click "Reveal" to show the results.',
                RoundStatus::REVEALED => 'Click "Reset" to clear estimates and start a new round.',
            } }}
        </flux:text>
    </div>
    <div>
        @switch($room->round()->status)
            @case(RoundStatus::IDLE)
                <flux:button variant="primary" color="lime" wire:click="beginVoting">Begin Voting</flux:button>
                @break
            @case(RoundStatus::VOTING)
                <flux:button variant="primary" wire:click="reveal">Reveal</flux:button>
                @break
            @case(RoundStatus::REVEALED)
                <flux:button variant="primary" color="amber" wire:click="newRound">Reset</flux:button>
                @break
        @endswitch
    </div>
</div>
