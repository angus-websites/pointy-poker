<?php

namespace App\Http\Controllers;

use App\Events\ParticipantJoined;
use App\Services\RoomService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class RoomController extends Controller
{
    public function __construct(
        protected RoomService $roomService
    ) {}

    public function index(): Factory|View
    {
        $rooms = $this->roomService->getOwnedRooms(auth()->user());

        return view('app.rooms.index', compact('rooms'));
    }

    public function show(string $slug): Factory|View
    {
        $room = $this->roomService->getRoomBySlug($slug);

        // If logged-in user is the owner of the room, redirect to app view
        if (auth()->check() && $room->owner_id === auth()->id()) {
            return view('app.rooms.show', compact('room'));
        }

        // Look for a token for this room
        $token = request()->cookie('room_token_'.$room->id);

        // If a token exists, check if it's valid for this room
        if ($token) {

            // Try and find a participant for this token and room
            $participant = $this->roomService->getParticipantByToken(
                $room->id,
                $token
            );

            // If the participant exists, join the room
            if ($participant) {

                // TODO Update the participant's last active timestamp

                broadcast(new ParticipantJoined($participant))->toOthers();

                return view('public.rooms.show', compact('room', 'participant'));
            }

            // If no participant found for this token, delete the cookie
            else {
                cookie()->queue(cookie()->forget('room_token_'.$room->id));
            }

        }

        // Show the onboarding page for this room
        return view('public.rooms.onboarding', compact('room'));
    }
}
