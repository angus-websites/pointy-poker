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
    public RoundStatus $status;

    protected function badgeMeta(object $participant): array
    {
        $hasVoted = $participant->vote !== null;

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

    protected function displayPoints(object $participant): string
    {
        $hasVoted = $participant->vote !== null;
        $isCurrent = $participant->id === $this->currentParticipantId;

        if ($this->status === RoundStatus::REVEALED) {
            return $participant->vote ?? '-';
        }

        if ($this->status === RoundStatus::VOTING) {

            // Always show current participant their vote
            if ($isCurrent) {
                return $participant->vote ?? '-';
            }

            return $hasVoted ? 'Hidden' : '-';
        }

        return '-';
    }

    protected function getSecretPoints(object $participant): string
    {
        return $participant->vote ?? '?';
    }
};
?>

<div
    x-data="{
        clicks: [],
        revealAll: false,
        threshold: 1000,
        timeout: null,

        registerClick() {
            const now = Date.now();
            this.clicks.push(now);

            if (this.clicks.length > 3) {
                this.clicks.shift();
            }

            if (this.clicks.length === 3) {
                const diff = this.clicks[2] - this.clicks[0];

                if (diff <= this.threshold) {
                    this.triggerReveal();
                    this.clicks = [];
                }
            }
        },

        triggerReveal() {
            // Clear any existing timer
            if (this.timeout) {
                clearTimeout(this.timeout);
            }

            this.revealAll = true;

            // Hide again after 6 seconds
            this.timeout = setTimeout(() => {
                this.revealAll = false;
            }, 6000);
        }
    }"
>
    <flux:table>
        <flux:table.columns>
            <flux:table.column class="w-1/2">User</flux:table.column>
            <flux:table.column class="w-1/4">Status</flux:table.column>

            <flux:table.column
                class="w-1/4 select-none"
                @click="registerClick()"
            >
                Points
            </flux:table.column>

        </flux:table.columns>

        <flux:table.rows>
            @foreach($participants as $p)

                @php
                    $badge = $this->badgeMeta($p);
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

                            <span x-show="!revealAll">
                                {{ $this->displayPoints($p) }}
                            </span>

                            <span x-show="revealAll">
                                {{ $this->getSecretPoints($p) }}
                            </span>

                        </flux:text>
                    </flux:table.cell>

                </flux:table.row>

            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
