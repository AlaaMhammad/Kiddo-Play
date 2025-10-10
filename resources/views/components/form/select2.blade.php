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
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control']) }}>
        <option value="">{{ $placeholder }}</option>

        @foreach ($options as $option)
            @php
                // إذا كان Model أو Object نستخدم getter
                $value = is_object($option)
                    ? $option->{$optionValue}
                    : (is_array($option)
                        ? $option[$optionValue]
                        : $option);
                $labelText = is_object($option)
                    ? $option->{$optionLabel}
                    : (is_array($option)
                        ? $option[$optionLabel]
                        : $option);
            @endphp

            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                {{ $labelText }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
