<?php

use App\Models\Participant;
use App\Models\Room;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public Room $room;
    public ?Participant $participant;
    public array $participants = [];


    public function getListeners()
    {
        return [
            "echo:room.{$this->room->id},ParticipantJoined" => 'participantJoined',
        ];
    }

    public function participantJoined($payload): void
    {
        Flux::toast('New participant joined: ' . $payload['display_name']);
    }
};
?>

<flux:table>
    <flux:table.columns>
        <flux:table.column class="w-1/2">User</flux:table.column>
        <flux:table.column class="w-1/4">Status</flux:table.column>
        <flux:table.column class="w-1/4">Points</flux:table.column>
    </flux:table.columns>

    <flux:table.rows>
        @foreach($room->participants as $p)
            <flux:table.row
                @class([
                    'bg-zinc-200/50 dark:bg-zinc-700/50' => isset($participant) && $p->id === $participant->id
                ])
            >
                <flux:table.cell @class([
                                'font-bold' =>  isset($participant) && $p->id === $participant->id
                            ])>{{ $p->display_name }}</flux:table.cell>

                <flux:table.cell>
                    <flux:badge color="red" size="sm" inset="top bottom">
                        Waiting
                    </flux:badge>
                </flux:table.cell>

                <flux:table.cell variant="strong">
                    <flux:text class="text-xs">Hidden</flux:text>
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
