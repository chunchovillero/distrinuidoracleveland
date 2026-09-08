@extends('adminlte::page')

@section('title', 'Reporte de Clientes')

@section('content_header')
    <h1>Reporte de Clientes</h1>
@stop

@section('content')
    <!-- Filtros -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtros del Reporte</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.customers') }}">
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

    <!-- Resumen de Clientes -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $customers->count() }}</h3>
                    <p>Clientes Activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($customers->sum('total_purchases'), 0, ',', '.') }}</h3>
                    <p>Total Compras</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $customers->sum('purchase_count') }}</h3>
                    <p>Transacciones</p>
                </div>
                <div class="icon">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>${{ number_format($customers->avg('average_purchase'), 0, ',', '.') }}</h3>
                    <p>Promedio por Cliente</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Clientes -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Top Clientes por Compras</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="customersTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Compras</th>
                            <th>Total Gastado</th>
                            <th>Promedio por Compra</th>
                            <th>Última Compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer['name'] }}</td>
                                <td>{{ $customer['email'] ?: 'No registrado' }}</td>
                                <td>{{ $customer['phone'] ?: 'No registrado' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $customer['purchase_count'] }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        ${{ number_format($customer['total_purchases'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>${{ number_format($customer['average_purchase'], 0, ',', '.') }}</td>
                                <td>
                                    @if($customer['last_purchase'])
                                        {{ \Carbon\Carbon::parse($customer['last_purchase'])->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Gráfico de Top Clientes -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Top 10 Clientes por Monto</h3>
        </div>
        <div class="card-body">
            <canvas id="customersChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
            $('#customersTable').DataTable({
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
                    "searchPlaceholder": "Buscar clientes...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles en la tabla"
                },
                "order": [[ 4, "desc" ]], // Ordenar por total gastado descendente
                "columnDefs": [
                    { "type": "num", "targets": [3, 4, 5] }
                ]
            });

            // Configurar el gráfico de clientes
            const ctx = document.getElementById('customersChart').getContext('2d');
            const customersData = @json($customers->take(10)->values());
            
            new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: customersData.map(customer => customer.name.length > 20 ? customer.name.substring(0, 20) + '...' : customer.name),
                    datasets: [{
                        label: 'Total Compras',
                        data: customersData.map(customer => customer.total_purchases),
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Top 10 Clientes por Monto de Compras'
                        }
                    },
                    scales: {
                        x: {
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