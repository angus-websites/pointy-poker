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
        // TODO optimise this to avoid n+1
        return $this->room->round()?->status == RoundStatus::IDLE;
    }

    public function isReveal(): bool
    {
        // TODO optimise this to avoid n+1
        return $this->room->round()?->status == RoundStatus::REVEALED;
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

        // Check if guest already exists to avoid duplicates (can happen when refreshing the page)
        if (collect($this->participants)->pluck('id')->contains($guest['id'])) {
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

<div>
    @empty($participants)
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
                                    Connected
                                </flux:badge>
                            @elseif($this->hasGuestVoted($p['id']))
                                <flux:badge color="green" size="sm" inset="top bottom">
                                    Voted
                                </flux:badge>
                            @elseif($this->isReveal())
                                <flux:badge color="red" size="sm" inset="top bottom">
                                    No vote
                                </flux:badge>
                            @else
                                <flux:badge color="amber" size="sm" inset="top bottom">
                                    Waiting
                                </flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell variant="strong">
                            @if($this->isReveal())
                                {{--TODO wtf is this --}}
                                <flux:text>
                                    {{ $this->room->round()->votes()->where('participant_key', $p['id'])->value('value') ?? 'N/A' }}
                                </flux:text>
                            @else
                                <flux:text class="text-xs">Hidden</flux:text>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @endempty
</div>

