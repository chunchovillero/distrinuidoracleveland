@extends('adminlte::page')

@section('title', 'Gestión de Clientes')

@section('content_header')
    <h1>Gestión de Clientes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Clientes</h3>
            <div class="card-tools">
                @can('create-customers')
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Cliente
                    </a>
                @else
                    <button type="button" class="btn btn-primary" disabled title="Sin permisos para crear clientes">
                        <i class="fas fa-plus"></i> Nuevo Cliente
                    </button>
                @endcan
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table id="customers-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Ventas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>
                                    <strong>{{ $customer->name }}</strong>
                                    @if($customer->address)
                                        <br><small class="text-muted">{{ Str::limit($customer->address, 30) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($customer->document_type && $customer->document_number)
                                        <span class="badge badge-info">{{ strtoupper($customer->document_type) }}</span>
                                        <br>{{ $customer->document_number }}
                                    @else
                                        <span class="text-muted">No registrado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($customer->email)
                                        <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                    @else
                                        <span class="text-muted">No registrado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($customer->phone)
                                        <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                                    @else
                                        <span class="text-muted">No registrado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($customer->active)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ $customer->sales->count() }}
                                    </span>
                                    @if($customer->sales->count() > 0)
                                        <br>
                                        <small class="text-success">
                                            ${{ number_format($customer->sales->sum('total'), 0, ',', '.') }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('edit-customers')
                                            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-primary btn-sm" disabled title="Sin permisos para editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endcan
                                        
                                        @can('toggle-customers')
                                            <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning btn-sm" title="Cambiar estado">
                                                    <i class="fas fa-toggle-{{ $customer->active ? 'on' : 'off' }}"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm" disabled title="Sin permisos para cambiar estado">
                                                <i class="fas fa-toggle-{{ $customer->active ? 'on' : 'off' }}"></i>
                                            </button>
                                        @endcan
                                        
                                        @can('delete-customers')
                                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" style="display: inline;" 
                                                  onsubmit="return confirm('¿Está seguro de eliminar este cliente? Se eliminarán también sus ventas asociadas.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm" disabled title="Sin permisos para eliminar">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#customers-table').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthChange: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
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
                    "searchPlaceholder": "Buscar clientes...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [7] }
                ]
            });
        });
    </script>
@stop