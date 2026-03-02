<?php

use App\Enum\RoundStatus;
use Livewire\Component;

new class extends Component {

    public RoundStatus $status;


    public function getStatusMetaProperty(): array
    {
        return match ($this->status) {

            RoundStatus::IDLE => [
                'description' => 'Waiting for the moderator to start the round. Once started, all users can submit their estimates.',
            ],

            RoundStatus::VOTING => [
                'description' => 'Submit your estimate by clicking on a point value. Once everyone has submitted, the moderator can reveal the results.',
            ],

            RoundStatus::REVEALED => [
                'description' => 'The results are revealed! The point values show the estimate submitted by each user. The moderator can start a new round when ready.',
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

        <livewire:rooms.status-header :status="$this->status"/>

        <flux:text class="mt-1">
            {{ $meta['description'] }}
        </flux:text>
    </div>
</div>
