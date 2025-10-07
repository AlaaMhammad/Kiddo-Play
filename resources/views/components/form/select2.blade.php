<select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => 'form-control']) }}>
    <option value="">{{ $placeholder ?? '-- Select --' }}</option>
    @foreach ($options as $key => $label)
        <option value="{{ $key }}" {{ old($name, $selected ?? '') == $key ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>

@error($name)
    <div class="text-danger small mt-1">{{ $message }}</div>
@enderror
@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => '-- Select --',
    'required' => false
])
