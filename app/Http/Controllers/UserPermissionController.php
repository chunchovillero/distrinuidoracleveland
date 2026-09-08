<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    /**
     * Mostrar formulario de permisos para un usuario
     */
    public function edit(User $user)
    {
        // Solo admins pueden gestionar permisos
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'No tienes permisos para gestionar permisos de usuarios.');
        }

        // No se pueden editar permisos de otros admins
        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'No se pueden editar permisos de administradores.');
        }

        $permissionsByCategory = UserPermission::getPermissionsByCategory();
        $userPermissions = $user->permissions()->pluck('granted', 'permission_key')->toArray();

        return view('admin.users.permissions', compact('user', 'permissionsByCategory', 'userPermissions'));
    }

    /**
     * Actualizar permisos de un usuario
     */
    public function update(Request $request, User $user)
    {
        // Solo admins pueden gestionar permisos
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'No tienes permisos para gestionar permisos de usuarios.');
        }

        // No se pueden editar permisos de otros admins
        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'No se pueden editar permisos de administradores.');
        }

        $availablePermissions = array_keys(UserPermission::getAvailablePermissions());
        $grantedPermissions = $request->input('permissions', []);

        // Actualizar cada permiso
        foreach ($availablePermissions as $permission) {
            $granted = in_array($permission, $grantedPermissions);
            
            $user->permissions()->updateOrCreate(
                ['permission_key' => $permission],
                ['granted' => $granted]
            );
        }

        return redirect()->route('admin.users.index')
            ->with('success', "Permisos actualizados para {$user->name}");
    }

    /**
     * Otorgar todos los permisos a un usuario
     */
    public function grantAll(User $user)
    {
        if (!auth()->user()->isAdmin() || $user->isAdmin()) {
            return redirect()->back()->with('error', 'Operación no permitida.');
        }

        foreach (array_keys(UserPermission::getAvailablePermissions()) as $permission) {
            $user->grantPermission($permission);
        }

        return redirect()->back()->with('success', "Todos los permisos otorgados a {$user->name}");
    }

    /**
     * Revocar todos los permisos a un usuario
     */
    public function revokeAll(User $user)
    {
        if (!auth()->user()->isAdmin() || $user->isAdmin()) {
            return redirect()->back()->with('error', 'Operación no permitida.');
        }

        foreach (array_keys(UserPermission::getAvailablePermissions()) as $permission) {
            $user->revokePermission($permission);
        }

        return redirect()->back()->with('success', "Todos los permisos revocados a {$user->name}");
    }
}
