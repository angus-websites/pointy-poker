<?php

use App\Enum\RoundStatus;
use Illuminate\Support\Collection;
use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public Collection $participants;
    public ?int $currentParticipantId = null;
    #[Reactive]
    public Collection $votes; // participant_id => value
    #[Reactive]
    public RoundStatus $status;

    protected function badgeMeta(int $participantId): array
    {
        $hasVoted = isset($this->votes[$participantId]);

        return match ($this->status) {

            RoundStatus::VOTING => [
                'text' => $hasVoted ? 'Voted' : 'Waiting',
                'color' => $hasVoted ? 'lime' : 'amber',
            ],

            RoundStatus::REVEALED => [
                'text' => $hasVoted ? 'Voted' : 'Did not vote',
                'color' => $hasVoted ? 'lime' : 'rose',
            ],

            RoundStatus::IDLE => [
                'text' => 'Connected',
                'color' => 'blue',
            ],
        };
    }

    protected function displayPoints(int $participantId): string
    {
        $hasVoted = isset($this->votes[$participantId]);
        $isCurrent = $participantId === $this->currentParticipantId;

        if ($this->status === RoundStatus::REVEALED) {
            return $this->votes[$participantId] ?? '-';
        }

        if ($this->status === RoundStatus::VOTING) {

            // Always show current participant their vote
            if ($isCurrent) {
                return $this->votes[$participantId] ?? '-';
            }

            return $hasVoted ? 'Hidden' : '-';
        }

        return '-';
    }
};
?>

<div>
    <flux:table>
        <flux:table.columns>
            <flux:table.column class="w-1/2">User</flux:table.column>
            <flux:table.column class="w-1/4">Status</flux:table.column>
            <flux:table.column class="w-1/4">Points</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($participants as $p)

                @php
                    $badge = $this->badgeMeta($p->id);
                @endphp

                <flux:table.row>

                    <flux:table.cell>
                        {{ $p->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge color="{{ $badge['color'] }}" size="sm" inset="top bottom">
                            {{ $badge['text'] }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell variant="strong">
                        <flux:text class="text-xs">
                            {{ $this->displayPoints($p->id) }}
                        </flux:text>
                    </flux:table.cell>

                </flux:table.row>

            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
