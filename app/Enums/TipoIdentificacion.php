<?php

namespace App\Enums;

enum TipoIdentificacion: string
{
    case Cedula = 'CC';
    case TarjetaIdentidad = 'TI';
    case CedulaExtranjeria = 'CE';
    case Pasaporte = 'PA';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Cedula => 'Cédula de ciudadanía',
            self::TarjetaIdentidad => 'Tarjeta de identidad',
            self::CedulaExtranjeria => 'Cédula de extranjería',
            self::Pasaporte => 'Pasaporte',
        };
    }
}
