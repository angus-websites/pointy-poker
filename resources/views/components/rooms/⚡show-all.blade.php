<?php

use App\Services\RoomService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {

    #[On('rooms:refresh')]
    #[Computed]
    public function rooms()
    {
        return app(RoomService::class)->paginateRooms();
    }
};
?>

<div>
    <ul class="gap-y-4 flex flex-col">
        @forelse ($this->rooms as $room)
            <li wire:key="{{ $room->id }}">
                <a href="{{route('rooms.show', ['code' => $room->code])}}" aria-label="Go to {{ $room->name }} room"
                   wire:navigate>
                    <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <flux:heading class="flex items-center gap-2">{{ $room->name }}
                            <flux:icon name="arrow-up-right" class="ml-auto text-zinc-400" variant="micro"/>
                        </flux:heading>
                        <flux:text class="mt-2">
                            Created {{ $room->created_at->diffForHumans() }}
                        </flux:text>
                    </flux:card>
                </a>
            </li>
        @empty
            <div class="text-center my-5">
                <svg width="100%" height="100%" viewBox="0 0 200 200" version="1.1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
                     class="mx-auto size-12 text-gray-400 dark:text-gray-500"
                     style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                <g transform="matrix(1,0,0,1,0,-770)">
                    <g id="Favicon" transform="matrix(0.353982,0,0,0.425532,0,132.12766)">
                        <rect x="0" y="1499" width="565" height="470" style="fill:none;"/>
                        <g transform="matrix(39.131481,0,0,25.18449,5396.595112,468.877083)">
                            <g transform="matrix(0.153409,0,0,0.198287,-227.337773,-4.691214)">
                                <path
                                    d="M674,255L674,299C674,311.142 664.142,321 652,321L608,321C595.858,321 586,311.142 586,299L586,255C586,242.858 595.858,233 608,233L652,233C664.142,233 674,242.858 674,255ZM670.706,255C670.706,244.676 662.324,236.294 652,236.294L608,236.294C597.676,236.294 589.294,244.676 589.294,255L589.294,299C589.294,309.324 597.676,317.706 608,317.706L652,317.706C662.324,317.706 670.706,309.324 670.706,299L670.706,255Z"
                                    style="fill:rgb(181,181,181);"/>
                            </g>
                            <g transform="matrix(0.153409,0,0,0.198287,-225.744263,-4.096354)">
                                <path
                                    d="M599.5,245C604.743,245 609,249.257 609,254.5C609,259.743 604.743,264 599.5,264C594.257,264 590,259.743 590,254.5C590,249.257 594.257,245 599.5,245ZM599.5,248.294C596.075,248.294 593.294,251.075 593.294,254.5C593.294,257.925 596.075,260.706 599.5,260.706C602.925,260.706 605.706,257.925 605.706,254.5C605.706,251.075 602.925,248.294 599.5,248.294Z"
                                    style="fill:rgb(181,181,181);"/>
                            </g>
                            <g transform="matrix(0.153409,0,0,0.198287,-219.573329,-4.096354)">
                                <path
                                    d="M599.5,245C604.743,245 609,249.257 609,254.5C609,259.743 604.743,264 599.5,264C594.257,264 590,259.743 590,254.5C590,249.257 594.257,245 599.5,245ZM599.5,248.294C596.075,248.294 593.294,251.075 593.294,254.5C593.294,257.925 596.075,260.706 599.5,260.706C602.925,260.706 605.706,257.925 605.706,254.5C605.706,251.075 602.925,248.294 599.5,248.294Z"
                                    style="fill:rgb(181,181,181);"/>
                            </g>
                            <g transform="matrix(0.153409,0,0,0.198287,-225.803682,-4.691214)">
                                <path
                                    d="M646,296.25L646,302.75C646,304.544 644.544,306 642.75,306L597.25,306C595.456,306 594,304.544 594,302.75L594,296.25C594,294.456 595.456,293 597.25,293L642.75,293C644.544,293 646,294.456 646,296.25ZM597.294,296.294L597.294,302.706L642.706,302.706L642.706,296.294L597.294,296.294Z"
                                    style="fill:rgb(181,181,181);"/>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
                <flux:heading level="2" size="lg" class="mt-2 text-base font-semibold text-gray-900 dark:text-white">
                    No rooms yet
                </flux:heading>
                <flux:text class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Create your first room to get started!
                </flux:text>
            </div>
        @endforelse

    </ul>
    @if($this->rooms->hasPages())
        <div class="mt-4">
            {{ $this->rooms->links() }}
        </div>
    @endif
</div>
