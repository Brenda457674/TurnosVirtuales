<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Turno extends Model
{
    protected $table = 'turnos';

    protected $fillable = [
        'usuario_id',
        'servicio_id',
        'numero',
        'fecha',
        'hora',
        'estado'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function historial(): HasMany
    {
        return $this->hasMany(HistorialTurno::class, 'turno_id');
    }
}
