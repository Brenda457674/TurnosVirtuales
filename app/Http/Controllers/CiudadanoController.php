<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\Servicio;
use App\Models\Turno;

class CiudadanoController extends Controller
{
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'servicio_id' => 'required|exists:servicios,id',
        ]);

        $servicio = Servicio::where('estado', 1)
            ->findOrFail($datos['servicio_id']);

        // Comprobar si el correo ya pertenece a otro tipo de usuario
        $usuario = Usuario::where('email', $datos['email'])->first();

        if ($usuario && $usuario->rol !== 'ciudadano') {
            return back()->withInput()->withErrors([
                'email' => 'Este correo pertenece a una cuenta de trabajador o administrador.'
            ]);
        }

        $turno = DB::transaction(function () use ($datos, $servicio, $usuario) {

            if (!$usuario) {
                $usuario = Usuario::create([
                    'nombre' => $datos['nombre'],
                    'apellido' => $datos['apellido'],
                    'email' => $datos['email'],
                    'password' => Hash::make(Str::random(40)),
                    'rol' => 'ciudadano',
                ]);
            }

            $fecha = now()->toDateString();

            // Generar número correlativo del día
            $cantidad = Turno::whereDate('fecha', $fecha)->count();

            $numero = 'T' . str_pad($cantidad + 1, 4, '0', STR_PAD_LEFT);

            return Turno::create([
                'usuario_id' => $usuario->id,
                'servicio_id' => $servicio->id,
                'numero' => $numero,
                'fecha' => $fecha,
                'hora' => now()->format('H:i:s'),
                'estado' => 'pendiente',
            ]);
        });

        return redirect()->route('turnos.create')
            ->with('turno_generado', $turno->numero)
            ->with('servicio_generado', $servicio->nombre);
    }
}
