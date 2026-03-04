<?php

namespace App\Http\Controllers;

use App\Services\RoomService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RoomController extends Controller
{
    public function __construct(
        protected RoomService $roomService
    ) {}

    public function index(): Factory|View
    {
        return view('app.rooms.index');
    }

    public function show(string $code): Factory|View|RedirectResponse
    {
        $room = $this->roomService->getRoomByCode($code);

        $ownerCookieName = 'pokey_owner_'.$room->getId();
        $participantCookieName = 'pokey_participant_'.$room->getId();

        /*
        |--------------------------------------------------------------------------
        | 1. OWNER LOGIC
        |--------------------------------------------------------------------------
        */

        // If logged-in owner
        if (auth()->check() && $room->getOwnerId() === auth()->id()) {

            // If owner is not verified → force verification
            if (! auth()->user()->hasVerifiedEmail()) {
                return redirect()
                    ->route('verification.notice')
                    ->with('message', 'Please verify your email to access your room.');
            }

            // Store owner cookie for future detection
            cookie()->queue(
                cookie($ownerCookieName, encrypt(auth()->id()), 60 * 24 * 30) // 30 days
            );

            return view('app.rooms.show', compact('room'));
        }

        // If owner cookie exists but user is not authenticated → force login
        if (! auth()->check() && request()->hasCookie($ownerCookieName)) {

            // Set this route as intended so user is redirected back after login
            return redirect()->guest(route('login'))
                ->with('message', 'Please login to access your room.');

        }

        /*
        |--------------------------------------------------------------------------
        | 2. PARTICIPANT LOGIC
        |--------------------------------------------------------------------------
        */

        $cookie = request()->cookie($participantCookieName);

        if ($cookie) {

            try {
                $participantData = json_decode(decrypt($cookie), true);
                $participant = $room->getParticipantByToken($participantData['token'] ?? '');

                if (! $participant) {
                    cookie()->queue(cookie()->forget($participantCookieName));
                } else {
                    return view('public.rooms.show', compact('room', 'participant'));
                }

            } catch (\Throwable $e) {
                // Invalid / tampered cookie
                cookie()->queue(cookie()->forget($participantCookieName));
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. DEFAULT → ONBOARDING
        |--------------------------------------------------------------------------
        */

        return view('public.rooms.onboarding', compact('room'));
    }
}
