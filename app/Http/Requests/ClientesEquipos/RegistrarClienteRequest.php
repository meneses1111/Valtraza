<?php

namespace App\Http\Requests\ClientesEquipos;

use App\Http\Requests\SolicitudAdministrador;
use App\Rules\TextoValido;

class RegistrarClienteRequest extends SolicitudAdministrador
{
    public function rules(): array
    {
        return [
            'nombre' => ['bail', 'required', 'string', new TextoValido, 'max:100'],
            ...$this->reglasIdentificacion('cliente'),
            'correo' => ['bail', 'nullable', 'string', new TextoValido, 'max:100', 'email:rfc'],
        ];
    }
}
