@extends('adminlte::page')

@section('title', 'Nueva Calidad')

@section('content_header')
    <div class="row">
        <div class="col-12">
            <h1>
                <i class="fas fa-plus"></i> Nueva Calidad
                <small>Crear un nuevo tipo de calidad</small>
            </h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Calidad</h3>
        </div>
        
        <form action="{{ route('admin.calidad.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Calidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" 
                                   placeholder="Ej: 1° PREMIUM, 1 ERA, etc." required>
                            @error('nombre')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Ingrese un nombre único para identificar este tipo de calidad
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ejemplos de Calidades Existentes:</label>
                            <div class="bg-light p-3 rounded">
                                <span class="badge badge-info mr-2">1° PREMIUM</span>
                                <span class="badge badge-info mr-2">1 ERA</span>
                                <span class="badge badge-info mr-2">1ERA-2DA</span>
                                <span class="badge badge-info mr-2">PREMIUM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Calidad
                </button>
                <a href="{{ route('admin.calidad.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </form>
    </div>
@stop