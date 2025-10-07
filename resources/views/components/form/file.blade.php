@props(['name', 'label' => null, 'required' => false])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    <input type="file" id="{{ $name }}" name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-control']) }}>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
