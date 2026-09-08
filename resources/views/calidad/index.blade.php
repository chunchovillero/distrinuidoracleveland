@extends('adminlte::page')

@section('title', 'Gestión de Calidades')

@section('content_header')
    <div class="row">
        <div class="col-12">
            <h1>
                <i class="fas fa-star"></i> Gestión de Calidades
                <small>Administrar tipos de calidad de productos</small>
            </h1>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Calidades</h3>
            <div class="card-tools">
                @can('create-categories')
                    <a href="{{ route('admin.calidad.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Calidad
                    </a>
                @else
                    <button type="button" class="btn btn-primary btn-sm" disabled title="Sin permisos para crear calidades">
                        <i class="fas fa-plus"></i> Nueva Calidad
                    </button>
                @endcan
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Productos Asociados</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calidades as $calidad)
                            <tr>
                                <td>{{ $calidad->id }}</td>
                                <td>
                                    <span class="badge badge-info badge-lg">
                                        {{ $calidad->nombre }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ $calidad->products_count }} productos
                                    </span>
                                </td>
                                <td>{{ $calidad->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('view-categories')
                                            <a href="{{ route('admin.calidad.show', $calidad) }}" 
                                               class="btn btn-info btn-sm" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-info btn-sm" disabled 
                                                    title="Sin permisos para ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endcan

                                        @can('edit-categories')
                                            <a href="{{ route('admin.calidad.edit', $calidad) }}" 
                                               class="btn btn-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-primary btn-sm" disabled 
                                                    title="Sin permisos para editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endcan

                                        @can('delete-categories')
                                            <form action="{{ route('admin.calidad.destroy', $calidad) }}" 
                                                  method="POST" style="display: inline;" 
                                                  onsubmit="return confirm('¿Está seguro de eliminar esta calidad?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        title="Eliminar" {{ $calidad->products_count > 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm" disabled 
                                                    title="Sin permisos para eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge-lg {
            font-size: 0.9em;
            padding: 0.5em 0.75em;
        }
    </style>
@stop