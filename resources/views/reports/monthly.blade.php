@extends('adminlte::page')

@section('title', 'Reporte Mensual')

@section('content_header')
    <h1>
        <i class="fas fa-calendar-alt mr-2"></i>
        Reporte Mensual - Últimos 12 Meses
    </h1>
@stop

@section('content')
    <!-- Resumen ejecutivo -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>${{ number_format($totalYear, 0, ',', '.') }}</h3>
                    <p>Total Año</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($totalSalesCount) }}</h3>
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
                    <h3>${{ number_format($averageMonthly, 0, ',', '.') }}</h3>
                    <p>Promedio Mensual</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>${{ number_format($totalCommissionsYear, 0, ',', '.') }}</h3>
                    <p>Comisiones Año</p>
                </div>
                <div class="icon">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row">
        <!-- Gráfico de ventas -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-area mr-1"></i>
                        Evolución de Ventas por Mes
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Mejores meses -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-trophy mr-1"></i>
                        Destacados
                    </h3>
                </div>
                <div class="card-body">
                    @if($bestMonth)
                        <div class="mb-3">
                            <h6 class="text-success">
                                <i class="fas fa-arrow-up mr-1"></i>
                                Mejor Mes
                            </h6>
                            <p class="mb-1"><strong>{{ $bestMonth['month'] }}</strong></p>
                            <p class="text-muted mb-0">
                                ${{ number_format($bestMonth['total_sales'], 0, ',', '.') }} 
                                ({{ $bestMonth['sales_count'] }} ventas)
                            </p>
                        </div>
                    @endif

                    @if($worstMonth)
                        <div class="mb-3">
                            <h6 class="text-warning">
                                <i class="fas fa-arrow-down mr-1"></i>
                                Mes con Menos Ventas
                            </h6>
                            <p class="mb-1"><strong>{{ $worstMonth['month'] }}</strong></p>
                            <p class="text-muted mb-0">
                                ${{ number_format($worstMonth['total_sales'], 0, ',', '.') }} 
                                ({{ $worstMonth['sales_count'] }} ventas)
                            </p>
                        </div>
                    @endif

                    <div class="mt-3">
                        <h6 class="text-info">
                            <i class="fas fa-calculator mr-1"></i>
                            Promedio por Venta
                        </h6>
                        <p class="text-muted mb-0">
                            ${{ number_format($totalSalesCount > 0 ? $totalYear / $totalSalesCount : 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla detallada -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table mr-1"></i>
                Detalle Mensual
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="monthlyTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mes</th>
                            <th class="text-right">Total Ventas</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-right">Promedio</th>
                            <th class="text-right">Comisiones</th>
                            <th>Top Vendedor</th>
                            <th>Producto Estrella</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyData as $month)
                            <tr>
                                <td>
                                    <strong>{{ $month['month'] }}</strong>
                                </td>
                                <td class="text-right">
                                    <span class="badge badge-success badge-lg">
                                        ${{ number_format($month['total_sales'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info">
                                        {{ $month['sales_count'] }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    ${{ number_format($month['average_sale'], 0, ',', '.') }}
                                </td>
                                <td class="text-right">
                                    <span class="badge badge-warning">
                                        ${{ number_format($month['total_commissions'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @if($month['top_seller'])
                                        <div>
                                            <strong>{{ $month['top_seller']['name'] }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                ${{ number_format($month['top_seller']['total'], 0, ',', '.') }}
                                                ({{ $month['top_seller']['count'] }} ventas)
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($month['top_product'])
                                        <div>
                                            <strong>{{ Str::limit($month['top_product']->name, 20) }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $month['top_product']->quantity_sold }} unidades
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
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
            // Inicializar DataTable
            $('#monthlyTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false,
                "paging": false,
                "info": false,
                "ordering": false, // Deshabilitar ordenación para mantener orden natural
                "columnDefs": [
                    { "orderable": false, "targets": "_all" } // Todas las columnas no ordenables
                ]
            });

            // Gráfico de ventas
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Ventas ($)',
                        data: @json($chartData['sales']),
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Cantidad de Ventas',
                        data: @json($chartData['count']),
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        tension: 0.4,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Ventas ($)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Cantidad'
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.dataset.label === 'Ventas ($)') {
                                        label += '$' + context.parsed.y.toLocaleString();
                                    } else {
                                        label += context.parsed.y;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@stop