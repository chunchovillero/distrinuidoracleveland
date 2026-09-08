@extends('adminlte::page')

@section('title', 'Reporte de Ventas')

@section('content_header')
    <h1>Reporte de Ventas</h1>
@stop

@section('content')
    <!-- Filtros -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtros del Reporte</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.sales') }}" id="reportForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha desde</label>
                            <input type="date" name="date_from" class="form-control" 
                                   value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha hasta</label>
                            <input type="date" name="date_to" class="form-control" 
                                   value="{{ request('date_to', now()->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Vendedor</label>
                            <select name="seller_id" class="form-control">
                                <option value="">Todos los vendedores</option>
                                @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                        {{ $seller->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Generar Reporte
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumen Estadístico -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalSales }}</h3>
                    <p>Total de Ventas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($totalAmount, 0, ',', '.') }}</h3>
                    <p>Monto Total</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>${{ number_format($totalCommissions, 0, ',', '.') }}</h3>
                    <p>Comisiones Totales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>${{ number_format($averageSale, 0, ',', '.') }}</h3>
                    <p>Promedio por Venta</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Ventas por Día -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ventas por Día</h3>
        </div>
        <div class="card-body">
            <canvas id="salesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>

    <!-- Top Vendedores -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Vendedores</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Vendedor</th>
                                <th>Ventas</th>
                                <th>Monto</th>
                                <th>Comisión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSellers as $seller)
                                <tr>
                                    <td>{{ $seller['name'] }}</td>
                                    <td>{{ $seller['sales_count'] }}</td>
                                    <td>${{ number_format($seller['total_amount'], 0, ',', '.') }}</td>
                                    <td>${{ number_format($seller['total_commission'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Productos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad Vendida</th>
                                <th>Monto Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['total_quantity'] }}</td>
                                    <td>${{ number_format($product['total_amount'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado Detallado -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado Detallado de Ventas</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="salesTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Venta</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Total</th>
                            <th>Comisión</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->invoice_number }}</td>
                                <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                <td>{{ $sale->customer->name }}</td>
                                <td>{{ $sale->seller->name }}</td>
                                <td>${{ number_format($sale->total, 0, ',', '.') }}</td>
                                <td>${{ number_format($sale->total_commission, 0, ',', '.') }}</td>
                                <td>
                                    @if($sale->status == 'completed')
                                        <span class="badge badge-success">Completada</span>
                                    @elseif($sale->status == 'pending')
                                        <span class="badge badge-warning">Pendiente</span>
                                    @else
                                        <span class="badge badge-danger">Cancelada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.sales.show', $sale) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            $('#salesTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "decimal": ",",
                    "thousands": ".",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoPostFix": "",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "loadingRecords": "Cargando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "searchPlaceholder": "Buscar ventas...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles en la tabla"
                },
                "order": [[ 1, "desc" ]], // Ordenar por fecha descendente
                "columnDefs": [
                    { "orderable": false, "targets": 7 } // Deshabilitar ordenación en columna de acciones
                ]
            });

            // Configurar el gráfico
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesData = @json($dailySales);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: salesData.map(item => item.date),
                    datasets: [{
                        label: 'Ventas Diarias',
                        data: salesData.map(item => item.total),
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Evolución de Ventas'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@stop