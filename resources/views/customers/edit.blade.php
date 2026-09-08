@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del Cliente</h3>
                </div>
                <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nombre Completo *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_type">Tipo de Documento</label>
                                    <select class="form-control @error('document_type') is-invalid @enderror" 
                                            id="document_type" name="document_type">
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="cc" {{ old('document_type', $customer->document_type) == 'cc' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                        <option value="nit" {{ old('document_type', $customer->document_type) == 'nit' ? 'selected' : '' }}>NIT</option>
                                        <option value="ce" {{ old('document_type', $customer->document_type) == 'ce' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                        <option value="passport" {{ old('document_type', $customer->document_type) == 'passport' ? 'selected' : '' }}>Pasaporte</option>
                                    </select>
                                    @error('document_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_number">Número de Documento</label>
                                    <input type="text" class="form-control @error('document_number') is-invalid @enderror" 
                                           id="document_number" name="document_number" value="{{ old('document_number', $customer->document_number) }}">
                                    @error('document_number')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $customer->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" 
                                       {{ old('active', $customer->active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Cliente activo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Cliente
                        </button>
                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver Cliente
                        </a>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Historial del Cliente</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6">ID:</dt>
                        <dd class="col-sm-6">{{ $customer->id }}</dd>
                        
                        <dt class="col-sm-6">Creado:</dt>
                        <dd class="col-sm-6">{{ $customer->created_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-6">Actualizado:</dt>
                        <dd class="col-sm-6">{{ $customer->updated_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-6">Estado:</dt>
                        <dd class="col-sm-6">
                            @if($customer->active)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estadísticas de Ventas</h3>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Compras</span>
                            <span class="info-box-number">{{ $customer->sales->count() }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Gastado</span>
                            <span class="info-box-number">${{ number_format($customer->sales->sum('total'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop