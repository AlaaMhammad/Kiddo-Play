@props(['label' => 'Submit', 'type' => 'submit', 'variant' => 'primary'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-$variant"]) }}>
    {{ $label }}
</button>
