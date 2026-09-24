<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Roles que el usuario autenticado puede asignar.
     */
    private function assignableRoles(): array
    {
        if (auth()->user()->isSuperAdmin()) {
            return User::ROLES;
        }

        return array_diff_key(User::ROLES, array_flip(['superadmin', 'admin']));
    }

    /**
     * Un administrador común no puede modificar cuentas privilegiadas.
     */
    private function authorizeUserManagement(User $user): void
    {
        if (auth()->id() !== $user->id && !auth()->user()->isSuperAdmin() && $user->isAdmin()) {
            abort(403, 'Solo un superadministrador puede administrar cuentas privilegiadas.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();
            
            // Búsqueda
            if ($request->has('search') && !empty($request->search['value'])) {
                $search = $request->search['value'];
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%")
                      ->orWhere('role', 'LIKE', "%{$search}%");
                });
            }
            
            $totalRecords = User::count();
            $filteredRecords = $query->count();
            
            // Ordenamiento
            if ($request->has('order')) {
                $columns = ['id', 'name', 'email', 'role', 'active', 'last_login_at', 'actions'];
                $columnIndex = $request->order[0]['column'];
                $direction = $request->order[0]['dir'];
                
                if (isset($columns[$columnIndex]) && $columns[$columnIndex] !== 'actions') {
                    $query->orderBy($columns[$columnIndex], $direction);
                }
            } else {
                $query->orderBy('id', 'desc');
            }
            
            // Paginación
            $start = $request->start ?? 0;
            $length = $request->length ?? 10;
            $users = $query->skip($start)->take($length)->get();
            
            $data = [];
            foreach ($users as $user) {
                $avatarHtml = '';
                if ($user->avatar) {
                    $avatarHtml = '<img src="' . asset('images/avatars/' . $user->avatar) . '" alt="' . $user->name . '" class="img-circle" style="width: 40px; height: 40px;">';
                } else {
                    $avatarHtml = '<div class="bg-primary d-flex align-items-center justify-content-center img-circle" style="width: 40px; height: 40px;"><i class="fas fa-user text-white"></i></div>';
                }
                
                $roleClass = [
                    'superadmin' => 'dark',
                    'admin' => 'danger',
                    'manager' => 'warning', 
                    'seller' => 'info',
                    'user' => 'secondary'
                ];
                
                $statusHtml = $user->active ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
                
                $lastLoginHtml = $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca';
                
                $canManageUser = auth()->user()->isSuperAdmin() || !$user->isAdmin();

                $actionsHtml = '
                    <div class="btn-group" role="group">
                        <a href="' . route('admin.users.show', $user) . '" class="btn btn-info btn-sm" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>';

                if ($canManageUser) {
                    $actionsHtml .= '
                        <a href="' . route('admin.users.edit', $user) . '" class="btn btn-primary btn-sm" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>';
                }
                
                if ($canManageUser && $user->id !== auth()->id()) {
                    $actionsHtml .= '
                        <form action="' . route('admin.users.destroy', $user) . '" method="POST" style="display: inline;" onsubmit="return confirm(\'¿Está seguro de eliminar este usuario?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>';
                }
                
                $actionsHtml .= '</div>';
                
                $data[] = [
                    $user->id,
                    $avatarHtml . ' <strong>' . $user->name . '</strong>',
                    $user->email,
                    '<span class="badge badge-' . ($roleClass[$user->role] ?? 'secondary') . '">' . $user->getRoleName() . '</span>',
                    $statusHtml,
                    $lastLoginHtml,
                    $actionsHtml
                ];
            }
            
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }
        
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403, 'Solo un superadministrador puede crear usuarios.');

        $roles = $this->assignableRoles();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403, 'Solo un superadministrador puede crear usuarios.');

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => ['required', Rule::in(array_keys($this->assignableRoles()))],
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'active' => 'nullable|boolean'
            ]);

            $data = $request->all();
        if (auth()->id() === $user->id) { $data['role'] = $user->role; $data['active'] = $user->active; }
            $data['password'] = Hash::make($request->password);
            // Con el campo hidden, siempre recibiremos un valor para 'active'
            $data['active'] = $request->input('active', 1) == '1' ? 1 : 0;

            if ($request->hasFile('avatar')) {
                // Crear directorio si no existe
                if (!file_exists(public_path('images/avatars'))) {
                    mkdir(public_path('images/avatars'), 0755, true);
                }
                
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/avatars'), $filename);
                $data['avatar'] = $filename;
            }

            $user = User::create($data);
            if ($user->role === 'seller') { Seller::updateOrCreate(['email' => $user->email], ['name' => $user->name, 'active' => (bool) $user->active]); }

            return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorizeUserManagement($user);
        $roles = $this->assignableRoles();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeUserManagement($user);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(array_keys($this->assignableRoles()))],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'nullable|boolean'
        ]);

        $data = $request->all();
        if (auth()->id() === $user->id) { $data['role'] = $user->role; $data['active'] = $user->active; }
        $data['active'] = $request->input('active', 0) == '1' ? 1 : 0;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar && file_exists(public_path('images/avatars/' . $user->avatar))) {
                unlink(public_path('images/avatars/' . $user->avatar));
            }
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/avatars'), $filename);
            $data['avatar'] = $filename;
        }

        $user->update($data);
        $user->refresh();
        if ($user->role === 'seller') { Seller::updateOrCreate(['email' => $user->email], ['name' => $user->name, 'active' => (bool) $user->active]); }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorizeUserManagement($user);

        // No permitir auto-eliminación
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminarte a ti mismo.');
        }

        if ($user->avatar && file_exists(public_path('images/avatars/' . $user->avatar))) {
            unlink(public_path('images/avatars/' . $user->avatar));
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Show users by role
     */
    public function byRole($role)
    {
        $validRoles = array_keys(User::ROLES);
        
        if (!in_array($role, $validRoles)) {
            abort(404);
        }

        $users = User::where('role', $role)->paginate(10);
        $roleTitle = User::ROLES[$role];
        
        return view('admin.users.by-role', compact('users', 'role', 'roleTitle'));
    }
}
