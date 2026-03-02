<?php

use App\Enum\RoundStatus;
use App\Models\Participant;
use App\Models\Room;
use Livewire\Component;

new class extends Component {
    public Room $room;
    public Participant $participant;
    public ?RoundStatus $status = null;

    public function refreshStatus(): void
    {
        $this->room->refresh();

        $newStatus = $this->room->round()?->status;

        if ($newStatus !== $this->status) {
            $this->status = $newStatus;
        }
    }
};


?>

<div wire:poll.2s="refreshStatus" class="p-6 grid grid-cols-1 gap-y-10">

    {{-- Status bar --}}
    <livewire:rooms.status-bar :status="$room->round()?->status"/>

    {{-- Vote --}}
    <livewire:rooms.voting :room="$room" :participant="$participant"/>

    {{-- Live table --}}
    <livewire:rooms.live-table :room="$room"/>
</div>
