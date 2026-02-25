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
Broadcast::channel('rooms.{roomId}', function (?User $user, $roomId) {

    $room = Room::findOrFail($roomId);

    if ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'admin' => $room->user_id === $user->id,
        ];
    }

    if (session()->has('guest_name')) {
        return [
            'id' => session('guest_uuid'),
            'name' => session('guest_name'),
            'admin' => false,
        ];
    }

    return false;
});
