<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
            return redirect('/login');
        }

        $user = auth()->user();

        // Si no se especifican roles, solo verificar que esté autenticado
        if (empty($roles)) {
            return $next($request);
        }

        // Verificar si el usuario tiene alguno de los roles permitidos
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Si no tiene permisos, redirigir con error
        return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}
