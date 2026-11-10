<?php

namespace App\Events;

use App\Models\Turno;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TurnoActualizado implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(public Turno $turno)
    {
        $this->turno->loadMissing(['usuario', 'servicio']);
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('turnos'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'turno.actualizado';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->turno->id,
            'numero' => $this->turno->numero,
            'estado' => $this->turno->estado,
            'fecha' => $this->turno->fecha,
            'hora' => $this->turno->hora,
            'ciudadano' => $this->turno->usuario->nombre . ' ' . $this->turno->usuario->apellido,
            'servicio' => $this->turno->servicio->nombre,
        ];
    }
}
