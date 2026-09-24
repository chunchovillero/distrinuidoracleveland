@extends('adminlte::page')

@section('title', 'Detalle del Producto')

@section('content_header')
    <h1>{{ $product->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del Producto</h3>
                    <div class="card-tools">
                        @if($product->active)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">ID:</dt>
                                <dd class="col-sm-8">{{ $product->id }}</dd>
                                
                                <dt class="col-sm-4">Nombre:</dt>
                                <dd class="col-sm-8">{{ $product->name }}</dd>
                                
                                <dt class="col-sm-4">SKU:</dt>
                                <dd class="col-sm-8">{{ $product->sku ?: 'No asignado' }}</dd>
                                
                                <dt class="col-sm-4">Categoría:</dt>
                                <dd class="col-sm-8">
                                    <a href="{{ route('admin.categories.show', $product->category) }}">
                                        {{ $product->category->name }}
                                    </a>
                                </dd>
                                
                                <dt class="col-sm-4">Precio:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge badge-info">
                                        ${{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Stock:</dt>
                                <dd class="col-sm-8">
                                    @if($product->stock <= 0)
                                        <span class="badge badge-danger">{{ $product->stock }} unidades</span>
                                        <small class="text-danger d-block">¡Sin stock!</small>
                                    @elseif($product->stock <= 5)
                                        <span class="badge badge-warning">{{ $product->stock }} unidades</span>
                                        <small class="text-warning d-block">Stock limitado</small>
                                    @else
                                        <span class="badge badge-success">{{ $product->stock }} unidades</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-4">Comisión:</dt>
                                <dd class="col-sm-8">${{ number_format($product->commission, 0, ",", ".") }}</dd>
                                
                                <dt class="col-sm-4">Estado:</dt>
                                <dd class="col-sm-8">
                                    @if($product->active)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-4">Creado:</dt>
                                <dd class="col-sm-8">{{ $product->created_at->format('d/m/Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>
                    
                    @if($product->description)
                        <div class="row">
                            <div class="col-12">
                                <dt>Descripción:</dt>
                                <dd>{{ $product->description }}</dd>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $product->active ? 'warning' : 'success' }}">
                            <i class="fas fa-{{ $product->active ? 'pause' : 'play' }}"></i> 
                            {{ $product->active ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <!-- Historial de ventas del producto -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Historial de Ventas</h3>
                </div>
                <div class="card-body">
                    @if($product->saleDetails->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Venta</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Fecha</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unit.</th>
                                        <th>Subtotal</th>
                                        <th>Comisión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->saleDetails()->with(['sale.customer', 'sale.seller'])->latest()->limit(10)->get() as $detail)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.sales.show', $detail->sale) }}">
                                                    {{ $detail->sale->invoice_number }}
                                                </a>
                                            </td>
                                            <td>{{ $detail->sale->customer->name }}</td>
                                            <td>{{ $detail->sale->seller->name }}</td>
                                            <td>{{ $detail->sale->sale_date->format('d/m/Y') }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>${{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                            <td>${{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    ${{ number_format($detail->commission_amount, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($product->saleDetails->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Mostrando las últimas 10 ventas de {{ $product->saleDetails->count() }} total</small>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Este producto aún no tiene ventas registradas.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Imagen del producto -->
            @if($product->image)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Imagen del Producto</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded"
                             style="max-height: 300px;">
                    </div>
                </div>
            @endif

            <!-- Estadísticas del producto -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estadísticas</h3>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Vendido</span>
                            <span class="info-box-number">{{ $product->saleDetails->sum('quantity') }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ingresos Generados</span>
                            <span class="info-box-number">${{ number_format($product->saleDetails->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-percentage"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Comisiones Pagadas</span>
                            <span class="info-box-number">${{ number_format($product->saleDetails->sum('commission_amount'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ventas Únicas</span>
                            <span class="info-box-number">{{ $product->saleDetails->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertas de stock -->
            @if($product->stock <= 0)
                <div class="card border-danger">
                    <div class="card-header bg-danger">
                        <h3 class="card-title text-white">
                            <i class="fas fa-exclamation-triangle"></i> Sin Stock
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-danger">
                            <strong>¡Producto sin stock!</strong><br>
                            Stock actual: {{ $product->stock }} unidades
                        </p>
                        <p class="text-muted">
                            Se recomienda reabastecer este producto urgentemente.
                        </p>
                    </div>
                </div>
            @elseif($product->stock <= 5)
                <div class="card border-warning">
                    <div class="card-header bg-warning">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-circle"></i> Stock Limitado
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-warning">
                            Stock actual: {{ $product->stock }} unidades
                        </p>
                        <p class="text-muted">
                            Considere reabastecer pronto este producto.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop