<?php

namespace App\Services\Servicios;

use App\Models\Servicio;
use App\Models\Usuario;
use App\Services\ClientesEquipos\RegistroClientesEquipos;
use App\Services\Tecnicos\RegistroTecnicos;
use App\Support\EntradaFormulario;
use App\Support\GuardarRegistro;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GestionServicios
{
    public function __construct(
        private RegistroClientesEquipos $clientes,
        private RegistroTecnicos $tecnicos
    ) {}

    public function obtener(int $id): Servicio
    {
        return Servicio::query()->with(['equipo.cliente', 'tecnico'])->findOrFail($id);
    }

    public function registrar(array $datos): Servicio
    {
        $equipo = $this->clientes->equipoDelCliente((int) $datos['id_equipo'], (int) $datos['id_cliente']);

        for ($intento = 0; $intento < 3; $intento++) {
            try {
                return DB::transaction(fn () => Servicio::query()->create([
                    'id_equipo' => $equipo->id_equipo,
                    'fecha' => $datos['fecha'],
                    'nombre' => $datos['nombre'],
                    'descripcion_problema' => $datos['descripcion_problema'],
                    'estado' => 'pendiente',
                ]), 3);
            } catch (QueryException $exception) {
                $estado = $exception->errorInfo[0] ?? null;

                if ($estado === '23505') {
                    continue;
                }

                if (in_array($estado, ['23503', '23514', '23502'], true)) {
                    throw ValidationException::withMessages(['registro' => 'Revisa el cliente, el computador y los datos del servicio.']);
                }

                throw $exception;
            }
        }

        throw ValidationException::withMessages(['registro' => 'No se pudo generar un código único. Intenta guardar nuevamente.']);
    }

    public function asignar(int $idServicio, int $idTecnico): Servicio
    {
        $tecnico = $this->tecnicos->obtener($idTecnico);

        return GuardarRegistro::ejecutar(function () use ($idServicio, $tecnico): Servicio {
            $servicio = Servicio::query()->lockForUpdate()->findOrFail($idServicio);
            $servicio->id_tecnico = $tecnico->id_tecnico;
            $servicio->save();

            return $servicio;
        });
    }
}
