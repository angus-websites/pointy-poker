<?php

use App\Enum\RoundStatus;
use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {

    public int $participantId;
    #[Reactive]
    public RoundStatus $status;
    #[Reactive]
    public ?string $currentVote = null;

    protected array $points = ['1', '2', '3', '5', '8', '13', '21'];

    public function canVote(): bool
    {
        return $this->status === RoundStatus::VOTING;
    }

    public function vote($point): void
    {
        if (!$this->canVote()) return;

        // Emit upward instead of touching DB
        $this->dispatch('vote-cast', point: $point);
    }
};
?>

<div>
    <div class="grid grid-cols-3 md:grid-cols-5 gap-4">

        @foreach($this->points as $point)
            <livewire:rooms.point-card
                :key="'point-'.$point"
                @voted="vote($event.detail.point)"
                :point="$point"
                :selected="$currentVote === $point"
                :enabled="$this->canVote()"/>

        @endforeach

    </div>

    <div class="mt-5">
        @if($this->canVote())
        <flux:text variant="subtle">

            You can now vote!
        </flux:text>
        @else
            <flux:text variant="subtle">
                Voting is currently disabled
            </flux:text>
        @endif
    </div>
</div>
