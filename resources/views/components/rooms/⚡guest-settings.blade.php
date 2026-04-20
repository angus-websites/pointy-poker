<?php

use Livewire\Component;
use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;

new class extends Component
{
    public RoomContract $room;
    public ParticipantContract $participant;

    public string $name = '';

    protected array $rules = [
        'name' => 'required|string|min:2|max:25',
    ];

    public function changeName()
    {
        $this->validate();

        $this->participant->updateName($this->name);

        // Reset the name field
        $this->reset('name');

        // Emit name updated event
        $this->dispatch('name-updated', name: $this->name);

        // Close modal
        Flux::modal('edit-name')->close();

        // Show toast notification
        Flux::toast(variant: 'success', text: 'Name updated');

    }

    public function clearCookies()
    {
        // Remove the cookie for this room
        $participantCookieName = 'pokey_participant_' . $this->room->getId();
        cookie()->queue(cookie()->forget($participantCookieName));

        // Refresh the page
        $this->js('window.location.reload()');

    }
};
?>

<div>
    <flux:dropdown>
        <flux:button icon="ellipsis-horizontal"/>

        <flux:menu>

            <flux:modal.trigger name="edit-name">
                <flux:menu.item icon="pencil-square">Change Name</flux:menu.item>
            </flux:modal.trigger>

            <flux:menu.separator/>


            <flux:modal.trigger name="clear-cookies">
                <flux:menu.item variant="danger" icon="trash">Clear cookies</flux:menu.item>
            </flux:modal.trigger>
        </flux:menu>
    </flux:dropdown>

    <flux:modal name="edit-name" class="md:w-96">
        <form class="space-y-6" wire:submit.prevent="changeName">
            <div>
                <flux:heading size="lg">Change name</flux:heading>
                <flux:text class="mt-2">Enter your new name below...</flux:text>
            </div>

            <flux:input wire:model="name" label="Name" placeholder="Your name"/>

            <div class="flex">
                <flux:spacer/>

                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="clear-cookies" class="min-w-[22rem]">
        <form class="space-y-6" wire:submit.prevent="clearCookies">
            <div>
                <flux:heading size="lg">Clear cookies?</flux:heading>

                <flux:text class="mt-2">
                    This will clear your cookies for this room,<br> you will need to re-enter your name to join again. Are you sure you want to continue?
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer/>

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger">Clear cookies</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
