@extends('adminlte::page')

@section('title', 'Ver Usuario - POS System')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Ver Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">Ver Usuario</li>
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
                            <i class="fas fa-user mr-2"></i>
                            Información del Usuario
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit mr-1"></i>
                                Editar
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Avatar y Información Principal -->
                            <div class="col-md-4">
                                <div class="text-center">
                                    @if($user->avatar)
                                        <img src="{{ asset('images/avatars/' . $user->avatar) }}" 
                                             alt="{{ $user->name }}" 
                                             class="img-circle img-fluid" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary d-inline-flex align-items-center justify-content-center img-circle" 
                                             style="width: 150px; height: 150px; font-size: 60px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                    
                                    <h3 class="profile-username text-center mt-3">{{ $user->name }}</h3>
                                    
                                    <p class="text-muted text-center">
                                        <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'secondary' }} badge-lg">
                                            {{ $user->getRoleName() }}
                                        </span>
                                    </p>
                                    
                                    <div class="text-center">
                                        @if($user->active)
                                            <span class="badge badge-success badge-lg">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Usuario Activo
                                            </span>
                                        @else
                                            <span class="badge badge-danger badge-lg">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Usuario Inactivo
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Información Detallada -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">
                                                    <i class="fas fa-info-circle mr-2"></i>
                                                    Detalles Personales
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <dl class="row">
                                                    <dt class="col-sm-4">
                                                        <i class="fas fa-envelope mr-2"></i>
                                                        Email:
                                                    </dt>
                                                    <dd class="col-sm-8">{{ $user->email }}</dd>
                                                    
                                                    <dt class="col-sm-4">
                                                        <i class="fas fa-user-tag mr-2"></i>
                                                        Rol:
                                                    </dt>
                                                    <dd class="col-sm-8">{{ $user->getRoleName() }}</dd>
                                                    
                                                    @if($user->phone)
                                                        <dt class="col-sm-4">
                                                            <i class="fas fa-phone mr-2"></i>
                                                            Teléfono:
                                                        </dt>
                                                        <dd class="col-sm-8">{{ $user->phone }}</dd>
                                                    @endif
                                                    
                                                    @if($user->address)
                                                        <dt class="col-sm-4">
                                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                                            Dirección:
                                                        </dt>
                                                        <dd class="col-sm-8">{{ $user->address }}</dd>
                                                    @endif
                                                    
                                                    <dt class="col-sm-4">
                                                        <i class="fas fa-calendar-plus mr-2"></i>
                                                        Registrado:
                                                    </dt>
                                                    <dd class="col-sm-8">{{ $user->created_at->format('d/m/Y H:i:s') }}</dd>
                                                    
                                                    @if($user->updated_at != $user->created_at)
                                                        <dt class="col-sm-4">
                                                            <i class="fas fa-calendar-edit mr-2"></i>
                                                            Última Actualización:
                                                        </dt>
                                                        <dd class="col-sm-8">{{ $user->updated_at->format('d/m/Y H:i:s') }}</dd>
                                                    @endif
                                                    
                                                    @if($user->last_login_at)
                                                        <dt class="col-sm-4">
                                                            <i class="fas fa-sign-in-alt mr-2"></i>
                                                            Último Acceso:
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ $user->last_login_at->format('d/m/Y H:i:s') }}
                                                            @if($user->last_login_ip)
                                                                <br>
                                                                <small class="text-muted">
                                                                    <i class="fas fa-globe mr-1"></i>
                                                                    IP: {{ $user->last_login_ip }}
                                                                </small>
                                                            @endif
                                                        </dd>
                                                    @else
                                                        <dt class="col-sm-4">
                                                            <i class="fas fa-sign-in-alt mr-2"></i>
                                                            Último Acceso:
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            <span class="text-muted">Nunca ha iniciado sesión</span>
                                                        </dd>
                                                    @endif
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Permisos y Capacidades -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">
                                                    <i class="fas fa-shield-alt mr-2"></i>
                                                    Permisos y Capacidades
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6><i class="fas fa-check-square mr-2 text-success"></i>Puede hacer:</h6>
                                                        <ul class="list-unstyled">
                                                            <li><i class="fas fa-eye mr-2 text-info"></i> Ver ventas</li>
                                                            @if($user->canManageUsers())
                                                                <li><i class="fas fa-users-cog mr-2 text-success"></i> Gestionar usuarios</li>
                                                            @endif
                                                            @if($user->canManageUsers())
                                                                <li><i class="fas fa-crown mr-2 text-warning"></i> Acceso administrativo completo</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6><i class="fas fa-info-circle mr-2 text-info"></i>Características:</h6>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <i class="fas fa-user-circle mr-2"></i>
                                                                Tipo: {{ $user->getRoleName() }}
                                                            </li>
                                                            <li>
                                                                <i class="fas fa-{{ $user->active ? 'toggle-on text-success' : 'toggle-off text-danger' }} mr-2"></i>
                                                                Estado: {{ $user->active ? 'Activo' : 'Inactivo' }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Volver a la Lista
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                @if(auth()->user()->canManageUsers())
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                                        <i class="fas fa-edit mr-1"></i>
                                        Editar Usuario
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge-lg {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        .img-circle {
            border-radius: 50%;
        }
    </style>
@stop