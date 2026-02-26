<?php

use App\Events\GuestVoted;
use App\Models\Room;
use App\Models\Vote;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public Room $room;
    public string $guestId;
    public string $currentVote = '';

    public function mount()
    {
        // Fetch current vote is exists
        $round = $this->room->round();
        if ($round) {
            $vote = $round->votes()->where('participant_key', $this->guestId)->first();
            $this->currentVote = $vote ? $vote->value : '';
        }
    }

    public function vote($point)
    {

        $round = $this->room->round();

        if (!$round) {
            Flux::toast('No active round to vote in', 'error');
            return;
        }

        // Upsert vote
        Vote::updateOrCreate(
            [
                'round_id' => $round->id,
                'participant_key' => $this->guestId,
            ],
            [
                'value' => $point,
            ]
        );

        $this->currentVote = $point;

        // Dispatch event to other participants
        event(new GuestVoted($this->room->id, $this->guestId, $point));

        Flux::toast('You voted ' . $point . ' points' . ' guest id: ' . $this->guestId);

    }

    public function shouldEnable(): bool
    {

        // TODO cache this to avoid n+1 queries
        $round = $this->room->round();
        return $round && $round->status == \App\Enum\RoundStatus::VOTING;
    }
};
?>

<div class="grid grid-cols-3 md:grid-cols-5 gap-4">

    @if($this->shouldEnable())
        @foreach(['1', '2', '3', '5', '8', '13', '20'] as $point)
            <flux:card
                wire:click="vote('{{ $point }}')"
                size="sm"
                @class([
                    'hover:cursor-pointer border' => true,

                    // Selected state
                    'border-lime-600 dark:border-lime-300 bg-lime-600 dark:bg-lime-700' => $currentVote === $point,

                    // Default state
                    'border-transparent hover:bg-zinc-50 dark:hover:bg-zinc-700 ' => $currentVote !== $point,
                ])
            >
                <flux:text
                    @class([
                     'mt-2 text-center' => true,

                     // Selected state
                     'text-white' => $currentVote === $point,

                     // Default state
                     '' => $currentVote !== $point,
                 ])
                >
                    {{ $point }}
                </flux:text>
            </flux:card>
        @endforeach
    @else
        @foreach(['1', '2', '3', '5', '8', '13', '20'] as $point)
            <flux:card
                size="sm"
                @class([
                    'hover:cursor-not-allowed opacity-50' => true,

                    // Selected state
                    'border-lime-600 dark:border-lime-300 bg-lime-600 dark:bg-lime-700' => $currentVote === $point,

                    // Default state
                    'border-transparent' => $currentVote !== $point,
                ])
            >
                <flux:text
                    @class([
                     'mt-2 text-center' => true,

                     // Selected state
                     'text-white' => $currentVote === $point,

                     // Default state
                     '' => $currentVote !== $point,
                 ])
                >
                    {{ $point }}
                </flux:text>
            </flux:card>
        @endforeach

    @endif
</div>
