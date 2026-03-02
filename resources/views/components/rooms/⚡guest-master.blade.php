<?php

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use App\Contracts\Model\RoundContract;
use App\Enum\RoundStatus;
use App\Models\Vote;
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

    public Collection $participants;
    public Collection $participantVotes;

    protected $listeners = [
        'vote-cast' => 'handleVote',
    ];

    public function handleVote($point): void
    {

        // TODO service
        Vote::updateOrCreate(
            [
                'round_id' => $this->currentRound->getId(),
                'participant_id' => $this->participant->getId(),
            ],
            [
                'value' => $point,
            ]
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
        // Update only this participant
        // TODO service
        $this->participant->update([
            'last_seen_at' => now(),
        ]);

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
        $this->currentVote = $round->getVote($this->participant->getId())?->value;

        // Fetch active participants in the room
        $this->participants = $sessionService->getActiveParticipants($this->room);


        // Fetch votes for active participants
        $this->participantVotes = $sessionService->getParticipantsVotes($this->room);

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
        :participants="$participants"
        :current-participant-id="$participant->id"
        :votes="$participantVotes"
        :status="$status"
    />

</div>
