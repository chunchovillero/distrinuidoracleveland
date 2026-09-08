<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
        'phone',
        'address',
        'avatar',
        'last_login_at',
        'last_login_ip'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Roles disponibles en el sistema
     */
    const ROLES = [
        'admin' => 'Administrador',
        'user' => 'Usuario'
    ];

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verificar si el usuario puede gestionar usuarios
     */
    public function canManageUsers(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Obtener el nombre del rol
     */
    public function getRoleName(): string
    {
        return self::ROLES[$this->role] ?? 'Usuario';
    }

    /**
     * Actualizar información de último login
     */
    public function updateLastLogin($ip = null)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip ?: request()->ip()
        ]);
    }

    /**
     * Relación con permisos personalizados
     */
    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    /**
     * Verificar si el usuario tiene un permiso específico
     */
    public function hasPermission(string $permission): bool
    {
        // Los admins tienen todos los permisos
        if ($this->isAdmin()) {
            return true;
        }

        // Verificar permiso específico
        $userPermission = $this->permissions()
            ->where('permission_key', $permission)
            ->first();

        // Si no existe el permiso, por defecto está denegado para usuarios normales
        return $userPermission ? $userPermission->granted : false;
    }

    /**
     * Otorgar un permiso al usuario
     */
    public function grantPermission(string $permission): void
    {
        $this->permissions()->updateOrCreate(
            ['permission_key' => $permission],
            ['granted' => true]
        );
    }

    /**
     * Revocar un permiso al usuario
     */
    public function revokePermission(string $permission): void
    {
        $this->permissions()->updateOrCreate(
            ['permission_key' => $permission],
            ['granted' => false]
        );
    }

    /**
     * Obtener todos los permisos del usuario
     */
    public function getAllPermissions(): array
    {
        if ($this->isAdmin()) {
            return array_keys(UserPermission::getAvailablePermissions());
        }

        return $this->permissions()
            ->where('granted', true)
            ->pluck('permission_key')
            ->toArray();
    }
}
