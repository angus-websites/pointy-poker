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
};
?>

<div>
    @if($room->round())
        @if($room->round()->status === RoundStatus::IDLE)
            <flux:button variant="primary" color="lime" wire:click="beginVoting">Begin Voting</flux:button>
        @elseif($room->round()->status === RoundStatus::VOTING)
            <flux:button variant="primary" wire:click="reveal">Reveal</flux:button>
        @elseif($room->round()->status === RoundStatus::REVEALED)
            <flux:button variant="primary" wire:click="newRound">Reset</flux:button>
        @endif
    @else
        <flux:callout variant="danger" icon="x-circle" heading="Error, no round found for room"/>
    @endif
</div>
