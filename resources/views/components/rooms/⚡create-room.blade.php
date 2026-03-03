<?php

use App\Services\RoomService;
use Flux\Flux;
use Livewire\Component;

new class extends Component {

    public string $name = '';

    protected array $rules = [
        'name' => 'required|string|max:150',
    ];

    public function save(RoomService $roomService): void
    {
        // Validate input
        $data = $this->validate();

        // Create entry
        $roomService->create(
            name: $data['name'],
        );

        Flux::toast(
            text: "Your room has been created successfully.",
            variant: 'success',
        );

        // Dispatch event to allow other components to update
        $this->dispatch('rooms:refresh');

        // Close modal
        Flux::modal('new-room')->close();

        // Reset form
        $this->reset();
    }
};
?>

<div>
    <flux:modal.trigger name="new-room">
        <flux:button variant="primary">New Room</flux:button>
    </flux:modal.trigger>

    <flux:modal name="new-room" class="md:w-96">
        <form class="space-y-6" wire:submit.prevent="save">
            <div>
                <flux:heading size="lg">New Room</flux:heading>
                <flux:text class="mt-2">Enter details for a new room...</flux:text>
            </div>

            <flux:input required wire:model="name" label="Name" placeholder="e.g Backlog Refinement"/>

            <div class="flex">
                <flux:spacer/>

                <flux:button type="submit" variant="primary">Create</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
