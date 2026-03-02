<?php

use App\Enum\RoundStatus;
use App\Models\Participant;
use App\Models\Room;
use App\Models\Vote;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

new class extends Component {
    public Room $room;
    public Participant $participant;
    public ?RoundStatus $status = null;

    public int $roundId;
    public ?string $currentVote = null;

    public Collection $participants;
    public array $participantVotes = []; // ['participant_id' => 'value']

    protected $listeners = [
        'vote-cast' => 'handleVote',
    ];

    public function handleVote($point): void
    {
        Vote::updateOrCreate(
            [
                'round_id' => $this->roundId,
                'participant_id' => $this->participant->id,
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
        $this->syncFromDatabase();
    }

    protected function syncFromDatabase(): void
    {
        $round = $this->room->round();

        if (!$round) {
            return;
        }

        $this->roundId = $round->id;
        $this->status = $round->status;

        $this->currentVote = $round->votes()
            ->where('participant_id', $this->participant->id)
            ->value('value');

        // TODO optimize this by eager loading votes with participants
        $this->participants = $this->room->participants()->get();

        $this->participantVotes = $round->votes()
            ->pluck('value', 'participant_id')
            ->toArray();

    }

    public function refreshStatus(): void
    {
        $this->syncFromDatabase();
    }
};


?>

<div wire:poll.2s="refreshStatus" class="p-6 grid grid-cols-1 gap-y-10">

    {{-- Status bar --}}
    <livewire:rooms.status-bar :status="$room->round()?->status"/>

    {{-- Vote --}}
    <livewire:rooms.voting
        :participant-id="$this->participant->id"
        :status="$status"
        :current-vote="$currentVote"
    />

    {{-- Live table --}}
    <livewire:rooms.live-table-guest
        :participants="$participants"
        :current-participant-id="$participant->id"
        :votes="$participantVotes"
        :status="$status"
    />
</div>
