<div class="flex flex-col md:flex-row md:items-end md:justify-between mt-2 mb-6 gap-4 md:gap-0">
    <div>
        <flux:heading size="{{ $size ?? 'xl' }}" level="{{ $level ?? '1' }}">
            {{ $heading }}
        </flux:heading>

        @isset($subtitle)
            <flux:text class="text-base mt-1 md:mt-2">
                {{ $subtitle }}
            </flux:text>
        @endisset
    </div>

    @if(trim($slot))
        <div class="flex md:justify-end">
            {{ $slot }}
        </div>
    @endif
</div>

<flux:separator variant="subtle" class="mb-10"/>
