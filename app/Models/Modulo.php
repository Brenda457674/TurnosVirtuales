<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modulo extends Model
{
    protected $table = 'modulos';

    protected $fillable = [
        'nombre',
        'trabajador_id',
        'estado'
    ];

    public function trabajador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'trabajador_id');
    }
}
