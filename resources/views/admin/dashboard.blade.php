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
        <div class="row">
            <div class="col-lg-3 col-6"><div class="small-box bg-primary"><div class="inner"><h3>{{ $metrics["totalSales"] }}</h3><p>Ventas completadas</p></div><div class="icon"><i class="fas fa-shopping-cart"></i></div><a href="{{ route("admin.sales.index") }}" class="small-box-footer">Ver ventas <i class="fas fa-arrow-circle-right"></i></a></div></div>
            <div class="col-lg-3 col-6"><div class="small-box bg-success"><div class="inner"><h3>{{ $metrics["salesToday"] }}</h3><p>Ventas de hoy</p></div><div class="icon"><i class="fas fa-cash-register"></i></div><a href="{{ route("admin.sales.index") }}" class="small-box-footer">Ver ventas <i class="fas fa-arrow-circle-right"></i></a></div></div>
            <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3>{{ $metrics["totalProducts"] }}</h3><p>Productos activos</p></div><div class="icon"><i class="fas fa-boxes"></i></div><a href="{{ route("admin.products.index") }}" class="small-box-footer">Ver productos <i class="fas fa-arrow-circle-right"></i></a></div></div>
            <div class="col-lg-3 col-6"><div class="small-box bg-warning"><div class="inner"><h3>{{ $metrics["lowStockProducts"] }}</h3><p>Productos con stock bajo</p></div><div class="icon"><i class="fas fa-exclamation-triangle"></i></div><a href="{{ route("admin.products.index") }}" class="small-box-footer">Revisar stock <i class="fas fa-arrow-circle-right"></i></a></div></div>
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
