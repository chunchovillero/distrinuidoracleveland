<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    public function login(Request $request)
    {
        // Log personalizado
        $logFile = storage_path('logs/login-debug.log');
        $timestamp = date('Y-m-d H:i:s');
        
        file_put_contents($logFile, "\n=== LOGIN ATTEMPT $timestamp ===\n", FILE_APPEND);
        file_put_contents($logFile, "Email: " . $request->email . "\n", FILE_APPEND);
        file_put_contents($logFile, "IP: " . $request->ip() . "\n", FILE_APPEND);
        
        // Validar
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar login
        $credentials = $request->only('email', 'password');
        
        file_put_contents($logFile, "Credentials: " . json_encode(['email' => $credentials['email']]) . "\n", FILE_APPEND);
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            file_put_contents($logFile, "Auth SUCCESS - User ID: " . Auth::id() . "\n", FILE_APPEND);

            if (!Auth::user()->active || (!Auth::user()->isAdmin() && !Auth::user()->isSeller())) {
                file_put_contents($logFile, "Auth REJECTED - User is inactive or is not an administrator\n", FILE_APPEND);

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->view('errors.403', [
                    'message' => 'El acceso está habilitado únicamente para usuarios autorizados y activos.',
                ], 403);
            }
            
            $request->session()->regenerate();
            
            file_put_contents($logFile, "Session regenerated - Redirecting to /admin\n", FILE_APPEND);
            
            // Forzar redirección explícita
            return redirect()->intended(Auth::user()->isSeller() ? '/admin/sales' : '/admin')->with('success', 'Login exitoso');
        }

        file_put_contents($logFile, "Auth FAILED - Invalid credentials\n", FILE_APPEND);
        
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        
        error_log("sendLoginResponse - Redirecting to /admin");
        return redirect()->intended(Auth::user()->isSeller() ? '/admin/sales' : '/admin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/admin/login');
    }
}
