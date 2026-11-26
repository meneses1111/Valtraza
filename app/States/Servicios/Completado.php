<?php

namespace App\States\Servicios;

use App\Models\Servicio;
use Illuminate\Validation\ValidationException;

class Completado extends EstadoDelServicio
{
    public function establecer(Servicio $servicio, bool $tieneDiagnostico, bool $tieneActividad): void
    {
        if (! $tieneDiagnostico) {
            throw ValidationException::withMessages(['estado' => 'No puedes completar el servicio sin registrar al menos un diagnóstico.']);
        }

        if (! $tieneActividad) {
            throw ValidationException::withMessages(['estado' => 'Registra al menos una actividad de mantenimiento o reparación antes de completar el servicio.']);
        }

        $servicio->estado = 'completado';
    }
}
