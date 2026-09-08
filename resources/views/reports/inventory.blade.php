@extends('adminlte::page')

@section('title', 'Reporte de Inventario')

@section('content_header')
    <h1>Reporte de Inventario</h1>
@stop

@section('content')
    <!-- Resumen del Inventario -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $products->count() }}</h3>
                    <p>Total Productos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($totalValue, 0, ',', '.') }}</h3>
                    <p>Valor Total Inventario</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $lowStockCount }}</h3>
                    <p>Productos Stock Bajo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $outOfStockCount }}</h3>
                    <p>Sin Stock</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado de Productos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Estado del Inventario</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="inventoryTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>Precio</th>
                            <th>Valor Inventario</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="{{ $product['stock'] == 0 ? 'table-danger' : ($product['is_low_stock'] ? 'table-warning' : '') }}">
                                <td>{{ $product['sku'] }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['category'] }}</td>
                                <td>
                                    <span class="badge badge-{{ $product['stock'] == 0 ? 'danger' : ($product['is_low_stock'] ? 'warning' : 'success') }}">
                                        {{ $product['stock'] }}
                                    </span>
                                </td>
                                <td>{{ $product['min_stock'] }}</td>
                                <td>${{ number_format($product['price'], 0, ',', '.') }}</td>
                                <td>${{ number_format($product['inventory_value'], 0, ',', '.') }}</td>
                                <td>
                                    @if($product['stock'] == 0)
                                        <span class="badge badge-danger">Sin Stock</span>
                                    @elseif($product['is_low_stock'])
                                        <span class="badge badge-warning">Stock Bajo</span>
                                    @else
                                        <span class="badge badge-success">Normal</span>
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
    <script>
        $(document).ready(function() {
            $('#inventoryTable').DataTable({
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
                    "searchPlaceholder": "Buscar productos...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles en la tabla"
                },
                "order": [[ 3, "asc" ]], // Ordenar por stock ascendente para ver problemas primero
                "columnDefs": [
                    { "type": "num", "targets": [3, 4, 5, 6] } // Ordenamiento numérico
                ]
            });
        });
    </script>
@stop