@props(['name', 'label' => null, 'value' => old($name, 0), 'min' => 0, 'required' => false])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    <input type="number" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" min="{{ $min }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => 'form-control']) }}>
    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
