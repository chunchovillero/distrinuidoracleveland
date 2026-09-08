@extends('adminlte::page')

@section('title', 'Dashboard de Reportes')

@section('content_header')
    <h1>Dashboard de Reportes</h1>
@stop

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>${{ number_format($todaySales, 0, ',', '.') }}</h3>
                    <p>Ventas de Hoy</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.reports.sales') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($monthSales, 0, ',', '.') }}</h3>
                    <p>Ventas del Mes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('admin.reports.sales') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Productos Activos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cube"></i>
                </div>
                <a href="{{ route('admin.products.index') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $lowStockProducts }}</h3>
                    <p>Productos con Stock Bajo</p>
                </div>
                <div class="icon">
                    <i class="ion ion-alert-circled"></i>
                </div>
                <a href="{{ route('admin.reports.inventory') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Ventas por Vendedor -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Ventas por Vendedor (Este Mes)
                    </h3>
                </div>
                <div class="card-body">
                    @if($sellerSales->count() > 0)
                        @foreach($sellerSales->take(5) as $seller)
                            <div class="progress-group">
                                {{ $seller['name'] }}
                                <span class="float-right"><b>${{ number_format($seller['total_sales'], 0, ',', '.') }}</b>/{{ $seller['sales_count'] }} ventas</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary" style="width: {{ $sellerSales->max('total_sales') > 0 ? ($seller['total_sales'] / $sellerSales->max('total_sales')) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No hay datos de ventas para mostrar.</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.reports.commissions') }}" class="btn btn-sm btn-primary">Ver Reporte Completo</a>
                </div>
            </div>
        </div>

        <!-- Productos Más Vendidos -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        Productos Más Vendidos (Este Mes)
                    </h3>
                </div>
                <div class="card-body">
                    @if($topProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Ingresos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProducts->take(5) as $product)
                                        <tr>
                                            <td>{{ $product['name'] }}</td>
                                            <td><span class="badge badge-success">{{ $product['quantity_sold'] }}</span></td>
                                            <td>${{ number_format($product['total_revenue'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No hay datos de productos para mostrar.</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">Ver Todos los Productos</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos a Reportes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Reportes Disponibles
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box bg-primary">
                                <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reporte de Ventas</span>
                                    <span class="info-box-number">Análisis detallado</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <a href="{{ route('admin.reports.sales') }}" class="text-white">Ver Reporte <i class="fas fa-arrow-right"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reporte de Inventario</span>
                                    <span class="info-box-number">Control de stock</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <a href="{{ route('admin.reports.inventory') }}" class="text-white">Ver Reporte <i class="fas fa-arrow-right"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reporte de Comisiones</span>
                                    <span class="info-box-number">Performance vendedores</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <a href="{{ route('admin.reports.commissions') }}" class="text-white">Ver Reporte <i class="fas fa-arrow-right"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reporte de Clientes</span>
                                    <span class="info-box-number">Comportamiento clientes</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <a href="{{ route('admin.reports.customers') }}" class="text-white">Ver Reporte <i class="fas fa-arrow-right"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos CRUD -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-1"></i>
                        Accesos Rápidos
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.sales.create') }}" class="btn btn-app">
                                <i class="fas fa-plus"></i> Nueva Venta
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-app">
                                <i class="fas fa-box-open"></i> Nuevo Producto
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.customers.create') }}" class="btn btn-app">
                                <i class="fas fa-user-plus"></i> Nuevo Cliente
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.sellers.create') }}" class="btn btn-app">
                                <i class="fas fa-user-tie"></i> Nuevo Vendedor
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Dashboard cargado exitosamente!');
    </script>
@stop