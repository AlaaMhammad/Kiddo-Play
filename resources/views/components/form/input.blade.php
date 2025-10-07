@props(['name', 'label' => null, 'type' => 'text', 'value' => old($name), 'required' => false])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control']) }}>
    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
