<?php

use App\Enum\RoundStatus;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public Collection $participants;
    public ?int $currentParticipantId = null;
    #[Reactive]
    public array $votes = []; // participant_id => value
    #[Reactive]
    public RoundStatus $status;
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
                <flux:table.row
                    @class([
                        'bg-zinc-200/50 dark:bg-zinc-700/50' => isset($currentParticipantId) && $p['id'] === $currentParticipantId
                    ])
                >
                    {{-- Name --}}
                    <flux:table.cell @class([
            'font-bold' => isset($currentParticipantId) && $p['id'] === $currentParticipantId
        ])>{{ $p['name'] }}</flux:table.cell>

                    {{-- Status Badge --}}
                    <flux:table.cell>
                        @php
                            $badgeText = match($this->status) {
                                RoundStatus::VOTING => isset($votes[$p['id']]) ? 'Voted' : 'Waiting',
                                RoundStatus::REVEALED, RoundStatus::IDLE => 'Connected',
                            };

                            $badgeColor = match($this->status) {
                                RoundStatus::VOTING => isset($votes[$p['id']]) ? 'lime' : 'amber',
                                RoundStatus::REVEALED, RoundStatus::IDLE => 'blue',
                            };
                        @endphp

                        <flux:badge color="{{ $badgeColor }}" size="sm" inset="top bottom">
                            {{ $badgeText }}
                        </flux:badge>
                    </flux:table.cell>

                    {{-- Points column --}}
                    <flux:table.cell variant="strong">
                        <flux:text class="text-xs">
                            @if($status === RoundStatus::REVEALED)
                                {{ $votes[$p['id']] ?? '-' }}
                            @elseif($status === RoundStatus::VOTING)
                                Hidden
                            @else
                                -
                            @endif
                        </flux:text>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
