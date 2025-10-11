@props([
    'name',
    'label' => null,
    'value' => '',
    'required' => false,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <input
        type="datetime-local"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value ? \Carbon\Carbon::parse($value)->format('Y-m-d\TH:i') : '') }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control']) }}
    >

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
