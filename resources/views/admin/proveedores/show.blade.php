@extends('adminlte::page')

@section('title', 'Detalle del Proveedor')

@section('content_header')
    <h1>Detalles del Proveedor: {{ $proveedor->nombre }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-truck"></i> Información del Proveedor
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.proveedores.edit', $proveedor) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('admin.proveedores.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong><i class="fas fa-building mr-1"></i> Nombre:</strong>
                        <p class="text-muted">{{ $proveedor->nombre }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <strong><i class="fas fa-user mr-1"></i> Contacto:</strong>
                        <p class="text-muted">{{ $proveedor->contacto ?: 'No especificado' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong><i class="fas fa-phone mr-1"></i> Teléfono:</strong>
                        <p class="text-muted">{{ $proveedor->telefono ?: 'No especificado' }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <strong><i class="fas fa-envelope mr-1"></i> Email:</strong>
                        <p class="text-muted">
                            @if($proveedor->email)
                                <a href="mailto:{{ $proveedor->email }}">{{ $proveedor->email }}</a>
                            @else
                                No especificado
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección:</strong>
                        <p class="text-muted">{{ $proveedor->direccion ?: 'No especificada' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <strong><i class="fas fa-info-circle mr-1"></i> Descripción:</strong>
                        <p class="text-muted">{{ $proveedor->descripcion ?: 'Sin descripción' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong><i class="fas fa-toggle-on mr-1"></i> Estado:</strong>
                        <p class="text-muted">
                            @if($proveedor->activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="col-md-6">
                        <strong><i class="fas fa-calendar mr-1"></i> Fecha de registro:</strong>
                        <p class="text-muted">{{ $proveedor->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($proveedor->updated_at != $proveedor->created_at)
                <div class="row">
                    <div class="col-md-12">
                        <strong><i class="fas fa-clock mr-1"></i> Última actualización:</strong>
                        <p class="text-muted">{{ $proveedor->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-boxes"></i> Productos del Proveedor
                </h3>
            </div>
            <div class="card-body">
                @if($proveedor->products && $proveedor->products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proveedor->products as $producto)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.products.show', $producto) }}">
                                                {{ $producto->name }}
                                            </a>
                                        </td>
                                        <td>${{ number_format($producto->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <strong>Total de productos: </strong>
                        <span class="badge badge-primary">{{ $proveedor->products->count() }}</span>
                    </div>
                @else
                    <div class="text-center">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay productos asociados a este proveedor</p>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Agregar Producto
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cogs"></i> Acciones Rápidas
                </h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.proveedores.edit', $proveedor) }}" 
                       class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit"></i> Editar Proveedor
                    </a>
                    
                    <button type="button" 
                            class="btn btn-{{ $proveedor->activo ? 'secondary' : 'success' }} btn-block mb-2" 
                            onclick="toggleStatus({{ $proveedor->id }})">
                        <i class="fas fa-{{ $proveedor->activo ? 'times' : 'check' }}"></i> 
                        {{ $proveedor->activo ? 'Desactivar' : 'Activar' }}
                    </button>
                    
                    <form action="{{ route('admin.proveedores.destroy', $proveedor) }}" 
                          method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar este proveedor? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash"></i> Eliminar Proveedor
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
<script>
    function toggleStatus(proveedorId) {
        if (confirm('¿Estás seguro de cambiar el estado de este proveedor?')) {
            fetch(`/admin/proveedores/${proveedorId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al cambiar el estado del proveedor');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cambiar el estado del proveedor');
            });
        }
    }
</script>
@stop