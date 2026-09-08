@extends('adminlte::page')

@section('title', 'Permisos de Usuario - ' . $user->name)

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Permisos de Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">Permisos</li>
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
                            <i class="fas fa-user-shield mr-2"></i>
                            Configurar Permisos para: <strong>{{ $user->name }}</strong>
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver a Usuarios
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('admin.users.permissions.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-check"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-ban"></i>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="alert alert-info">
                                <i class="icon fas fa-info-circle"></i>
                                <strong>Información:</strong> Selecciona qué secciones del sistema puede ver este usuario. 
                                Los administradores tienen acceso completo automáticamente.
                            </div>

                            <!-- Botones de acción rápida -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <strong>Seleccionar por Tipo de Acción:</strong>
                                    </div>
                                    <div class="btn-group mb-3" role="group">
                                        <button type="button" class="btn btn-info btn-sm" onclick="selectViewPermissions()">
                                            <i class="fas fa-eye"></i> Solo Ver
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm" onclick="selectCreatePermissions()">
                                            <i class="fas fa-plus"></i> Solo Crear
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm" onclick="selectEditPermissions()">
                                            <i class="fas fa-edit"></i> Solo Editar
                                        </button>
                                    </div>
                                    <br>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-sm" onclick="selectAll()">
                                            <i class="fas fa-check-double"></i> Seleccionar Todo
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm" onclick="deselectAll()">
                                            <i class="fas fa-times"></i> Deseleccionar Todo
                                        </button>
                                        <a href="{{ route('admin.users.permissions.grant-all', $user) }}" 
                                           class="btn btn-info btn-sm"
                                           onclick="return confirm('¿Otorgar todos los permisos a {{ $user->name }}?')">
                                            <i class="fas fa-unlock"></i> Otorgar Todos
                                        </a>
                                        <a href="{{ route('admin.users.permissions.revoke-all', $user) }}" 
                                           class="btn btn-secondary btn-sm"
                                           onclick="return confirm('¿Revocar todos los permisos a {{ $user->name }}?')">
                                            <i class="fas fa-lock"></i> Revocar Todos
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Permisos por categorías -->
                            <div class="row">
                                @php
                                    $cardColors = [
                                        'Dashboard' => 'primary',
                                        'Productos' => 'success', 
                                        'Clientes' => 'info',
                                        'Vendedores' => 'warning',
                                        'Categorías' => 'secondary',
                                        'Ventas' => 'danger',
                                        'Reportes' => 'dark'
                                    ];
                                    
                                    $cardIcons = [
                                        'Dashboard' => 'fa-tachometer-alt',
                                        'Productos' => 'fa-cube',
                                        'Clientes' => 'fa-users', 
                                        'Vendedores' => 'fa-user-tie',
                                        'Categorías' => 'fa-tags',
                                        'Ventas' => 'fa-shopping-cart',
                                        'Reportes' => 'fa-chart-line'
                                    ];
                                @endphp
                                
                                @foreach($permissionsByCategory as $categoryName => $permissions)
                                    <div class="col-md-6 mb-3">
                                        <div class="card card-outline card-{{ $cardColors[$categoryName] ?? 'primary' }}">
                                            <div class="card-header">
                                                <h5 class="card-title">
                                                    <i class="fas {{ $cardIcons[$categoryName] ?? 'fa-cog' }}"></i> {{ $categoryName }}
                                                </h5>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-sm btn-outline-{{ $cardColors[$categoryName] ?? 'primary' }}" 
                                                            onclick="toggleCategory('{{ $categoryName }}')">
                                                        <i class="fas fa-check-double"></i> Todo/Nada
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach($permissions as $permissionKey => $permissionName)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input category-{{ $categoryName }}" 
                                                               type="checkbox" 
                                                               name="permissions[]" 
                                                               value="{{ $permissionKey }}" 
                                                               id="{{ $permissionKey }}"
                                                               {{ (isset($userPermissions[$permissionKey]) && $userPermissions[$permissionKey]) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $permissionKey }}">
                                                            <strong>{{ $permissionName }}</strong>
                                                            @if(str_contains($permissionKey, 'view'))
                                                                <span class="badge badge-info badge-sm">Ver</span>
                                                            @elseif(str_contains($permissionKey, 'create'))
                                                                <span class="badge badge-success badge-sm">Crear</span>
                                                            @elseif(str_contains($permissionKey, 'edit'))
                                                                <span class="badge badge-warning badge-sm">Editar</span>
                                                            @elseif(str_contains($permissionKey, 'delete'))
                                                                <span class="badge badge-danger badge-sm">Eliminar</span>
                                                            @elseif(str_contains($permissionKey, 'toggle'))
                                                                <span class="badge badge-secondary badge-sm">Estado</span>
                                                            @elseif(str_contains($permissionKey, 'export'))
                                                                <span class="badge badge-primary badge-sm">Exportar</span>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                Guardar Permisos
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i>
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    function selectAll() {
        $('input[type="checkbox"][name="permissions[]"]').prop('checked', true);
    }

    function deselectAll() {
        $('input[type="checkbox"][name="permissions[]"]').prop('checked', false);
    }
    
    function toggleCategory(categoryName) {
        const checkboxes = $(`.category-${categoryName}`);
        const checkedCount = checkboxes.filter(':checked').length;
        const totalCount = checkboxes.length;
        
        // Si todos están marcados, desmarcar todos; si no, marcar todos
        const shouldCheck = checkedCount < totalCount;
        checkboxes.prop('checked', shouldCheck);
    }
    
    // Función para seleccionar permisos comunes
    function selectViewPermissions() {
        $('input[name="permissions[]"][value*="view_"]').prop('checked', true);
    }
    
    function selectCreatePermissions() {
        $('input[name="permissions[]"][value*="create_"]').prop('checked', true);
    }
    
    function selectEditPermissions() {
        $('input[name="permissions[]"][value*="edit_"]').prop('checked', true);
    }
</script>
@stop