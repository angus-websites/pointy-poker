<?php

use App\Enum\RoundStatus;
use App\Models\Room;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public Room $room;
    public array $participants = [];
    public ?string $participantId = null;


    public function getListeners()
    {
        return [
            "echo-presence:rooms.{$this->room->id},here" => 'here',
            "echo-presence:rooms.{$this->room->id},joining" => 'joining',
            "echo-presence:rooms.{$this->room->id},leaving" => 'leaving',
            "echo:rooms.{$this->room->id},.guestVoted" => 'handleGuestVoted',
        ];
    }

    public function handleGuestVoted($payload)
    {
        // Trigger refresh of the component to update the table
        Flux::toast("Guest {$payload['guestId']} voted {$payload['point']}");
    }

    public function hasGuestVoted($guestId): bool
    {
        // TODO optimise this to avoid n+1
        return $this->room->round()->votes()->where('participant_key', $guestId)->exists();
    }

    public function isIdle(): bool
    {
        return $this->room->round()?->status == RoundStatus::IDLE;
    }


    // Fired when the component receives the list of all current guests
    public function here(array $guests)
    {
        $this->participants = collect($guests)
            ->reject(fn($u) => $u['admin'] ?? false)
            ->values()
            ->toArray();

        Flux::toast('Participants loaded');

    }

    // Fired when a new guest joins
    public function joining(array $guest)
    {
        if ($guest['admin'] ?? false) {
            return;
        }
        $this->participants[] = $guest;
    }

    // Fired when a guest leaves
    public function leaving(array $guest)
    {
        $this->participants = collect($this->participants)
            ->reject(fn($p) => $p['id'] === $guest['id'])
            ->values()
            ->toArray();
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
        @foreach($participants as $p)
            <flux:table.row
                @class([
                    'bg-zinc-200/50 dark:bg-zinc-700/50' => isset($participantId) && $p['id'] === $participantId
                ])
            >
                <flux:table.cell @class([
                                'font-bold' =>  isset($participantId) && $p['id'] === $participantId
                            ])>{{ $p['name'] }}</flux:table.cell>

                <flux:table.cell>

                        @if($this->isIdle())
                            <flux:badge color="blue" size="sm" inset="top bottom">
                                Joined
                            </flux:badge>
                        @elseif($this->hasGuestVoted($p['id']))
                            <flux:badge color="green" size="sm" inset="top bottom">
                                Voted
                            </flux:badge>
                        @else
                            <flux:badge color="red" size="sm" inset="top bottom">
                                Waiting
                            </flux:badge>
                        @endif
                </flux:table.cell>

                <flux:table.cell variant="strong">
                    <flux:text class="text-xs">Hidden</flux:text>
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
