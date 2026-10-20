<?php

use App\Models\Room;
use App\Models\User;

test('privacy policy returns 200', function () {
    $this->get(route('privacy-policy'))
        ->assertStatus(200);
})->doesNotPerformAssertions();

test('version endpoint returns 200', function () {
    $this->get('/version')
        ->assertStatus(200);
});

test('info endpoint returns 200', function () {
    $this->getJson('/info')
        ->assertStatus(200);
});

test('authenticated user can visit rooms index', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('rooms.index'))
        ->assertStatus(200);
})->doesNotPerformAssertions();

test('authenticated user can visit a room', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create(['owner_id' => $user->id]);

    $this->actingAs($user);

    $this->get(route('rooms.show', ['code' => $room->code]))
        ->assertStatus(200);
})->doesNotPerformAssertions();
