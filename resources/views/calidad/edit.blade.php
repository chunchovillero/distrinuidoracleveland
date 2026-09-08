@extends('adminlte::page')

@section('title', 'Editar Calidad')

@section('content_header')
    <div class="row">
        <div class="col-12">
            <h1>
                <i class="fas fa-edit"></i> Editar Calidad
                <small>Modificar tipo de calidad existente</small>
            </h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Calidad</h3>
        </div>
        
        <form action="{{ route('admin.calidad.update', $calidad) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Calidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $calidad->nombre) }}" 
                                   placeholder="Ej: 1° PREMIUM, 1 ERA, etc." required>
                            @error('nombre')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Modificar el nombre de esta calidad
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Información Actual:</label>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-2">
                                    <strong>ID:</strong> {{ $calidad->id }}
                                </p>
                                <p class="mb-2">
                                    <strong>Creada:</strong> {{ $calidad->created_at->format('d/m/Y H:i') }}
                                </p>
                                <p class="mb-0">
                                    <strong>Productos asociados:</strong> 
                                    <span class="badge badge-info">{{ $calidad->products()->count() }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Actualizar Calidad
                </button>
                <a href="{{ route('admin.calidad.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </form>
    </div>
@stop