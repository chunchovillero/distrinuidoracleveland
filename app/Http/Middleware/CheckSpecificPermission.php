<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSpecificPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // Verificar si el usuario tiene el permiso específico o es admin
        if ($user->hasPermission($permission) || $user->isAdmin()) {
            return $next($request);
        }

        // Si no tiene permisos, redirigir con error
        return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos para realizar esta acción.');
    }
}
