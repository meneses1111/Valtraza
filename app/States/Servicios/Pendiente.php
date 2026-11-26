<?php

namespace App\States\Servicios;

use App\Models\Servicio;

class Pendiente extends EstadoDelServicio
{
    public function establecer(Servicio $servicio, bool $tieneDiagnostico, bool $tieneActividad): void
    {
        $servicio->estado = 'pendiente';
    }
}
