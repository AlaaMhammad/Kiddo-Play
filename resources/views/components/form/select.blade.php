@props([
    'name',
    'label' => null,
    'options' => [],
    'optionLabel' => 'name',
    'optionValue' => 'id',
    'placeholder' => '-- Select --',
    'required' => false,
    'selected' => null,
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <select name="{{ $name }}" id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control']) }}>
        <option value="">{{ $placeholder }}</option>

        @foreach ($options as $key => $option)
            @if(is_array($option))
                <option value="{{ $option[$optionValue] }}"
                    {{ old($name, $selected) == $option[$optionValue] ? 'selected' : '' }}>
                    {{ $option[$optionLabel] }}
                </option>
            @else
                <option value="{{ $key }}"
                    {{ old($name, $selected) == $key ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endif
        @endforeach
    </select>

    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
