<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Opciones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .profile-section {
            text-align: right;
        }
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
        .profile-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #555;
            margin-top: 5px;
        }
        .home-icon {
            font-size: 2em;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="header-content mb-3">
            <div>
                <a href="{{ url('/inicio') }}" class="home-icon">
                    <i class="fas fa-home"></i>
                </a>
            </div>
            <div>
                @auth
                    @if ($showWelcomeMessage)
                        <h3>Bienvenido, {{ Auth::user()->name }}</h3>
                    @endif
                @else
                    <h3>Bienvenido, Invitado</h3>
                @endauth
            </div>
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
                <h3>Menú de Opciones</h3>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ url('/menu/gestionar') }}" class="list-group-item list-group-item-action">
                        Gestionar tablas
                    </a>
                    <a href="#" class="list-group-item list-group-item-action disabled">
                        Crear una tabla
                    </a>
                    <a href="{{ url('/menu/importar') }}" class="list-group-item list-group-item-action">
                        Importar tablas
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
