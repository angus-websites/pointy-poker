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

        // Check for a guest cookie
        $cookie = request()->cookie('pokey_guest');

        if ($cookie) {

            // Decrypt and decode cookie content
            $guestData = json_decode(decrypt($cookie), true);

            return view('public.rooms.show', compact('room', 'guestData'));

        }

        // Show the onboarding page for this room
        return view('public.rooms.onboarding', compact('room'));

    }
}
