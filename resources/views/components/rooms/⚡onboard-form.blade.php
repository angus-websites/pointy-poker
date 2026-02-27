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

        // Generate token
        $token = (string)Str::uuid();

        // Create participant
        Participant::create([
            'room_id' => $this->room->id,
            'name' => $this->name,
            'token' => $token,
        ]);

        // Create a cookie with guest info
        //TODO move to service
        cookie()->queue(
            cookie(
                'pokey_participant_' . $this->room->id,
                encrypt(json_encode([
                    'token' => $token,
                ])),
                60 * 24 * 365 // 1 year
            )
        );

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
