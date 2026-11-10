<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    public function turnos(): HasMany
    {
        return $this->hasMany(Turno::class, 'servicio_id');
    }
}
