<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>403 | Acceso denegado</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            color: #1f2937;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .error-card {
            width: min(100%, 560px);
            padding: 48px 36px;
            text-align: center;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, .12);
        }

        .status {
            margin: 0;
            color: #dc2626;
            font-size: clamp(72px, 18vw, 128px);
            font-weight: 800;
            line-height: .9;
        }

        h1 {
            margin: 24px 0 12px;
            font-size: 30px;
        }

        p {
            margin: 0 auto 30px;
            max-width: 430px;
            color: #64748b;
            font-size: 17px;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            color: #334155;
            text-decoration: none;
            font-weight: 700;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .button-primary {
            border-color: #2563eb;
            color: #ffffff;
            background: #2563eb;
        }

        .button:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, .12);
        }
    </style>
</head>
<body>
    <main class="error-card">
        <div class="status">403</div>
        <h1>Acceso denegado</h1>
        <p>{{ $message ?? 'No tienes los permisos necesarios para acceder a esta sección.' }}</p>

        <div class="actions">
            <a class="button button-primary" href="{{ url('/') }}">Volver al catálogo</a>
            <a class="button" href="{{ url('/admin/login') }}">Inicio de sesión</a>
        </div>
    </main>
</body>
</html>
