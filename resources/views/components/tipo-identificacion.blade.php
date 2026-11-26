<div class="mb-3">
    <label for="tipo_identificacion" class="form-label">Tipo de identificación *</label>
    <select id="tipo_identificacion" name="tipo_identificacion" @class(['form-select', 'is-invalid' => $errors->has('tipo_identificacion')]) aria-describedby="ayuda-identificacion{{ $errors->has('tipo_identificacion') ? ' tipo_identificacion-error' : '' }}" required>
        <option value="">Selecciona un tipo</option>
        @foreach(\App\Enums\TipoIdentificacion::cases() as $tipo)
            <option value="{{ $tipo->value }}" @selected(old('tipo_identificacion') === $tipo->value)>{{ $tipo->etiqueta() }}</option>
        @endforeach
    </select>
    <div class="form-text" id="ayuda-identificacion">Usa solo números para cédulas y tarjeta de identidad. Para pasaporte puedes usar letras y números.</div>
    @error('tipo_identificacion')<div class="invalid-feedback" id="tipo_identificacion-error">{{ $message }}</div>@enderror
</div>
