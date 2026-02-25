<?php

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Presence channel for a room
 */
Broadcast::channel('rooms.{roomId}', function (User $user, $roomId) {

    // Load room
    $room = Room::findOrFail($roomId);

    // If user is not creator or guest
    if (($user && $room->owner_id !== $user->id) || ! $user) {

        $cookie = request()->cookie('pokey_guest');
        if ($cookie) {
            $guest = json_decode(decrypt($cookie), true);

            return [
                'id' => $guest['id'],
                'name' => $guest['name'],
                'admin' => false,
            ];
        }
    }

    if ($user && $room->owner_id === $user->id) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'admin' => true,
        ];
    }

    return [];
}, ['guards' => ['web', 'guest']]);
