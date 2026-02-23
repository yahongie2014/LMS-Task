@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-[10px] uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
