@extends('adminlte::page')

@section('title', 'Vendedores')

@section('content_header')
    <h1>Vendedores</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Vendedores</h3>
            <div class="card-tools">
                @can('manage-admin')
                    <a href="{{ route('admin.sellers.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Vendedor
                    </a>
                @else
                    <button type="button" class="btn btn-primary btn-sm" disabled title="Solo administradores">
                        <i class="fas fa-plus"></i> Nuevo Vendedor
                    </button>
                @endcan
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="sellers-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sellers as $seller)
                            <tr>
                                <td>{{ $seller->id }}</td>
                                <td>
                                    <strong>{{ $seller->name }}</strong>
                                </td>
                                <td>{{ $seller->email }}</td>
                                <td>{{ $seller->phone ?: 'N/A' }}</td>
                                <td>
                                    @if($seller->active)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>{{ $seller->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.sellers.show', $seller) }}" class="btn btn-info btn-sm" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('manage-admin')
                                            <a href="{{ route('admin.sellers.edit', $seller) }}" class="btn btn-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.sellers.toggle-status', $seller) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning btn-sm" title="Cambiar Estado">
                                                    <i class="fas fa-toggle-{{ $seller->active ? 'on' : 'off' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.sellers.destroy', $seller) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este vendedor?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-primary btn-sm" disabled title="Solo administradores">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" disabled title="Solo administradores">
                                                <i class="fas fa-toggle-{{ $seller->active ? 'on' : 'off' }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" disabled title="Solo administradores">
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
        
        <div class="card-footer">
            {{ $sellers->links() }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sellers-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    "decimal": ",",
                    "thousands": ".",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoPostFix": "",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "loadingRecords": "Cargando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "searchPlaceholder": "Buscar vendedores...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                order: [[0, 'desc']]
            });
        });
    </script>
@stop