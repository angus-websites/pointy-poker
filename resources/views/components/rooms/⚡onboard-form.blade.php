<?php

use App\Contracts\Model\RoomContract;
use App\Services\RoomService;
use Livewire\Component;

new class extends Component {

    public RoomContract $room;

    public string $name = '';

    protected array $rules = [
        'name' => 'required|string|min:2|max:25',
    ];


    public function join(RoomService $roomService)
    {

        // Validate input
        $this->validate();

        // Create participant
        $roomService->createParticipant(
            room: $this->room,
            name: $this->name,
        );

        // Redirect to join room again
        return redirect()->route('rooms.show', ['code' => $this->room->getCode()]);
    }
};
?>

<form class="space-y-5" wire:submit.prevent="join">
    <flux:field>
        <flux:label>Name</flux:label>

        <flux:description>This will be publicly displayed.</flux:description>

        <flux:input wire:model="name" placeholder="Bob"/>

        <flux:error name="name"/>
    </flux:field>

    <flux:field>
        <flux:button variant="primary" type="submit">Join Room</flux:button>
    </flux:field>
</form>
