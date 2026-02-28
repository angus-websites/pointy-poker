<?php

use App\Enum\RoundStatus;
use App\Models\Room;
use Livewire\Component;

new class extends Component {

    public Room $room;

    public ?RoundStatus $status = null;

    public function mount()
    {
        $this->status = $this->room->round()?->status;
    }

    public function getStatusMetaProperty(): array
    {
        return match ($this->status) {

            RoundStatus::IDLE => [
                'title' => 'Waiting to start',
                'description' => 'Waiting for the moderator to start the round. Once started, all users can submit their estimates.',
                'icon' => 'clock',
                'colorClasses' => 'text-amber-600 dark:text-amber-500',
            ],

            RoundStatus::VOTING => [
                'title' => 'Voting in progress',
                'description' => 'Submit your estimate by clicking on a point value. Once everyone has submitted, the moderator can reveal the results.',
                'icon' => 'clock',
                'colorClasses' => 'text-amber-700 dark:text-amber-500',
            ],

            RoundStatus::REVEALED => [
                'title' => 'Showing results',
                'description' => 'The results are revealed! The point values show the estimate submitted by each user. The moderator can start a new round when ready.',
                'icon' => 'clock',
                'colorClasses' => 'text-amber-700 dark:text-amber-500',
            ],

            default => [
                'title' => 'No round active',
                'description' => '',
                'icon' => 'clock',
                'colorClasses' => 'text-amber-700 dark:text-amber-500',
            ],
        };
    }
};
?>

@php
    $meta = $this->statusMeta;
@endphp

<div class="flex flex-col gap-y-5 md:flex-row md:items-end md:justify-between">
    <div>
        <div class="flex items-center gap-x-1.5">

            {{-- Status Icon --}}
            <flux:icon name="{{ $meta['icon'] }}" class="size-5  {{$meta['colorClasses']}}"/>

            <flux:heading size="lg" level="2">
                {{ $meta['title'] }}
            </flux:heading>

        </div>

        <flux:text class="mt-1">
            {{ $meta['description'] }}
        </flux:text>
    </div>
</div>
