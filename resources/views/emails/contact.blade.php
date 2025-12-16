<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo mensaje</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="background:white; padding:20px; border-radius:8px;">
        <h2>📩 Nuevo mensaje de contacto</h2>

        <p><strong>Nombre:</strong> {{ $data['name'] }} {{ $data['lastname'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Teléfono:</strong> {{ $data['phone'] }}</p>
        <p><strong>Asunto:</strong> {{ $data['subject'] }}</p>

        <hr>

        <p><strong>Mensaje:</strong></p>
        <p>{{ $data['message'] }}</p>

        <hr>
        <p style="font-size:12px;color:#777">
            Enviado desde el formulario web
        </p>
    </div>
</body>
</html>
