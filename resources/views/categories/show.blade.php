@extends('adminlte::page')

@section('title', 'Ver Categoría')

@section('content_header')
    <h1>{{ $category->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información de la Categoría</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID:</dt>
                        <dd class="col-sm-8">{{ $category->id }}</dd>
                        
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $category->name }}</dd>
                        
                        <dt class="col-sm-4">Descripción:</dt>
                        <dd class="col-sm-8">{{ $category->description ?: 'Sin descripción' }}</dd>
                        
                        <dt class="col-sm-4">Estado:</dt>
                        <dd class="col-sm-8">
                            @if($category->active)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-4">Productos:</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-info">{{ $category->products->count() }}</span>
                        </dd>
                        
                        <dt class="col-sm-4">Creado:</dt>
                        <dd class="col-sm-8">{{ $category->created_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-4">Actualizado:</dt>
                        <dd class="col-sm-8">{{ $category->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Productos en esta Categoría</h3>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>SKU</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->sku ?: 'N/A' }}</td>
                                            <td>${{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $product->stock > $product->min_stock ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($product->active)
                                                    <span class="badge badge-success">Activo</span>
                                                @else
                                                    <span class="badge badge-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No hay productos en esta categoría.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop