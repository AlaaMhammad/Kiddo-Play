@props(['name', 'label' => null, 'checked' => false])

<div class="form-check mb-3">
    <input type="checkbox"
            id="{{ $name }}"
            name="{{ $name }}"
            value="1"
            {{ old($name, $checked) ? 'checked' : '' }}
            {{ $attributes->merge(['class' => 'form-check-input']) }}>
    @if($label)
        <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
    @endif
</div>
@error($name)
    <small class="text-danger">{{ $message }}</small>
@enderror
