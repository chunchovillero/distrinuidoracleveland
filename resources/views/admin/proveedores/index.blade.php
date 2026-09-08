@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1>Gestión de Proveedores</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Proveedores</h3>
        <div class="card-tools">
            <a href="{{ route('admin.proveedores.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Proveedor
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> ¡Error!</h5>
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table id="proveedoresTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->id }}</td>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->contacto ?: 'N/A' }}</td>
                            <td>{{ $proveedor->telefono ?: 'N/A' }}</td>
                            <td>{{ $proveedor->email ?: 'N/A' }}</td>
                            <td>
                                @if($proveedor->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.proveedores.show', $proveedor) }}" 
                                       class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.proveedores.edit', $proveedor) }}" 
                                       class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-{{ $proveedor->activo ? 'secondary' : 'success' }} btn-sm" 
                                            onclick="toggleStatus({{ $proveedor->id }})" 
                                            title="{{ $proveedor->activo ? 'Desactivar' : 'Activar' }}">
                                        <i class="fas fa-{{ $proveedor->activo ? 'times' : 'check' }}"></i>
                                    </button>
                                    <form action="{{ route('admin.proveedores.destroy', $proveedor) }}" 
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css') }}">
@stop

@section('js')
    <!-- DataTables -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('#proveedoresTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                },
                "pageLength": 25,
                "order": [[ 0, "desc" ]],
                "columnDefs": [
                    { "orderable": false, "targets": [6] }
                ]
            });
        });

        function toggleStatus(proveedorId) {
            if (confirm('¿Estás seguro de cambiar el estado de este proveedor?')) {
                fetch(`/admin/proveedores/${proveedorId}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al cambiar el estado del proveedor');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cambiar el estado del proveedor');
                });
            }
        }
    </script>
@stop