<?php

use App\Services\RoomService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

new class extends Component {

    public string $roomCode;

    protected $rules = [
        'roomCode' => 'required|string|min:6|max:25|alpha_num',
    ];

    public function joinRoom(RoomService $roomService)
    {
        // Validate
        $this->validate();

        // Convert to uppercase
        $this->roomCode = strtoupper($this->roomCode);

        // Handle the logic to join a room here
        try {
            $room = $roomService->getRoomByCode($this->roomCode);
        } catch (ModelNotFoundException) {
            return $this->addError('roomCode', 'Room not found. Please check the code and try again.');
        }

        // Redirect to the room page
        return redirect()->route('rooms.show', ['code' => $room->code]);
    }
};
?>

<div>
    <form wire:submit.prevent="joinRoom">


        <flux:field>
            <label for="roomCode" class="block mb-2.5 text-sm font-medium text-heading">Join a Room</label>
            <!-- Input wrapper -->
            <div class="">

                <input
                    wire:model="roomCode"
                    type="text"
                    id="roomCode"
                    placeholder="ABC123"
                    required
                    class="uppercase px-5 py-7 font-mono text-2xl w-full border rounded-lg block
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
                   data-invalid:shadow-none "
                />



            </div>
            <flux:error name="roomCode"/>

            <button type="submit"
               class="mt-5 cursor-pointer w-fit mx-auto flex items-center justify-center rounded-md border border-transparent bg-zinc-500 hover:bg-zinc-600 dark:bg-zinc-500 dark:hover:bg-zinc-600 px-8 py-3 text-base font-medium text-white  md:px-8 md:py-3 md:text-lg">
                Join
            </button>
        </flux:field>

    </form>
</div>
