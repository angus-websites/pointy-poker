<?php

use App\Events\GuestVoted;
use App\Models\Room;
use App\Models\Vote;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public Room $room;
    public string $guestId;

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

        // Dispatch event to other participants
        event(new GuestVoted($this->room->id, $this->guestId, $point));

        Flux::toast('You voted ' . $point . ' points' . ' guest id: ' . $this->guestId);

    }
};
?>

<div class="grid grid-cols-3 md:grid-cols-5 gap-4">
    @foreach(['1', '2', '3', '5', '8', '13', '20'] as $point)
        <flux:card wire:click="vote('{{ $point }}')" size="sm"
                   class="hover:bg-zinc-50 border-lime-600! dark:border-lime-300! border dark:hover:bg-zinc-700 hover:cursor-pointer">
            <flux:text class="mt-2 text-center">
                {{ $point }}
            </flux:text>
        </flux:card>
    @endforeach
</div>
