
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de colas - TurnoFácil</title>

    @vite(['resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
            font-family: 'Segoe UI', sans-serif;
            color: #263449;
        }

        .navbar {
            background: #164eaa;
            padding: 18px;
        }

        .navbar-brand {
            color: white;
            font-weight: 800;
            font-size: 23px;
        }

        .main-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .btn-call {
            background: #2563eb;
            color: white;
            font-weight: 700;
            padding: 12px 22px;
        }

        .btn-call:hover {
            background: #164eaa;
            color: white;
        }

        #conexion {
            font-size: 13px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-ticket-perforated-fill"></i>
            TurnoFácil | Atención
        </a>
    </div>
</nav>

<div class="container py-5">

    <div class="mb-4">
        <h2 class="fw-bold">Gestión de colas</h2>
        <p class="text-secondary">
            Administra los turnos y atiende a los ciudadanos.
        </p>

        <span id="conexion" class="badge bg-secondary">
            <i class="bi bi-wifi"></i> Conectando...
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif

    <div class="card main-card p-4 mb-4">
        <h5 class="fw-bold mb-3">Llamar siguiente ciudadano</h5>

        <form action="{{ route('atencion.llamar') }}" method="POST">
            @csrf

            <button type="submit" class="btn btn-call">
                <i class="bi bi-megaphone-fill"></i>
                Llamar siguiente turno
            </button>
        </form>
    </div>

    <div class="card main-card p-4">

        <h5 class="fw-bold mb-4">Turnos pendientes y llamados</h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Número</th>
                        <th>Ciudadano</th>
                        <th>Servicio</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($turnos as $turno)

                        <tr>
                            <td class="fw-bold">
                                {{ $turno->numero }}
                            </td>

                            <td>
                                {{ $turno->usuario->nombre }}
                                {{ $turno->usuario->apellido }}
                            </td>

                            <td>
                                {{ $turno->servicio->nombre }}
                            </td>

                            <td>
                                {{ $turno->hora }}
                            </td>

                            <td>
                                @if($turno->estado == 'pendiente')
                                    <span class="badge bg-warning text-dark">
                                        Pendiente
                                    </span>
                                @elseif($turno->estado == 'llamado')
                                    <span class="badge bg-primary">
                                        Llamado
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Atendido
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($turno->estado == 'llamado')

                                    <form action="{{ route('atencion.atender', $turno->id) }}"
                                          method="POST">
                                        @csrf

                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i>
                                            Atendido
                                        </button>
                                    </form>

                                @else
                                    <span class="text-secondary">En espera</span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-4">
                                No hay turnos pendientes ni llamados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">
        <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver al inicio
        </a>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const indicador = document.getElementById('conexion');

        if (!window.Echo) {
            indicador.className = 'badge bg-danger';
            indicador.innerHTML = 'WebSocket no configurado';
            return;
        }

        const conexion = window.Echo.connector.pusher.connection;

        conexion.bind('connected', function () {
            indicador.className = 'badge bg-success';
            indicador.innerHTML = '<i class="bi bi-wifi"></i> Conectado en tiempo real';
        });

        conexion.bind('disconnected', function () {
            indicador.className = 'badge bg-danger';
            indicador.innerHTML = '<i class="bi bi-wifi-off"></i> Desconectado';
        });

        conexion.bind('error', function () {
            indicador.className = 'badge bg-danger';
            indicador.innerHTML = 'Error de conexión';
        });

        window.Echo.channel('turnos')
            .listen('.turno.actualizado', function (evento) {

                console.log('Turno actualizado:', evento);

                window.location.reload();

            });

    });
</script>

</body>
</html>
