<?php

use Illuminate\Support\Facades\Route;
use App\Models\Servicio;
use App\Models\Turno;
use App\Http\Controllers\CiudadanoController;
use App\Http\Controllers\AtencionController;

// Página principal
Route::get('/', function () {

    $servicios = Servicio::where('estado', 1)->get();

    $turnosLlamados = Turno::with('servicio')
        ->whereDate('fecha', now()->toDateString())
        ->where('estado', 'llamado')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('inicio', compact('servicios', 'turnosLlamados'));

})->name('inicio');


// Formulario para solicitar turno
Route::get('/solicitar-turno', function () {

    $servicios = Servicio::where('estado', 1)->get();

    return view('solicitar', compact('servicios'));

})->name('turnos.create');


// Guardar solicitud de turno
Route::post('/solicitar-turno', [CiudadanoController::class, 'store'])
    ->name('turnos.store');


// Pantalla de atención
Route::get('/atencion', [AtencionController::class, 'index'])
    ->name('atencion.index');


// Llamar siguiente turno
Route::post('/atencion/llamar', [AtencionController::class, 'llamarSiguiente'])
    ->name('atencion.llamar');


// Marcar turno como atendido
Route::post('/atencion/{id}/atender', [AtencionController::class, 'atender'])
    ->name('atencion.atender');
