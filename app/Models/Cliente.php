<?php

namespace App\Models;

use App\Enums\TipoIdentificacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $primaryKey = 'id_cliente';

    public $timestamps = false;

    protected $fillable = ['nombre', 'tipo_identificacion', 'numero_identificacion', 'correo'];

    protected function casts(): array
    {
        return ['tipo_identificacion' => TipoIdentificacion::class];
    }

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class, 'id_cliente', 'id_cliente')->orderByDesc('id_equipo');
    }
}
