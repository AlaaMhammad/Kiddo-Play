@props(['name', 'label' => null, 'options' => [], 'value' => ''])

<div class="mb-3">
    @if($label)
        <label class="form-label d-block">{{ $label }}</label>
    @endif
    @foreach($options as $key => $option)
        <div class="form-check form-check-inline">
            <input class="form-check-input"
                    type="radio"
                    name="{{ $name }}"
                    id="{{ $name.'_'.$key }}"
                    value="{{ $key }}"
                    {{ old($name, $value) == $key ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $name.'_'.$key }}">{{ $option }}</label>
        </div>
    @endforeach
    @error($name)
        <div><small class="text-danger">{{ $message }}</small></div>
    @enderror
</div>
