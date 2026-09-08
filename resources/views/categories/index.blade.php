@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Categorías</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Categorías</h3>
            <div class="card-tools">
                @can('manage-admin')
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Categoría
                    </a>
                @else
                    <button type="button" class="btn btn-primary btn-sm" disabled title="Solo administradores">
                        <i class="fas fa-plus"></i> Nueva Categoría
                    </button>
                @endcan
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="categories-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Productos</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                </td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $category->products_count }}</span>
                                </td>
                                <td>
                                    @if($category->active)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info btn-sm" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('manage-admin')
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning btn-sm" title="Cambiar Estado">
                                                    <i class="fas fa-toggle-{{ $category->active ? 'on' : 'off' }}"></i>
                                                </button>
                                            </form>
                                            @if($category->products_count == 0)
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar esta categoría?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-primary btn-sm" disabled title="Solo administradores">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" disabled title="Solo administradores">
                                                <i class="fas fa-toggle-{{ $category->active ? 'on' : 'off' }}"></i>
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
            {{ $categories->links() }}
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
            $('#categories-table').DataTable({
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
                    "searchPlaceholder": "Buscar categorías...",
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