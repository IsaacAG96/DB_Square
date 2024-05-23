<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Tablas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        .profile-section img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .profile-button {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }
        .table-name {
            text-transform: capitalize;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Gestionar Tablas</h3>
        <div class="profile-section">
            @auth
                <a href="{{ route('profile.show') }}" class="profile-button">
                    <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://via.placeholder.com/50' }}" alt="Perfil">
                </a>
            @endauth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger mt-2">Cerrar sesión</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Lista de Tablas</h3>
        </div>
        <div class="card-body">
            @if ($tables->isEmpty())
                <div class="alert alert-info" role="alert">
                    No hay tablas disponibles para mostrar.
                </div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de la Tabla</th>
                            <th>Nº Registros</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table => $count)
                            <tr>
                                <td class="table-name">{{ str_replace('_', ' ', $table) }}</td>
                                <td>{{ $count }}</td>
                                <td>
                                    <a href="{{ route('table.view', ['table' => $table]) }}" class="btn btn-info btn-sm">Ver</a>
                                    <a href="{{ route('table.edit', ['table' => $table]) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('table.delete', ['table' => $table]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Añadir la paginación -->
                <div class="d-flex justify-content-center">
                    {{ $tables->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('menu.index') }}" class="btn btn-secondary">Volver al Menú</a>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
