
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TurnoFácil | Atención Ciudadana</title>

    @vite(['resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f7fb;
            color: #263449;
        }

        .navbar {
            background: white;
            padding: 18px 0;
        }

        .brand {
            color: #2563eb;
            font-size: 23px;
            font-weight: 800;
        }

        .hero {
            background: linear-gradient(120deg, #164eaa, #3478e5);
            color: white;
            padding: 75px 0;
            border-radius: 0 0 35px 35px;
        }

        .hero h1 {
            font-size: 42px;
            font-weight: 800;
        }

        .hero p {
            color: #e4edff;
            font-size: 17px;
        }

        .btn-turno {
            background: white;
            color: #2563eb;
            padding: 13px 25px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            transition: .3s;
        }

        .btn-turno:hover {
            background: #eaf1ff;
            color: #164eaa;
            transform: translateY(-2px);
        }

        .section-title {
            font-weight: 800;
            color: #1e293b;
        }

        .service-card {
            background: white;
            border: none;
            border-radius: 16px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
            transition: .3s;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,.09);
        }

        .service-icon {
            width: 55px;
            height: 55px;
            background: #eaf1ff;
            color: #2563eb;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-bottom: 18px;
        }

        .service-link {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
        }

        .service-link:hover {
            color: #164eaa;
        }

        .step-number {
            width: 42px;
            height: 42px;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .turno-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
            height: 100%;
        }

        .turno-numero {
            color: #2563eb;
            font-size: 30px;
            font-weight: 800;
        }

        footer {
            background: #172b4d;
            color: white;
            padding: 30px 0;
        }

        @media(max-width: 768px) {
            .hero h1 {
                font-size: 32px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">

        <a class="navbar-brand brand" href="{{ route('inicio') }}">
            <i class="bi bi-ticket-perforated-fill"></i>
            TurnoFácil
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-3">

                <li class="nav-item">
                    <a class="nav-link" href="#inicio">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#servicios">Servicios</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#turnos">Turnos llamados</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#como-funciona">¿Cómo funciona?</a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-primary px-4" href="#servicios">
                        Solicitar turno
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- PRESENTACIÓN -->
<section class="hero" id="inicio">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <span class="badge bg-light text-primary mb-3 p-2">
                    ATENCIÓN CIUDADANA DIGITAL
                </span>

                <h1>
                    Tu tiempo es importante.<br>
                    Evita las largas colas.
                </h1>

                <p class="mt-3 mb-4">
                    Obtén tu turno virtual de manera rápida y sencilla.
                    Consulta el estado de tu atención desde cualquier lugar.
                </p>

                <a href="#servicios" class="btn-turno">
                    <i class="bi bi-ticket-perforated"></i>
                    Obtener mi turno
                </a>

            </div>

            <div class="col-lg-5 text-center mt-5 mt-lg-0">

                <i class="bi bi-calendar2-check"
                   style="font-size: 150px; color: #dbeafe;">
                </i>

            </div>

        </div>

    </div>
</section>

<!-- SERVICIOS -->
<section class="container py-5" id="servicios">

    <div class="text-center mb-5">

        <h2 class="section-title">Nuestros servicios</h2>

        <p class="text-secondary">
            Selecciona el servicio que necesitas para solicitar tu turno.
        </p>

    </div>

    <div class="row g-4">

        @forelse($servicios as $servicio)

            <div class="col-md-4">

                <div class="service-card">

                    <div class="service-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>

                    <h5>{{ $servicio->nombre }}</h5>

                    <p class="text-secondary">
                        {{ $servicio->descripcion }}
                    </p>

                    <a href="{{ route('turnos.create') }}" class="service-link">
                        Solicitar turno
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        @empty

            <div class="col-12 text-center">
                <div class="service-card">
                    <i class="bi bi-info-circle text-primary"
                       style="font-size: 40px;"></i>

                    <h5 class="mt-3">No hay servicios disponibles</h5>

                    <p class="text-secondary mb-0">
                        Por el momento no existen servicios registrados.
                    </p>
                </div>
            </div>

        @endforelse

    </div>

</section>

<!-- TURNOS LLAMADOS EN TIEMPO REAL -->
<section class="container py-5" id="turnos">

    <div class="text-center mb-4">

        <h2 class="section-title">Turnos llamados</h2>

        <p class="text-secondary">
            Consulta los turnos que están siendo atendidos actualmente.
        </p>

        <span id="estado-conexion" class="badge bg-secondary">
            <i class="bi bi-wifi"></i>
            Conectando al servidor...
        </span>

    </div>

    <div class="row g-4" id="lista-turnos">

        @forelse($turnosLlamados as $turno)

            <div class="col-md-4">

                <div class="turno-card">

                    <div class="turno-numero">
                        {{ $turno->numero }}
                    </div>

                    <h6 class="fw-bold mt-2">
                        {{ $turno->servicio->nombre }}
                    </h6>

                    <span class="badge bg-primary">
                        En atención
                    </span>

                </div>

            </div>

        @empty

            <div class="col-12 text-center" id="sin-turnos">
                <p class="text-secondary">
                    Actualmente no hay turnos llamados.
                </p>
            </div>

        @endforelse

    </div>

</section>

<!-- COMO FUNCIONA -->
<section class="container py-5" id="como-funciona">

    <div class="text-center mb-5">

        <h2 class="section-title">¿Cómo funciona?</h2>

        <p class="text-secondary">
            Obtener tu turno es muy sencillo.
        </p>

    </div>

    <div class="row g-4 text-center">

        <div class="col-md-4">
            <div class="step-number mx-auto">1</div>
            <h5>Selecciona un servicio</h5>
            <p class="text-secondary">
                Elige el tipo de atención que necesitas.
            </p>
        </div>

        <div class="col-md-4">
            <div class="step-number mx-auto">2</div>
            <h5>Obtén tu turno</h5>
            <p class="text-secondary">
                El sistema genera tu número de atención.
            </p>
        </div>

        <div class="col-md-4">
            <div class="step-number mx-auto">3</div>
            <h5>Espera tu llamado</h5>
            <p class="text-secondary">
                Consulta el avance de la cola en tiempo real.
            </p>
        </div>

    </div>

</section>

<!-- PIE DE PÁGINA -->
<footer class="text-center">

    <div class="container">

        <h5 class="fw-bold">
            <i class="bi bi-ticket-perforated-fill"></i>
            TurnoFácil
        </h5>

        <p class="mb-1">
            Sistema Web de Turnos Virtuales
        </p>

        <small>
            © 2026 - Atención ciudadana digital
        </small>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const indicador = document.getElementById('estado-conexion');

        if (!window.Echo) {
            indicador.className = 'badge bg-danger';
            indicador.textContent = 'WebSocket no configurado';
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
            indicador.textContent = 'Error de conexión';
        });

        window.Echo.channel('turnos')
            .listen('.turno.actualizado', function (evento) {

                console.log('Notificación recibida:', evento);

                // Actualizar la sección de turnos llamados.
                window.location.reload();

            });

    });
</script>

</body>
</html>
