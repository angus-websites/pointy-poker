<?php

use App\Contracts\Model\RoomContract;
use App\Enum\RoundStatus;
use App\Services\RoomSessionService;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component {
    public RoomContract $room;

    public RoundStatus $status;

    public Collection $participantData;

    protected $listeners = [
        'begin-voting' => 'beginVoting',
        'reveal-round' => 'reveal',
        'new-round' => 'newRound',
    ];


    public function mount()
    {
        $this->syncFromDatabase();
    }

    public function beginVoting(): void
    {
        $this->updateStatus(RoundStatus::VOTING);
    }

    public function reveal(): void
    {
        $this->updateStatus(RoundStatus::REVEALED);
    }

    public function newRound(): void
    {

        $sessionService = app(RoomSessionService::class);

        $sessionService->newRound($this->room);

        $this->syncFromDatabase();
    }

    protected function updateStatus(RoundStatus $status): void
    {

        // Get the current round
        $round = $this->room->getCurrentRound();

        if (!$round) {
            return;
        }

        // Set the new status
        $round->setStatus($status);

        $this->syncFromDatabase();
    }

    public function refresh(): void
    {
        $this->syncFromDatabase();
    }


    protected function syncFromDatabase(): void
    {
        $round = $this->room->getCurrentRound();

        if (!$round) {
            // Create a round if it doesn't exist
            // TODO service
            $this->newRound();
            return;
        }

        $sessionService = app(RoomSessionService::class);

        // Update the status
        $this->status = $round->getStatus();

        // Fetch Participant Data
        $this->participantData = $sessionService->getActiveParticipantsWithVotes($this->room);

    }
};

?>

<div wire:poll.2s="refresh" class="p-6 grid grid-cols-1 gap-y-10">

    {{-- Control bar --}}
    <livewire:rooms.controls
        :status="$status"
        :has-participants="$participantData->isNotEmpty()"
    />


    @if($this->participantData->isEmpty())
        <div class="text-center my-5">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" aria-hidden="true"
                 class="mx-auto size-12 text-gray-400 dark:text-gray-500">
                <path
                    d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h2 class="mt-2 text-base font-semibold text-gray-900 dark:text-white">
                No participants yet
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Share the room link to invite participants to join the room
            </p>
        </div>
    @else
        {{-- Live table --}}
        <livewire:rooms.live-table
            :participants="$participantData"
            :status="$status"
        />
    @endif
</div>
