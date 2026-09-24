@extends('adminlte::page')
@section('title', 'Tipos de Despacho')
@section('content_header')
    <h1><i class="fas fa-truck"></i> Tipos de Despacho</h1>
@stop
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Alternativas disponibles</h3>
            <div class="card-tools"><a href="{{ route('admin.dispatch-types.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nuevo tipo</a></div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead><tr><th>Nombre</th><th>Dirección</th><th>Estado</th><th>Ventas</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($dispatchTypes as $dispatchType)
                        <tr>
                            <td>{{ $dispatchType->name }}</td>
                            <td>{{ $dispatchType->requires_address ? 'Obligatoria' : 'No requerida' }}</td>
                            <td><span class="badge badge-{{ $dispatchType->active ? 'success' : 'secondary' }}">{{ $dispatchType->active ? 'Activo' : 'Inactivo' }}</span></td>
                            <td>{{ $dispatchType->sales_count }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.dispatch-types.edit', $dispatchType) }}" class="btn btn-primary btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.dispatch-types.toggle-status', $dispatchType) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-{{ $dispatchType->active ? 'warning' : 'success' }} btn-sm" title="{{ $dispatchType->active ? 'Desactivar' : 'Activar' }}"><i class="fas fa-power-off"></i></button>
                                    </form>
                                    <form action="{{ route('admin.dispatch-types.destroy', $dispatchType) }}" method="POST" onsubmit="return confirm('¿Eliminar este tipo de despacho?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Eliminar" {{ $dispatchType->sales_count ? 'disabled' : '' }}><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No hay tipos de despacho registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
