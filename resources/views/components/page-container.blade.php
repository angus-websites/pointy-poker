<x-container>
    <div {{ $attributes->merge(['class' => 'pt-16 pb-8 md:mt-16']) }}>
        {{ $slot }}
    </div>
</x-container>
