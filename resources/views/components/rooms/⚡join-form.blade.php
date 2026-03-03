<?php

use App\Services\RoomService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

new class extends Component {

    public string $roomCode;

    protected $rules = [
        'roomCode' => 'required|string|min:6|max:6|alpha_num',
    ];

    public function joinRoom(RoomService $roomService)
    {

        // Validate
        $this->validate();

        // Handle the logic to join a room here
        try {
            $room = $roomService->getRoomBySlug($this->roomCode);
        } catch (ModelNotFoundException)
        {
            $this->addError('roomCode', 'Room not found. Please check the code and try again.');
            return;
        }

        // Redirect to the room page
        return redirect()->route('rooms.show', ['room' => $room->slug]);
    }
};
?>

<div>
    <form wire:submit.prevent="joinRoom">
        <label for="visitors" class="block mb-2.5 text-sm font-medium text-heading">Join a Room</label>

        <div class="flex flex-row gap-5 items-center">

            <!-- Input wrapper -->
            <div class="relative w-full">

                <input
                    wire:model="roomCode"
                    type="text"
                    id="visitors"
                    placeholder="ABC123"
                    required
                    class="px-5 py-7 font-mono text-2xl w-full border rounded-lg block
                   disabled:shadow-none dark:shadow-none appearance-none h-10
                   leading-5.5 ps-3 pe-20   <!-- extra right padding -->
                   bg-white dark:bg-white/10 dark:disabled:bg-white/7
                   text-zinc-700 disabled:text-zinc-500
                   placeholder-zinc-400 disabled:placeholder-zinc-400/70
                   dark:text-zinc-300 dark:disabled:text-zinc-400
                   dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500
                   shadow-xs border-zinc-200 border-b-zinc-300/80
                   disabled:border-b-zinc-200
                   dark:border-white/10 dark:disabled:border-white/5
                   data-invalid:shadow-none data-invalid:border-red-500
                   dark:data-invalid:border-red-500
                   disabled:data-invalid:border-red-500
                   dark:disabled:data-invalid:border-red-500"
                />

                <!-- Button inside input -->
                <button
                    type="submit"
                    class="absolute inset-y-0 right-2 my-auto
                   h-8 px-3 text-xs rounded
                   text-white bg-slate-600 hover:bg-slate-700 dark:text-slate-800 dark:bg-slate-200 dark:hover:bg-slate-300
                   border border-transparent shadow-xs
                   cursor-pointer
                   focus:ring-4 focus:ring-brand-medium
                   focus:outline-none"
                >
                    Join
                </button>


            </div>


        </div>

    </form>
</div>
