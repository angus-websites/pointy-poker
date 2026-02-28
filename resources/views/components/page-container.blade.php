<x-container>
    <div {{ $attributes->merge(['class' => 'mt-10 md:mt-15 pb-8']) }}>
        {{ $slot }}
    </div>
</x-container>
