@props(['name', 'label' => null, 'value' => '', 'rows' => 3, 'required' => false])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control']) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
