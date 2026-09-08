@extends('adminlte::page')

@section('title', 'Nuevo Cliente')

@section('content_header')
    <h1>Nuevo Cliente</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del Cliente</h3>
                </div>
                <form action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nombre Completo *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
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
                                        <option value="cc" {{ old('document_type') == 'cc' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                        <option value="nit" {{ old('document_type') == 'nit' ? 'selected' : '' }}>NIT</option>
                                        <option value="ce" {{ old('document_type') == 'ce' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                        <option value="passport" {{ old('document_type') == 'passport' ? 'selected' : '' }}>Pasaporte</option>
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
                                           id="document_number" name="document_number" value="{{ old('document_number') }}">
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
                                           id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" 
                                       {{ old('active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Cliente activo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Crear Cliente
                        </button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información Adicional</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <i class="fas fa-info-circle"></i> Los campos marcados con (*) son obligatorios.
                    </p>
                    <hr>
                    <h6><i class="fas fa-shield-alt text-primary"></i> Tipos de Documento</h6>
                    <ul class="text-sm">
                        <li><strong>CC:</strong> Cédula de Ciudadanía</li>
                        <li><strong>NIT:</strong> Número de Identificación Tributaria</li>
                        <li><strong>CE:</strong> Cédula de Extranjería</li>
                        <li><strong>Pasaporte:</strong> Para ciudadanos extranjeros</li>
                    </ul>
                    <hr>
                    <h6><i class="fas fa-lightbulb text-warning"></i> Consejos</h6>
                    <ul class="text-sm">
                        <li>El nombre debe ser completo para facilitar la identificación</li>
                        <li>El documento es útil para reportes fiscales</li>
                        <li>El email se usará para notificaciones futuras</li>
                        <li>El teléfono es importante para contacto directo</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop