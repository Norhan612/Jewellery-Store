@props([
     'name', 'value' => ''
    
    ])
<textarea 
    name="{{ $name }}" 
    @class([
        'form-control',
        'is-invalid' => $errors->has($name)
        ])
    >
{{ old($name, $value) }}</textarea>    

    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror