<?php

namespace App\Http\Requests;

use App\Enums\TipoIdentificacion;
use App\Rules\TextoValido;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SolicitudAdministrador extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'administrador';
    }

    public function rules(): array
    {
        return [];
    }

    protected function reglasIdentificacion(string $tabla): array
    {
        $pasaporte = $this->input('tipo_identificacion') === TipoIdentificacion::Pasaporte->value;

        return [
            'tipo_identificacion' => ['bail', 'required', Rule::enum(TipoIdentificacion::class)],
            'numero_identificacion' => [
                'bail', 'required', 'string', new TextoValido, 'max:20',
                $pasaporte ? 'regex:/\A[A-Za-z0-9]+\z/' : 'regex:/\A[0-9]+\z/',
                Rule::unique($tabla, 'numero_identificacion'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Completa este campo.',
            'string' => 'Escribe un texto válido.',
            'max' => 'El valor supera la longitud o cantidad permitida.',
            'email' => 'Escribe un correo electrónico válido.',
            'tipo_identificacion.required' => 'Selecciona un tipo de identificación.',
            'tipo_identificacion.enum' => 'Selecciona un tipo de identificación válido.',
            'numero_identificacion.regex' => $this->input('tipo_identificacion') === TipoIdentificacion::Pasaporte->value
                ? 'Escribe el número de pasaporte usando solo letras y números.'
                : 'Escribe el número de identificación usando solo dígitos.',
            'unique' => 'La identificación ya está registrada.',
            'exists' => 'Selecciona un registro válido.',
            'date_format' => 'Selecciona una fecha válida.',
            'integer' => 'Escribe un número entero válido.',
            'in' => 'Selecciona una opción válida.',
        ];
    }
}
