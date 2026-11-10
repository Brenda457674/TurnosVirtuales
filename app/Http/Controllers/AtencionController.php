<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Turno;
use App\Events\TurnoActualizado;

class AtencionController extends Controller
{
    public function index()
    {
        $turnos = Turno::with(['usuario', 'servicio'])
            ->whereIn('estado', ['pendiente', 'llamado'])
            ->orderBy('fecha')
            ->orderBy('hora')
            ->orderBy('id')
            ->get();

        return view('atencion', compact('turnos'));
    }

    public function llamarSiguiente()
    {
        $turno = DB::transaction(function () {
            $turno = Turno::where('estado', 'pendiente')
                ->orderBy('fecha')
                ->orderBy('hora')
                ->orderBy('id')
                ->lockForUpdate()
                ->first();

            if ($turno) {
                $turno->update([
                    'estado' => 'llamado'
                ]);

                $turno->load(['usuario', 'servicio']);
            }

            return $turno;
        });

        if (!$turno) {
            return back()->with('error', 'No hay turnos pendientes.');
        }

        event(new TurnoActualizado($turno));

        return back()->with(
            'success',
            'Se está llamando al turno ' . $turno->numero
        );
    }

    public function atender($id)
    {
        $turno = Turno::with(['usuario', 'servicio'])->findOrFail($id);

        if ($turno->estado !== 'llamado') {
            return back()->with('error', 'Este turno no está llamado.');
        }

        $turno->update([
            'estado' => 'atendido'
        ]);

        $turno->load(['usuario', 'servicio']);

        event(new TurnoActualizado($turno));

        return back()->with(
            'success',
            'El turno ' . $turno->numero . ' fue atendido correctamente.'
        );
    }
}
