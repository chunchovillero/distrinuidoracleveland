@extends('adminlte::page')

@section('title', 'Dashboard - POS System')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Estadísticas de usuarios: exclusivas del superadministrador -->
        @if(auth()->user()->isSuperAdmin())
        <div class="row">
            <!-- Total Users -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ \App\Models\User::count() }}</h3>
                        <p>Usuarios</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                        Ver más <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Active Users -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('active', true)->count() }}</h3>
                        <p>Usuarios Activos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark-circled"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                        Ver más <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                        <p>Administradores</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-gear-a"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                        Ver más <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- System Status -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Online</h3>
                        <p>Sistema POS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Sistema Activo <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Dashboard Content -->
        <div class="row">
            <!-- Welcome Card -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-home mr-2"></i>
                            Bienvenido al Sistema POS
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>¡Hola, {{ auth()->user()->name }}!</h5>
                                <p class="text-muted">
                                    Bienvenido de vuelta al sistema de punto de venta. 
                                    Tu rol actual es: <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                                </p>
                                
                                @if(auth()->user()->last_login_at)
                                    <p class="text-sm text-muted">
                                        <i class="fas fa-clock mr-1"></i>
                                        Último acceso: {{ auth()->user()->last_login_at->format('d/m/Y H:i:s') }}
                                        @if(auth()->user()->last_login_ip)
                                            desde {{ auth()->user()->last_login_ip }}
                                        @endif
                                    </p>
                                @endif

                                <div class="mt-3">
                                    @if(auth()->user()->canManageUsers())
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                            <i class="fas fa-users mr-1"></i>
                                            Gestionar Usuarios
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('admin.sales.index') }}" class="btn btn-success">
                                        <i class="fas fa-cash-register mr-1"></i>
                                        Ver Ventas
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Perfil de Usuario</span>
                                        <span class="info-box-number">{{ auth()->user()->name }}</span>
                                        <span class="progress-description">
                                            {{ auth()->user()->email }}
                                        </span>
                                    </div>
                                </div>

                                @if(auth()->user()->phone)
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success elevation-1">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Teléfono</span>
                                            <span class="info-box-number">{{ auth()->user()->phone }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-2"></i>
                            Acciones Rápidas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(auth()->user()->isSuperAdmin())
                                <div class="col-md-3">
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-app">
                                        <i class="fas fa-user-plus"></i>
                                        Nuevo Usuario
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-app">
                                        <i class="fas fa-list"></i>
                                        Lista Usuarios
                                    </a>
                                </div>
                            @endif
                            
                            <div class="col-md-3">
                                <a href="#" class="btn btn-app">
                                    <i class="fas fa-chart-bar"></i>
                                    Reportes
                                </a>
                            </div>
                            
                            <div class="col-md-3">
                                <a href="#" class="btn btn-app">
                                    <i class="fas fa-cog"></i>
                                    Configuración
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')
    <script>
        console.log('Dashboard loaded successfully!');
    </script>
@stop
