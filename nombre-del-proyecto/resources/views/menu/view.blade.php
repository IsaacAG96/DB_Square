<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Tabla</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <!-- Migas de pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('menu.gestionar') }}">Gestionar Tablas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver Tabla: {{ ucfirst(str_replace('_', ' ', $table)) }}</li>
        </ol>
    </nav>
    <!-- Fin de migas de pan -->

    <h3>Ver Tabla: {{ ucfirst(str_replace('_', ' ', $table)) }}</h3>
    <div class="card">
        <div class="card-body">
            @if ($data->isEmpty())
                <div class="alert alert-info" role="alert">
                    No hay datos disponibles en esta tabla.
                </div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @foreach ($data[0] as $key => $value)
                                <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                @foreach ($row as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('menu.gestionar') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
