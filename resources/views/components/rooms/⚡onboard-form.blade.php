<?php

use App\Models\Participant;
use App\Models\Room;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component {

    public Room $room;

    public string $name = '';

    protected array $rules = [
        'name' => 'required|string|min:2|max:25',
    ];

    public function join()
    {

        // Validate input
        $this->validate();

        // Generate unique browser token
        // TODO use service
        $token = (string)Str::uuid();

        // TODO use service here
        $participant = Participant::create([
            'room_id' => $this->room->id,
            'display_name' => $this->name,
            'token' => $token,
            'last_seen_at' => now(),
        ]);

        // TODO use service to handle cookie and token management
        cookie()->queue('room_token_' . $this->room->id, $token, 60 * 24 * 365);

        // Notify parent component / refresh UI
        //$this->dispatch('participantJoined');

        // Log joining event
        logger()->info('Participant joined room', [
            'room_id' => $this->room->id,
            'participant_id' => $participant->id,
            'participant_name' => $participant->name,
        ]);

        // Redirect to join room again
        return redirect()->route('rooms.show', ['slug' => $this->room->slug]);
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
