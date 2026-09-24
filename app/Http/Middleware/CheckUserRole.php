<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/admin/login');
        }

        $user = auth()->user();

        // Si no se especifican roles, solo verificar que esté autenticado
        if (empty($roles)) {
            return $next($request);
        }

        // Verificar si el usuario tiene alguno de los roles permitidos
        if ($user->active && in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // Un administrador válido puede carecer de acceso a una sección
        // exclusiva del superadministrador sin perder su sesión.
        if ($user->active && $user->isAdmin()) {
            return response()->view('errors.403', [
                'message' => 'No tienes permisos para acceder a esta sección.',
            ], 403);
        }

        // Cerrar sesiones de roles sin acceso al panel. Nunca redirigir al
        // dashboard protegido, porque eso genera un bucle de redirecciones.
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->view('errors.403', [
            'message' => 'No tienes permisos para acceder al panel administrativo.',
        ], 403);
    }
}
