<?php

namespace App\Http\Requests\Tecnicos;

use App\Http\Requests\SolicitudAdministrador;
use App\Rules\TextoValido;

class RegistrarTecnicoRequest extends SolicitudAdministrador
{
    public function rules(): array
    {
        return [
            'nombre' => ['bail', 'required', 'string', new TextoValido, 'max:100'],
            ...$this->reglasIdentificacion('tecnico'),
            'correo' => ['bail', 'nullable', 'string', new TextoValido, 'max:100', 'email:rfc'],
        ];
    }
}
