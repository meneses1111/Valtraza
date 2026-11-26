<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class CorreoDeCodigos
{
    public function activacion(?string $correo, string $usuario, string $codigo): ?bool
    {
        $enlace = rtrim(config('app.url'), '/').route('activar', absolute: false);

        return $this->enviar($correo, 'Activa tu cuenta de Valtraza',
            "Usuario: {$usuario}\nCódigo de activación: {$codigo}\n\nAbre {$enlace} y define tu contraseña.");
    }

    public function seguimiento(?string $correo, string $servicio, string $codigo): ?bool
    {
        $enlace = rtrim(config('app.url'), '/').route('inicio', absolute: false);

        return $this->enviar($correo, 'Seguimiento de tu servicio en Valtraza',
            "Servicio: {$servicio}\nCódigo de seguimiento: {$codigo}\n\nAbre {$enlace} e introduce el código para consultar el estado.");
    }

    private function enviar(?string $correo, string $asunto, string $texto): ?bool
    {
        if (! $correo) {
            return null;
        }

        try {
            return Mail::raw($texto, fn ($mensaje) => $mensaje->to($correo)->subject($asunto)) !== null;
        } catch (TransportExceptionInterface $exception) {
            $detail = strtolower($exception->getMessage());
            $reason = match (true) {
                str_contains($detail, 'authenticate'), str_contains($detail, '535'), str_contains($detail, '534') => 'autenticacion',
                str_contains($detail, 'certificate'), str_contains($detail, 'crypto') => 'tls',
                str_contains($detail, 'timed out'), str_contains($detail, 'timeout') => 'tiempo_de_espera',
                str_contains($detail, 'connection'), str_contains($detail, 'connect') => 'conexion',
                default => 'rechazo_del_transporte',
            };
            error_log('Valtraza: fallo de correo ('.$reason.').');

            return false;
        }
    }
}
