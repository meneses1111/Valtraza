<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CambioServicio extends Model
{
    protected $table = 'cambio_servicio';

    public $timestamps = false;

    protected $fillable = ['descripcion'];
}
