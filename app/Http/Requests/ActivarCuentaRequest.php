<?php

namespace App\Http\Requests;

use App\Rules\TextoValido;
use Illuminate\Foundation\Http\FormRequest;

class ActivarCuentaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'codigo_activacion' => ['bail', 'required', 'string', new TextoValido, 'max:64'],
            'password' => [
                'bail', 'required', 'string', 'min:8', 'confirmed',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (strlen($value) > 72) {
                        $fail('La contraseña es demasiado larga. Usa una más corta.');
                    }

                    if (str_contains($value, "\0")) {
                        $fail('Escribe una contraseña válida.');
                    }

                    if (! preg_match('/\p{L}/u', $value) || ! preg_match('/\p{Nd}/u', $value)
                        || ! preg_match('/[\p{P}\p{S}]/u', $value)) {
                        $fail('La contraseña debe incluir al menos una letra, un número y un carácter especial.');
                    }
                },
            ],
        ];
    }
}
