@extends('adminlte::page')

@section('title', 'Detalles de Calidad')

@section('content_header')
    <div class="row">
        <div class="col-12">
            <h1>
                <i class="fas fa-eye"></i> Detalles de Calidad
                <small>{{ $calidad->nombre }}</small>
            </h1>
        </div>
    </div>
@stop

@section('content')
    <!-- Información General -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Información General
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $calidad->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td>
                                <span class="badge badge-info badge-lg">{{ $calidad->nombre }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Productos:</strong></td>
                            <td>
                                <span class="badge badge-secondary">{{ $calidad->products->count() }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Creada:</strong></td>
                            <td>{{ $calidad->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Actualizada:</strong></td>
                            <td>{{ $calidad->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    @can('edit-categories')
                        <a href="{{ route('admin.calidad.edit', $calidad) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    @endcan
                    <a href="{{ route('admin.calidad.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Estadísticas
                    </h3>
                </div>
                <div class="card-body">
                    @if($calidad->products->count() > 0)
                        <div class="row">
                            <div class="col-md-3">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $calidad->products->count() }}</h3>
                                        <p>Productos</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ number_format($calidad->products->sum('stock')) }}</h3>
                                        <p>Stock Total</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-cubes"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>${{ number_format($calidad->products->sum(function($p) { return $p->stock * $p->price; }), 0, ',', '.') }}</h3>
                                        <p>Valor Total</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>${{ number_format($calidad->products->avg('price'), 0, ',', '.') }}</h3>
                                        <p>Precio Promedio</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-calculator"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-box-open fa-3x mb-3"></i>
                            <p>No hay productos asociados a esta calidad</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Productos Asociados -->
    @if($calidad->products->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-boxes"></i> Productos con esta Calidad
                </h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>SKU</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Valor Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calidad->products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    @if($product->isLowStock())
                                        <br><small class="text-warning">
                                            <i class="fas fa-exclamation-triangle"></i> Stock bajo
                                        </small>
                                    @endif
                                </td>
                                <td>{{ $product->sku ?: '-' }}</td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td>${{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-{{ $product->stock > $product->min_stock ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <strong>${{ number_format($product->stock * $product->price, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if($product->active)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@stop

@section('css')
    <style>
        .badge-lg {
            font-size: 0.9em;
            padding: 0.5em 0.75em;
        }
        .small-box .icon {
            color: rgba(255,255,255,0.8);
        }
    </style>
@stop