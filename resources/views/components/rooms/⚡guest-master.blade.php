<?php

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use App\Contracts\Model\RoundContract;
use App\Enum\RoundStatus;
use App\Services\RoomSessionService;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component {
    public RoomContract $room;
    public ParticipantContract $participant;
    public RoundStatus $status;

    public RoundContract $currentRound;
    public ?string $currentVote = null;

    public Collection $participantData;

    protected $listeners = [
        'vote-cast' => 'handleVote',
    ];

    public function handleVote($point): void
    {

        $this->currentRound->castVote(
            $this->participant,
            $point
        );

        $this->currentVote = $point;

        Flux::toast('You voted');
    }

    public function mount()
    {
        $this->heartbeat();
    }

    public function heartbeat(): void
    {

        $this->participant->ping();

        $this->syncFromDatabase();
    }

    public function syncFromDatabase(): void
    {

        $sessionService = app(RoomSessionService::class);

        // Get current round
        $round = $this->room->getCurrentRound();

        if (!$round) {
            abort(404, 'No active round found');
        }

        // Update state
        $this->currentRound = $round;

        // Update the status
        $this->status = $round->getStatus();

        // Update current vote
        $this->currentVote = $round->getVote($this->participant)?->value;

        // Fetch Participant Data
        $this->participantData = $sessionService->getActiveParticipantsWithVotes($this->room);

    }
};


?>

<div wire:poll.2s="heartbeat" class="p-6 grid grid-cols-1 gap-y-10">

    {{-- Status bar --}}
    <livewire:rooms.status-bar :status="$status"/>

    {{-- Vote --}}
    <livewire:rooms.voting
        :participant-id="$this->participant->getId()"
        :status="$status"
        :current-vote="$currentVote"
    />

    {{-- Live table --}}
    <livewire:rooms.live-table
        :participants="$participantData"
        :current-participant-id="$participant->id"
        :status="$status"
    />

</div>
