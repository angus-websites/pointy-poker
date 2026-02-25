<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GuestVoted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $roomId,
        public string $guestId,
        public string $point,

    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel("rooms.{$this->roomId}");
    }

    public function broadcastAs(): string
    {
        return 'guestVoted';
    }

    public function broadcastWith(): array
    {
        return [
            'guestId' => $this->guestId,
            'point' => $this->point,
        ];
    }
}
