<?php

namespace App\Events;

use App\Models\Participant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Event that is fired when a participant joins a room.
 * This event is broadcasted to all other participants in the room so they can update their UI accordingly.
 */
class ParticipantJoined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public string $name;

    public int $participantId;

    /**
     * Create a new event instance.
     */
    public function __construct(Participant $participant)
    {
        $this->roomId = $participant->room_id;
        $this->name = $participant->display_name;
        $this->participantId = $participant->id;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel("room.{$this->roomId}");
    }

    public function broadcastWith(): array
    {
        return [
            'participant_id' => $this->participantId,
            'display_name' => $this->name,
            'room_id' => $this->roomId,
            'joined_at' => now()->toISOString(),
        ];
    }
}
