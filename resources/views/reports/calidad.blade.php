@extends('adminlte::page')

@section('title', 'Reporte de Calidad de Productos')

@section('content_header')
    <div class="row">
        <div class="col-12">
            <h1>
                <i class="fas fa-chart-pie"></i> Reporte de Calidad de Productos
                <small>Análisis de productos por tipo de calidad</small>
            </h1>
        </div>
    </div>
@stop

@section('content')
    <!-- Estadísticas Generales -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total de Productos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $productsWithCalidad }}</h3>
                    <p>Con Calidad Asignada</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $productsWithoutCalidad }}</h3>
                    <p>Sin Calidad Asignada</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format(($productsWithCalidad / $totalProducts) * 100, 1) }}%</h3>
                    <p>Porcentaje Clasificado</p>
                </div>
                <div class="icon">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Distribución -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i> Distribución por Calidad
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="calidadChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabla de Resumen por Calidad -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i> Resumen por Calidad
                    </h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Calidad</th>
                                <th>Productos</th>
                                <th>Stock Total</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stockByCalidad as $item)
                                <tr>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $item->calidad->nombre ?? 'Sin Calidad' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->count }}</td>
                                    <td>{{ number_format($item->total_stock) }}</td>
                                    <td>${{ number_format($item->total_value, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            @if($productsWithoutCalidad > 0)
                                <tr>
                                    <td>
                                        <span class="badge badge-secondary">Sin Calidad</span>
                                    </td>
                                    <td>{{ $productsWithoutCalidad }}</td>
                                    <td colspan="2" class="text-center text-muted">-</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Productos por Valor -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-trophy"></i> Top 10 Productos más Valiosos
                    </h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Calidad</th>
                                <th>Stock</th>
                                <th>Precio Unitario</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        @if($product->sku)
                                            <br><small class="text-muted">SKU: {{ $product->sku }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->calidad)
                                            <span class="badge badge-info">{{ $product->calidad->nombre }}</span>
                                        @else
                                            <span class="badge badge-secondary">Sin Calidad</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($product->stock) }}</td>
                                    <td>${{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <strong>${{ number_format($product->total_value, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos con Stock Bajo por Calidad -->
    @if($lowStockByCalidad->isNotEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle"></i> Productos con Stock Bajo por Calidad
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach($lowStockByCalidad as $calidad => $products)
                            <div class="mb-3">
                                <h5>
                                    <span class="badge badge-warning">{{ $calidad ?: 'Sin Calidad' }}</span>
                                    ({{ $products->count() }} productos)
                                </h5>
                                <div class="row">
                                    @foreach($products as $product)
                                        <div class="col-md-3 mb-2">
                                            <div class="alert alert-warning mb-1 py-2">
                                                <strong>{{ $product->name }}</strong><br>
                                                <small>Stock: {{ $product->stock }}/{{ $product->min_stock }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card mt-3"><div class="card-header"><h3 class="card-title"><i class="fas fa-trophy"></i> Calidades más vendidas</h3></div><div class="card-body"><form method="GET" class="form-inline mb-3"><label class="mr-2">Desde</label><input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control mr-2"><label class="mr-2">Hasta</label><input type="date" name="date_to" value="{{ $dateTo }}" class="form-control mr-2"><button class="btn btn-primary">Filtrar</button></form><div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Calidad</th><th>Unidades vendidas</th><th>Total vendido</th></tr></thead><tbody>@forelse($salesByCalidad as $item)<tr><td>{{ $item->calidad_nombre ?? "Sin Calidad" }}</td><td>{{ number_format($item->quantity_sold) }}</td><td>${{ number_format($item->total_sales, 0, ",", ".") }}</td></tr>@empty<tr><td colspan="3" class="text-center">No hay ventas completadas en el rango seleccionado.</td></tr>@endforelse</tbody></table></div></div></div>
@stop

@section('css')
    <style>
        .small-box .icon {
            color: rgba(255,255,255,0.8);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Gráfico de distribución por calidad
            const ctx = document.getElementById('calidadChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        data: @json($chartData),
                        backgroundColor: [
                            '#007bff',
                            '#28a745', 
                            '#ffc107',
                            '#dc3545',
                            '#6c757d',
                            '#17a2b8'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((sum, value) => sum + value, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@stop
