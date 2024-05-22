<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Tablas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .check-icon {
            font-size: 1.5em;
            color: green;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Importar Tablas</h3>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Tablas Disponibles</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tabla</th>
                        <th>Campos</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tables as $table => $columns)
                        <tr>
                            <td><strong>{{ ucfirst(str_replace('_', ' ', $table)) }}</strong></td>
                            <td>{{ implode(', ', array_map('ucfirst', array_map('str_replace', array_fill(0, count($columns), '_'), array_fill(0, count($columns), ' '), $columns))) }}</td>
                            <td class="text-end">
                                @if ($importedTables[$table])
                                    <span class="check-icon">&#10003;</span>
                                @else
                                    <form method="POST" action="{{ route('menu.importTable') }}">
                                        @csrf
                                        <input type="hidden" name="table" value="{{ $table }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Importar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-end">
            {{ $tables->links('vendor.pagination.bootstrap-4') }}
            <a href="{{ route('menu.index') }}" class="btn btn-secondary">Volver al Menú</a>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
