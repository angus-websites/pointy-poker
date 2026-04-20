<?php

use Livewire\Component;
use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use Livewire\Attributes\On;


new class extends Component
{
    public RoomContract $room;
    public ParticipantContract $participant;

    public string $name = '';

    public function mount()
    {
        $this->name();
    }

    #[On('name-updated')]
    public function name()
    {
        $this->name = $this->participant->name;
    }

};
?>

{{-- Top Bar --}}
<div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between mb-6">
    <div>
        <flux:heading size="xl" level="1">
            {{$room->name}}
        </flux:heading>
        <flux:text class="mt-2 text-lg">
            Your name: {{ $participant->name }}
        </flux:text>
    </div>
    <div>
        <livewire:rooms.guest-settings :participant="$participant" :room="$room"/>
    </div>
</div>
