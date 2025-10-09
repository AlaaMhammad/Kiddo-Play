@props(['id' => null, 'name', 'value' => '', 'placeholder' => ''])

<textarea id="{{ $id ?? $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => 'form-control', 'rows' => 3]) }}>{{ old($name, $value) }}</textarea>

@error($name)
    <div class="text-danger small mt-1">{{ $message }}</div>
@enderror
