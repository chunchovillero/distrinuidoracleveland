@extends('adminlte::page')

@section('title', 'Reporte de Comisiones')

@section('content_header')
    <h1>Reporte de Comisiones</h1>
@stop

@section('content')
    <!-- Filtros -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtros del Reporte</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.commissions') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fecha desde</label>
                            <input type="date" name="start_date" class="form-control" 
                                   value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fecha hasta</label>
                            <input type="date" name="end_date" class="form-control" 
                                   value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-4">
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

    <!-- Resumen de Comisiones -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $sellers->count() }}</h3>
                    <p>Vendedores Activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($sellers->sum('total_sales'), 0, ',', '.') }}</h3>
                    <p>Total Ventas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>${{ number_format($sellers->sum('total_commission'), 0, ',', '.') }}</h3>
                    <p>Total Comisiones</p>
                </div>
                <div class="icon">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $sellers->sum('sales_count') }}</h3>
                    <p>Ventas Realizadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado de Comisiones por Vendedor -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Comisiones por Vendedor</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="commissionsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Vendedor</th>
                            <th>Email</th>
                            <th>Ventas</th>
                            <th>Total Vendido</th>
                            <th>Total Comisión</th>
                            <th>Promedio por Venta</th>
                            <th>% Comisión</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sellers as $seller)
                            <tr>
                                <td>{{ $seller['name'] }}</td>
                                <td>{{ $seller['email'] }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $seller['sales_count'] }}</span>
                                </td>
                                <td>${{ number_format($seller['total_sales'], 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-success">
                                        ${{ number_format($seller['total_commission'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>${{ number_format($seller['average_sale'], 0, ',', '.') }}</td>
                                <td>
                                    @if($seller['total_sales'] > 0)
                                        {{ number_format(($seller['total_commission'] / $seller['total_sales']) * 100, 2) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Gráfico de Comisiones -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Distribución de Comisiones</h3>
        </div>
        <div class="card-body">
            <canvas id="commissionsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
            $('#commissionsTable').DataTable({
                "responsive": true,
                "lengthChange": true,
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
                    "searchPlaceholder": "Buscar vendedores...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles en la tabla"
                },
                "order": [[ 4, "desc" ]], // Ordenar por comisión descendente
                "columnDefs": [
                    { "type": "num", "targets": [2, 3, 4, 5, 6] }
                ]
            });

            // Configurar el gráfico de comisiones
            const ctx = document.getElementById('commissionsChart').getContext('2d');
            const sellersData = @json($sellers->take(10)->values());
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sellersData.map(seller => seller.name),
                    datasets: [{
                        label: 'Comisiones',
                        data: sellersData.map(seller => seller.total_commission),
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Top 10 Vendedores por Comisión'
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