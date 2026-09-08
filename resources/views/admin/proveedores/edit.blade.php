@extends('adminlte::page')

@section('title', 'Editar Proveedor')

@section('content_header')
    <h1>Editar Proveedor: {{ $proveedor->nombre }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Modificar Información del Proveedor</h3>
        <div class="card-tools">
            <a href="{{ route('admin.proveedores.show', $proveedor) }}" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> Ver Detalles
            </a>
            <a href="{{ route('admin.proveedores.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> ¡Hay errores en el formulario!</h5>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.proveedores.update', $proveedor) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre del Proveedor <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre', $proveedor->nombre) }}" 
                               required
                               maxlength="100"
                               placeholder="Ingrese el nombre del proveedor">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contacto">Persona de Contacto</label>
                        <input type="text" 
                               class="form-control @error('contacto') is-invalid @enderror" 
                               id="contacto" 
                               name="contacto" 
                               value="{{ old('contacto', $proveedor->contacto) }}" 
                               maxlength="100"
                               placeholder="Nombre del contacto principal">
                        @error('contacto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono', $proveedor->telefono) }}" 
                               maxlength="20"
                               placeholder="Número de teléfono">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $proveedor->email) }}" 
                               maxlength="100"
                               placeholder="correo@ejemplo.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                  id="direccion" 
                                  name="direccion" 
                                  rows="3"
                                  maxlength="255"
                                  placeholder="Dirección completa del proveedor">{{ old('direccion', $proveedor->direccion) }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="4"
                                  placeholder="Descripción de los productos o servicios que ofrece">{{ old('descripcion', $proveedor->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" 
                                   class="custom-control-input" 
                                   id="activo" 
                                   name="activo" 
                                   value="1" 
                                   {{ old('activo', $proveedor->activo) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="activo">Proveedor Activo</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-muted">Última actualización:</label>
                        <p class="text-muted mb-0">{{ $proveedor->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Proveedor
                        </button>
                        <a href="{{ route('admin.proveedores.show', $proveedor) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver Detalles
                        </a>
                        <a href="{{ route('admin.proveedores.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@if($proveedor->products && $proveedor->products->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-boxes"></i> Productos Asociados ({{ $proveedor->products->count() }})
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedor->products as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td>{{ $producto->name }}</td>
                            <td>${{ number_format($producto->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $producto->stock > 10 ? 'success' : ($producto->stock > 0 ? 'warning' : 'danger') }}">
                                    {{ $producto->stock }}
                                </span>
                            </td>
                            <td>
                                @if($producto->is_active)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.show', $producto) }}" 
                                   class="btn btn-info btn-sm" title="Ver producto">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $producto) }}" 
                                   class="btn btn-warning btn-sm" title="Editar producto">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@stop

@section('css')
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Validación en tiempo real
        $('input[name="email"]').on('blur', function() {
            const email = $(this).val();
            if (email && !isValidEmail(email)) {
                $(this).addClass('is-invalid');
                if (!$(this).next('.invalid-feedback').length) {
                    $(this).after('<div class="invalid-feedback">Ingrese un email válido</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });

        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
</script>
@stop