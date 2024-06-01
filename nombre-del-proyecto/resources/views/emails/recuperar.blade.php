<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Clave DBSQUARE</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #F2F2F2; color: white; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #FFFFFF; padding: 20px; border-radius: 10px;">
        <div style="text-align: center;">
            <img src="{{ asset('images/logo_app.png') }}" alt="Logo" style="height: 50px;">
        </div>
        <div style="text-align: center;">
            <h2 style="font-size: 24px; color: #1E3D7A;">Hola, {{ $email }}</h2>
            <p style="font-size: 16px; color: #AAAAAA;">Haz clic en el enlace de abajo para recuperar las credenciales de inicio de sesión de tu cuenta de DBSQUARE:</p>
        </div>
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ url('password/reset/$token') }}" style="background-color: #5951D3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">RECUPERAR CLAVE</a>
        </div>
        <div style="text-align: center; font-size: 14px; color: #AAAAAA;">
            <p>Si no estás tratando de recuperar tus credenciales de inicio de sesión, ignora este correo electrónico. Es posible que otro usuario haya introducido su información de inicio de sesión de manera incorrecta.</p>
            <p>Saludos,<br>el equipo de DBSQUARE</p>
        </div>
    </div>
</body>
</html>

