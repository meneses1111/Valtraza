<?php

namespace App\Models;

use App\Enums\TipoIdentificacion;
use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    protected $table = 'tecnico';

    protected $primaryKey = 'id_tecnico';

    public $timestamps = false;

    protected $fillable = ['nombre', 'tipo_identificacion', 'numero_identificacion', 'correo'];

    protected function casts(): array
    {
        return ['tipo_identificacion' => TipoIdentificacion::class];
    }
}
