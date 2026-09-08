@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content_header')
    <h1>Editar Producto</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del Producto</h3>
                </div>
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre del Producto *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sku">SKU</label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                           id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                                    @error('sku')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Categoría *</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Seleccionar categoría...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="calidad_id">Calidad</label>
                                    <select class="form-control @error('calidad_id') is-invalid @enderror" 
                                            id="calidad_id" name="calidad_id">
                                        <option value="">Seleccionar calidad...</option>
                                        @foreach($calidades as $calidad)
                                            <option value="{{ $calidad->id }}" 
                                                    {{ old('calidad_id', $product->calidad_id) == $calidad->id ? 'selected' : '' }}>
                                                {{ $calidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('calidad_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="proveedor_id">Proveedor</label>
                                    <select class="form-control @error('proveedor_id') is-invalid @enderror" 
                                            id="proveedor_id" name="proveedor_id">
                                        <option value="">Seleccionar proveedor...</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" 
                                                    {{ old('proveedor_id', $product->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Precio *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" value="{{ old('price', $product->price) }}" 
                                               min="0" step="0.01" required>
                                        @error('price')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock *</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" name="stock" value="{{ old('stock', $product->stock) }}" 
                                           min="0" required>
                                    @error('stock')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="commission_percentage">Porcentaje de Comisión (%)</label>
                                    <input type="number" class="form-control @error('commission_percentage') is-invalid @enderror" 
                                           id="commission_percentage" name="commission_percentage" 
                                           value="{{ old('commission_percentage', $product->commission) }}" 
                                           min="0" max="100" step="0.01">
                                    @error('commission_percentage')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="active" name="active" value="1"
                                               {{ old('active', $product->active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Producto activo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Imagen del Producto</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*">
                                    <label class="custom-file-label" for="image">Seleccionar imagen...</label>
                                </div>
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Formatos permitidos: JPG, JPEG, PNG, GIF. Tamaño máximo: 2MB.
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Producto
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Imagen actual -->
            @if($product->image)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Imagen Actual</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded"
                             style="max-height: 200px;">
                        <div class="mt-2">
                            <small class="text-muted">{{ $product->image }}</small>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Información adicional -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del Sistema</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6">Creado:</dt>
                        <dd class="col-sm-6">{{ $product->created_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-6">Actualizado:</dt>
                        <dd class="col-sm-6">{{ $product->updated_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-6">Estado:</dt>
                        <dd class="col-sm-6">
                            @if($product->active)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Estadísticas de ventas -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estadísticas de Ventas</h3>
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
                            <span class="info-box-text">Ingresos</span>
                            <span class="info-box-number">${{ number_format($product->saleDetails->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Custom file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Auto-generate SKU from name if SKU is empty
        $('#name').on('blur', function() {
            if ($('#sku').val() === '') {
                let sku = $(this).val()
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, '')
                    .substring(0, 10);
                $('#sku').val(sku);
            }
        });
    </script>
@stop