@extends('adminlte::page')

@section('title', 'Editar Usuario - POS System')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">Editar Usuario</li>
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
                            <i class="fas fa-user-edit mr-2"></i>
                            Editar Información del Usuario
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye mr-1"></i>
                                Ver Usuario
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <!-- Información Personal -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                <i class="fas fa-user mr-2"></i>
                                                Información Personal
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">
                                                            <i class="fas fa-user mr-1"></i>
                                                            Nombre Completo *
                                                        </label>
                                                        <input type="text" 
                                                               class="form-control @error('name') is-invalid @enderror" 
                                                               id="name" 
                                                               name="name" 
                                                               value="{{ old('name', $user->name) }}" 
                                                               required>
                                                        @error('name')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">
                                                            <i class="fas fa-envelope mr-1"></i>
                                                            Email *
                                                        </label>
                                                        <input type="email" 
                                                               class="form-control @error('email') is-invalid @enderror" 
                                                               id="email" 
                                                               name="email" 
                                                               value="{{ old('email', $user->email) }}" 
                                                               required>
                                                        @error('email')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">
                                                            <i class="fas fa-phone mr-1"></i>
                                                            Teléfono
                                                        </label>
                                                        <input type="text" 
                                                               class="form-control @error('phone') is-invalid @enderror" 
                                                               id="phone" 
                                                               name="phone" 
                                                               value="{{ old('phone', $user->phone) }}">
                                                        @error('phone')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address">
                                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                                            Dirección
                                                        </label>
                                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                                  id="address" 
                                                                  name="address" 
                                                                  rows="3">{{ old('address', $user->address) }}</textarea>
                                                        @error('address')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cambio de Contraseña -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <hr>
                                                    <h5>
                                                        <i class="fas fa-key mr-2"></i>
                                                        Cambiar Contraseña
                                                        <small class="text-muted">(Dejar en blanco para mantener la actual)</small>
                                                    </h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">
                                                            <i class="fas fa-lock mr-1"></i>
                                                            Nueva Contraseña
                                                        </label>
                                                        <input type="password" 
                                                               class="form-control @error('password') is-invalid @enderror" 
                                                               id="password" 
                                                               name="password">
                                                        @error('password')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password_confirmation">
                                                            <i class="fas fa-lock mr-1"></i>
                                                            Confirmar Contraseña
                                                        </label>
                                                        <input type="password" 
                                                               class="form-control" 
                                                               id="password_confirmation" 
                                                               name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Avatar y Configuración -->
                                <div class="col-md-4">
                                    <!-- Avatar -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                <i class="fas fa-image mr-2"></i>
                                                Avatar
                                            </h4>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                @if($user->avatar)
                                                    <img id="avatar-preview" 
                                                         src="{{ asset('images/avatars/' . $user->avatar) }}" 
                                                         alt="{{ $user->name }}" 
                                                         class="img-circle img-fluid" 
                                                         style="width: 120px; height: 120px; object-fit: cover;">
                                                @else
                                                    <div id="avatar-placeholder" 
                                                         class="bg-primary d-inline-flex align-items-center justify-content-center img-circle" 
                                                         style="width: 120px; height: 120px; font-size: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="form-group">
                                                <input type="file" 
                                                       class="form-control-file @error('avatar') is-invalid @enderror" 
                                                       id="avatar" 
                                                       name="avatar" 
                                                       accept="image/*">
                                                @error('avatar')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                                <small class="form-text text-muted">
                                                    Formatos: JPG, PNG, GIF. Máximo 2MB.
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Configuración de Usuario -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                <i class="fas fa-cogs mr-2"></i>
                                                Configuración
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="role">
                                                    <i class="fas fa-user-tag mr-1"></i>
                                                    Rol *
                                                </label>
                                                <select class="form-control @error('role') is-invalid @enderror" 
                                                        id="role" 
                                                        name="role" 
                                                        required>
                                                    @foreach($roles as $roleKey => $roleName)
                                                        <option value="{{ $roleKey }}" {{ old('role', $user->role) == $roleKey ? 'selected' : '' }}>
                                                            {{ $roleName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="hidden" name="active" value="0">
                                                    <input type="checkbox" 
                                                           class="custom-control-input" 
                                                           id="active" 
                                                           name="active" 
                                                           value="1" 
                                                           {{ old('active', $user->active) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="active">
                                                        <i class="fas fa-toggle-on mr-1"></i>
                                                        Usuario Activo
                                                    </label>
                                                </div>
                                                <small class="form-text text-muted">
                                                    Los usuarios inactivos no pueden iniciar sesión.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
                                        <i class="fas fa-times mr-1"></i>
                                        Cancelar
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i>
                                        Actualizar Usuario
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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

@section('js')
    <script>
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatar-preview');
                    const placeholder = document.getElementById('avatar-placeholder');
                    
                    if (preview) {
                        preview.src = e.target.result;
                    } else if (placeholder) {
                        placeholder.innerHTML = '<img id="avatar-preview" src="' + e.target.result + '" alt="Preview" class="img-circle img-fluid" style="width: 120px; height: 120px; object-fit: cover;">';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@stop
