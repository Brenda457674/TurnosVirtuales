<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'rol'
    ];

    protected $hidden = [
        'password'
    ];

    public function turnos(): HasMany
    {
        return $this->hasMany(Turno::class, 'usuario_id');
    }
}
