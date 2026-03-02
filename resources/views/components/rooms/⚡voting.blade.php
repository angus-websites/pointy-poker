<?php

use App\Enum\RoundStatus;
use App\Models\Participant;
use App\Models\Room;
use App\Models\Vote;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public Room $room;
    public Participant $participant;

    public string $currentVote = '';
    public bool $canVote = false;


    protected array $points = ['1', '2', '3', '5', '8', '13', '20'];

    public function mount()
    {
        // Fetch current vote if exists
        $round = $this->room->round();
        if ($round) {
            $vote = $round->votes()->where('participant_id', $this->participant->id)->first();
            $this->currentVote = $vote ? $vote->value : '';

            // Enable voting if round is in VOTING status
            $this->canVote = $round->status == RoundStatus::VOTING;
        }


    }



    public function vote($point)
    {
        // Prevent voting if not allowed
        if (!$this->canVote) {
            Flux::toast('Voting is not currently enabled', 'error');
            return;
        }

        $round = $this->room->round();

        if (!$round) {
            Flux::toast('No active round to vote in', 'error');
            return;
        }

        // Upsert vote
        Vote::updateOrCreate(
            [
                'round_id' => $round->id,
                'participant_id' => $this->participant->id,
            ],
            [
                'value' => $point,
            ]
        );

        $this->currentVote = $point;
        Flux::toast('You voted');

    }

};
?>

<div>
    <div class="grid grid-cols-3 md:grid-cols-5 gap-4">

        @foreach($this->points as $point)
            <livewire:rooms.point-card
                :key="'point-'.$point.'-'.$this->currentVote"
                @voted="vote($event.detail.point)"
                :point="$point"
                :selected="$currentVote === $point"
                :enabled="$canVote"/>

        @endforeach

    </div>

    @unless($this->canVote)
        <div class="mt-5">
            <flux:text variant="subtle">
                Voting is currently disabled
            </flux:text>
        </div>
    @endunless
</div>
