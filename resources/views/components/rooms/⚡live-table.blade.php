<?php

use App\Models\Participant;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public Room $room;
    public ?Participant $currentParticipant = null;


    #[Computed]
    public function participants(): Collection
    {
        return $this->room->participants()->get();
    }
};
?>

<div>
    @if($this->participants->isEmpty())
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
                @foreach($this->participants as $p)
                    <flux:table.row
                        @class([
                            'bg-zinc-200/50 dark:bg-zinc-700/50' => isset($currentParticipant) && $p->id === $currentParticipant->id
                        ])
                    >
                        <flux:table.cell @class([
                                'font-bold' =>  isset($currentParticipant) && $p->id === $currentParticipant->id
                            ])>{{ $p['name'] }}</flux:table.cell>

                        <flux:table.cell>

                            <flux:badge color="amber" size="sm" inset="top bottom">
                                Dunno
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell variant="strong">
                            <flux:text class="text-xs">Hidden</flux:text>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @endif
</div>

