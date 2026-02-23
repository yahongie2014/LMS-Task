<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary px-8 py-3 rounded-2xl text-sm leading-none']) }}>
    {{ $slot }}
</button>

