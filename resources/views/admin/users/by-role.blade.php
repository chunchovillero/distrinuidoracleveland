@extends('adminlte::page')

@section('title', $roleTitle . ' - POS System')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $roleTitle }}s</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">{{ $roleTitle }}s</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users mr-2"></i>
                            Lista de {{ $roleTitle }}s
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i>
                                Nuevo Usuario
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-list mr-1"></i>
                                Todos los Usuarios
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Avatar</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Estado</th>
                                            <th>Último Acceso</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="text-center">
                                                    @if($user->avatar)
                                                        <img src="{{ asset('images/avatars/' . $user->avatar) }}" 
                                                             alt="{{ $user->name }}" 
                                                             class="img-circle" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary d-inline-flex align-items-center justify-content-center img-circle" 
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $user->name }}</strong>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? 'No especificado' }}</td>
                                                <td>
                                                    @if($user->active)
                                                        <span class="badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->last_login_at)
                                                        {{ $user->last_login_at->format('d/m/Y H:i') }}
                                                    @else
                                                        <span class="text-muted">Nunca</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.users.show', $user) }}" 
                                                           class="btn btn-info btn-sm" 
                                                           title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                                           class="btn btn-primary btn-sm" 
                                                           title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if(!$user->isAdmin())
                                                            <a href="{{ route('admin.users.permissions.edit', $user) }}" 
                                                               class="btn btn-warning btn-sm" 
                                                               title="Gestionar Permisos">
                                                                <i class="fas fa-user-shield"></i>
                                                            </a>
                                                        @endif
                                                        @if(!$user->isAdmin() || auth()->user()->isAdmin())
                                                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                                                  method="POST" 
                                                                  style="display: inline;" 
                                                                  onsubmit="return confirm('¿Está seguro de eliminar este usuario?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-danger btn-sm" 
                                                                        title="Eliminar">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            <div class="d-flex justify-content-center">
                                {{ $users->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No hay {{ strtolower($roleTitle) }}s registrados</h4>
                                <p class="text-muted">
                                    Aún no se han registrado usuarios con el rol de {{ strtolower($roleTitle) }}.
                                </p>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-1"></i>
                                    Crear Primer {{ $roleTitle }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .img-circle {
            border-radius: 50%;
        }
    </style>
@stop