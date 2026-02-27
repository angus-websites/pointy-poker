<?php

namespace App\Http\Controllers;

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

        // Check for a participant cookie
        $cookie = request()->cookie('pokey_participant_'.$room->id);

        if ($cookie) {

            // Decrypt and decode cookie content
            $participantData = json_decode(decrypt($cookie), true);

            // Check if the token matches a participant in this room
            $participant = $room->participants()
                ->where('token', $participantData['token'])
                ->first();

            if (! $participant) {
                // Delete the invalid cookie
                cookie()->queue(cookie()->forget('pokey_participant_'.$room->id));
            }

            // Otherwise show the room view with participant data
            return view('public.rooms.show', compact('room', 'participant'));

        }

        // Show the onboarding page for this room
        return view('public.rooms.onboarding', compact('room'));

    }
}
