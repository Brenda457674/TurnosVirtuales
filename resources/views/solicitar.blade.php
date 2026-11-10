<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar turno - TurnoFácil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="card shadow-sm mx-auto p-4" style="max-width: 600px;">

            <h2 class="text-center mb-2">Solicitar un turno</h2>

            <p class="text-center text-secondary">
                Completa tus datos para obtener tu turno.
            </p>

            {{-- Mensaje cuando el turno se genera correctamente --}}
            @if(session('turno_generado'))
                <div class="alert alert-success text-center">
                    <h4>¡Turno generado correctamente!</h4>

                    <h1 class="display-3 fw-bold">
                        {{ session('turno_generado') }}
                    </h1>

                    <p>
                        Servicio: {{ session('servicio_generado') }}
                    </p>

                    <p class="mb-0">
                        Conserva tu número para consultar tu atención.
                    </p>
                </div>
            @endif

            {{-- Mostrar errores de validación --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario para solicitar el turno --}}
            <form action="{{ route('turnos.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        placeholder="Ingresa tu nombre"
                        value="{{ old('nombre') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Apellido</label>

                    <input
                        type="text"
                        name="apellido"
                        class="form-control"
                        placeholder="Ingresa tu apellido"
                        value="{{ old('apellido') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="ejemplo@gmail.com"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Selecciona un servicio</label>

                    <select name="servicio_id" class="form-select" required>
                        <option value="">Selecciona un servicio</option>

                        @foreach($servicios as $servicio)
                            <option
                                value="{{ $servicio->id }}"
                                {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}
                            >
                                {{ $servicio->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Obtener mi turno
                </button>

                <a href="{{ route('inicio') }}" class="btn btn-outline-secondary w-100 mt-2">
                    Volver al inicio
                </a>

            </form>

        </div>
    </div>

</body>
</html>
