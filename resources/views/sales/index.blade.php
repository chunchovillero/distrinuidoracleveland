@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <h1>Listado de Ventas</h1>
@stop

@section('content')
    @if(session('success'))<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Éxito!</strong> {{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error:</strong> {{ session('error') }}</div>@endif
    <!-- Filtros -->
    <div class="card collapsed-card">
        <div class="card-header">
            <h3 class="card-title">Filtros de Búsqueda</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: none;">
            <form method="GET" action="{{ route('admin.sales.index') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Últimos días</label>
                            <select name="last_days" class="form-control">
                                <option value="">Seleccionar...</option>
                                <option value="7" {{ request('last_days') == '7' ? 'selected' : '' }}>Últimos 7 días</option>
                                <option value="15" {{ request('last_days') == '15' ? 'selected' : '' }}>Últimos 15 días</option>
                                <option value="30" {{ request('last_days') == '30' ? 'selected' : '' }}>Últimos 30 días</option>
                                <option value="90" {{ request('last_days') == '90' ? 'selected' : '' }}>Últimos 90 días</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha desde</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha hasta</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Vendedor</label>
                            <select name="seller_id" class="form-control">
                                <option value="">Todos</option>
                                @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                        {{ $seller->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="status" class="form-control">
                                <option value="">Todos</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completadas</option>
                                <option value="pending_authorization" {{ request('status') == 'pending_authorization' ? 'selected' : '' }}>En espera de autorización</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Canceladas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ventas Registradas</h3>
            <div class="card-tools">
                @can('manage-admin')
                    <button type="button" class="btn btn-success btn-sm" onclick="showExportModal('despacho')">
                        <i class="fas fa-truck"></i> Exportar Excel - Despacho
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="showExportModal('secretaria')">
                        <i class="fas fa-file-excel"></i> Exportar Excel - Secretaría
                    </button>
                    <a href="{{ route('admin.sales.create') }}" class="btn btn-primary btn-sm">
                    <a href="{{ route('admin.sales.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nueva Venta</a>
                @can('create-sales')
                    <a href="{{ route('admin.sales.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Venta
                    </a>
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
                <table id="salesTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Venta</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Comisión</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td>
                                    <strong>{{ $sale->invoice_number }}</strong>
                                </td>
                                <td>{{ $sale->customer->name }}</td>
                                <td>{{ $sale->seller->name }}</td>
                                <td data-order="{{ $sale->sale_date->format('Y-m-d') }}">
                                    {{ $sale->sale_date->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        ${{ number_format($sale->total, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        ${{ number_format($sale->total_commission, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @if($sale->status == 'completed')
                                        <span class="badge badge-success">Completada</span>
                                    @elseif($sale->status == 'pending_authorization')
                                        <span class="badge badge-warning">En espera de autorización</span>
                                    @elseif($sale->status == 'pending')
                                        <span class="badge badge-warning">Pendiente</span>
                                    @else
                                        <span class="badge badge-danger">Cancelada</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.sales.show', $sale) }}" class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(!auth()->user()->isSeller())
                                        <a href="{{ route('admin.sales.duplicate', $sale) }}" class="btn btn-secondary btn-sm" title="Duplicar venta">
                                            <i class="fas fa-copy"></i>
                                        </a>
                                        @if($sale->status == 'pending')
                                            <form action="{{ route('admin.sales.cancel', $sale) }}" method="POST" style="display: inline;" 
                                                  onsubmit="return confirm('¿Está seguro de cancelar esta venta?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Cancelar venta">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @endif
                                        <form action="{{ route('admin.sales.destroy', $sale) }}" method="POST" style="display: inline;"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta venta?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @if(auth()->user()->isAdmin() && $sale->status === 'pending_authorization')
                                            <form action="{{ route('admin.sales.authorize', $sale) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Autorizar esta venta y descontar stock?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm" title="Autorizar venta"><i class="fas fa-check"></i></button>
                                            </form>
                                        @endif                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación manejada por DataTables -->
        </div>
    </div>

    <!-- Modal para ver productos de una venta -->
    <div class="modal fade" id="saleDetailsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalles de la Venta</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="saleDetailsContent">
                    <!-- Se carga dinámicamente -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Configuración de Exportación -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Configurar Exportación</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="exportForm" method="POST" action="{{ route('admin.sales.export') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="configStatus" style="display: none;" class="alert alert-info mb-3">
                                    <i class="fas fa-info-circle"></i> Se han cargado las preferencias guardadas para este tipo de exportación.
                                </div>
                                <h5>Seleccione los campos a exportar:</h5>
                                <div id="fieldsContainer">
                                    <!-- Los campos se cargarán dinámicamente -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Campos ocultos para mantener filtros -->
                        <input type="hidden" name="export_type" id="exportType">
                        <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                        <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                        <input type="hidden" name="last_days" value="{{ request('last_days') }}">
                        <input type="hidden" name="seller_id" value="{{ request('seller_id') }}">
                        <input type="hidden" name="customer_id" value="{{ request('customer_id') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-warning" onclick="saveExportConfig()">
                            <i class="fas fa-save"></i> Guardar Preferencias
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-excel"></i> Exportar a Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#salesTable').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pageLength": 15,
                "lengthMenu": [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Todos"]],
                "order": [[3, "desc"]], // La fecha usa data-order en formato ISO.
                "columnDefs": [
                    { "orderable": false, "targets": [-1] } // Última columna (acciones) no ordenable
                ],
                "language": {
                    "decimal": ",",
                    "thousands": ".",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoPostFix": "",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "loadingRecords": "Cargando...",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "searchPlaceholder": "Buscar ventas...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
            });

            // Limpiar filtros last_days cuando se selecciona fecha específica
            $('input[name="date_from"], input[name="date_to"]').on('change', function() {
                if ($(this).val()) {
                    $('select[name="last_days"]').val('');
                }
            });

            // Limpiar fechas específicas cuando se selecciona last_days
            $('select[name="last_days"]').on('change', function() {
                if ($(this).val()) {
                    $('input[name="date_from"], input[name="date_to"]').val('');
                }
            });
        });

        function showExportModal(type) {
            console.log('Iniciando exportación para:', type);
            
            // URL generada dinámicamente
            const baseUrl = '{{ route("admin.sales.export-config") }}';
            const url = baseUrl + '?type=' + encodeURIComponent(type);
            
            console.log('Base URL:', baseUrl);
            console.log('URL completa:', url);

            // Llamar al endpoint para obtener configuración usando jQuery AJAX
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('Datos recibidos:', data);
                    
                    if (data.success === false) {
                        throw new Error(data.message || 'Error desconocido');
                    }
                    
                    // Establecer el tipo de exportación
                    document.getElementById('exportType').value = data.type;
                    
                    // Limpiar container de campos
                    const container = document.getElementById('fieldsContainer');
                    container.innerHTML = '';
                    
                    // Agregar botones de selección
                    const buttonsDiv = document.createElement('div');
                    buttonsDiv.className = 'mb-3';
                    buttonsDiv.innerHTML = `
                        <button type="button" class="btn btn-sm btn-success mr-2" onclick="toggleAllFields(true)">
                            <i class="fas fa-check-square"></i> Seleccionar Todo
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" onclick="toggleAllFields(false)">
                            <i class="fas fa-square"></i> Deseleccionar Todo
                        </button>
                        <hr>
                    `;
                    container.appendChild(buttonsDiv);
                    
                    // Crear checkboxes para cada campo
                    const fieldsDiv = document.createElement('div');
                    fieldsDiv.className = 'row';
                    
                    if (data.fields && typeof data.fields === 'object') {
                        Object.entries(data.fields).forEach(([key, label]) => {
                            const div = document.createElement('div');
                            div.className = 'col-md-6 mb-2';
                            
                            // Verificar si este campo debe estar seleccionado
                            const isSelected = data.selectedFields ? data.selectedFields.includes(key) : true;
                            
                            div.innerHTML = `
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fields[]" 
                                           value="${key}" id="field_${key}" ${isSelected ? 'checked' : ''}>
                                    <label class="form-check-label" for="field_${key}">
                                        ${label}
                                    </label>
                                </div>
                            `;
                            
                            fieldsDiv.appendChild(div);
                        });
                    }
                    
                    container.appendChild(fieldsDiv);
                    
                    // Actualizar título del modal
                    const modalTitle = document.querySelector('#exportModal .modal-title');
                    modalTitle.textContent = `Exportar para ${type.charAt(0).toUpperCase() + type.slice(1)}`;
                    
                    // Mostrar indicador de configuración guardada
                    const configStatus = document.getElementById('configStatus');
                    if (data.hasConfig) {
                        configStatus.style.display = 'block';
                    } else {
                        configStatus.style.display = 'none';
                    }
                    
                    // Mostrar modal
                    $('#exportModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX completo:', {
                        responseText: xhr.responseText,
                        status: xhr.status,
                        statusText: xhr.statusText,
                        error: error,
                        ajaxStatus: status
                    });
                    
                    let errorMessage = 'Error desconocido';
                    if (xhr.status === 404) {
                        errorMessage = 'Ruta no encontrada (404)';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Error interno del servidor (500)';
                    } else if (xhr.responseText) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMessage = response.message || xhr.responseText;
                        } catch (e) {
                            errorMessage = xhr.responseText;
                        }
                    }
                    
                    alert('Error al cargar la configuración de exportación: ' + errorMessage);
                }
            });
        }

        // Seleccionar/deseleccionar todos los campos
        function toggleAllFields(checked) {
            const checkboxes = document.querySelectorAll('#fieldsContainer input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = checked;
            });
        }

        // Guardar configuración de exportación
        function saveExportConfig() {
            const exportType = document.getElementById('exportType').value;
            const selectedFields = [];
            
            // Obtener campos seleccionados
            const checkboxes = document.querySelectorAll('#fieldsContainer input[type="checkbox"]:checked');
            checkboxes.forEach(checkbox => {
                selectedFields.push(checkbox.value);
            });
            
            if (selectedFields.length === 0) {
                alert('Debe seleccionar al menos un campo');
                return;
            }
            
            // Enviar configuración al servidor
            $.ajax({
                url: '{{ route("admin.sales.save-export-config") }}',
                method: 'POST',
                data: {
                    export_type: exportType,
                    fields: selectedFields,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('Configuración guardada exitosamente');
                    } else {
                        alert('Error al guardar configuración: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error saving config:', xhr.responseText);
                    alert('Error al guardar configuración');
                }
            });
        }
    </script>
@stop
