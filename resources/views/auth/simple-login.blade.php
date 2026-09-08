<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn:hover {
            background: #5568d3;
        }
        .error {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .checkbox-group input {
            margin-right: 8px;
        }
        .debug-info {
            margin-top: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
            font-size: 12px;
            color: #666;
        }
        .debug-info h3 {
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>🔐 Iniciar Sesión</h1>
        
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="margin-bottom: 0;">Recordarme</label>
            </div>

            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>

        <div class="debug-info">
            <h3>Info de Debug:</h3>
            <p><strong>CSRF Token:</strong> {{ csrf_token() }}</p>
            <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
            <p><strong>Route:</strong> {{ route('login') }}</p>
            <p><strong>Method:</strong> POST</p>
        </div>
    </div>

    <script>
        // Verificar que el token CSRF se esté enviando
        document.querySelector('form').addEventListener('submit', function(e) {
            const csrfToken = document.querySelector('input[name="_token"]').value;
            console.log('Enviando formulario con CSRF:', csrfToken);
        });
    </script>
</body>
</html>
