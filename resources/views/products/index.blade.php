@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Productos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Productos</h3>
            <div class="card-tools">
                @can('create-products')
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Producto
                    </a>
                @else
                    <button type="button" class="btn btn-primary btn-sm" disabled title="Sin permisos para crear productos">
                        <i class="fas fa-plus"></i> Nuevo Producto
                    </button>
                @endcan
            </div>
        </div>
        
        <div class="card-body">
            <!-- Alerta informativa sobre eliminación de productos -->
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info"></i> Política de Eliminación de Productos</h5>
                <p class="mb-0">
                    <strong>Productos sin ventas:</strong> Se pueden eliminar permanentemente.<br>
                    <strong>Productos con ventas:</strong> No se pueden eliminar para preservar el historial. 
                    <span class="text-primary">Recomendación: Desactívalos usando el botón <i class="fas fa-times text-secondary"></i></span>
                </p>
            </div>

            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="filter-category">Categoría:</label>
                    <select class="form-control" id="filter-category">
                        <option value="">Todas</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="filter-calidad">Calidad:</label>
                    <select class="form-control" id="filter-calidad">
                        <option value="">Todas</option>
                        @if(isset($calidades))
                            @foreach($calidades as $calidad)
                                <option value="{{ $calidad->id }}">{{ $calidad->nombre }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="filter-proveedor">Proveedor:</label>
                    <select class="form-control" id="filter-proveedor">
                        <option value="">Todos</option>
                        @if(isset($proveedores))
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="filter-status">Estado:</label>
                    <select class="form-control" id="filter-status">
                        <option value="">Todos</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="filter-stock">Stock:</label>
                    <select class="form-control" id="filter-stock">
                        <option value="">Todo</option>
                        <option value="low">Bajo</option>
                        <option value="zero">Sin stock</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-secondary btn-block" id="clear-filters">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-success btn-block" onclick="showExportModal('products')">
                        <i class="fas fa-file-csv"></i> Exportar CSV
                    </button>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-primary btn-block" onclick="showImportModal()">
                        <i class="fas fa-file-import"></i> Importar
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>SKU</th>
                            <th>Categoría</th>
                            <th>Calidad</th>
                            <th>Proveedor</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Comisión</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td class="text-center">
                                @if($product->image)
                                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail">
                                @else
                                    <span class="badge badge-secondary">Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku ?? 'N/A' }}</td>
                            <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                            <td>{{ $product->calidad->nombre ?? 'Sin calidad' }}</td>
                            <td>{{ $product->proveedor->nombre ?? 'Sin proveedor' }}</td>
                            <td>${{ number_format($product->price, 0) }}</td>
                            <td>
                                @if($product->stock <= 0)
                                    <span class="badge badge-danger">{{ $product->stock }}</span>
                                @elseif($product->stock <= 10)
                                    <span class="badge badge-warning">{{ $product->stock }}</span>
                                @else
                                    <span class="badge badge-success">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td>${{ number_format($product->commission, 0, ",", ".") }}</td>
                            <td>
                                @if($product->active)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTables con configuración optimizada
            var table = $('#products-table').DataTable({
                "pageLength": 15,
                "responsive": true,
                "autoWidth": false,
                "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                       '<"row"<"col-sm-12"tr>>' +
                       '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                "language": {
                    "emptyTable": "No hay productos disponibles en el sistema. <a href=\"{{ route('admin.products.create') }}\" class=\"btn btn-primary btn-sm mt-2\"><i class=\"fas fa-plus\"></i> Crear Primer Producto</a>",
                    "zeroRecords": "No se encontraron productos que coincidan con los criterios de búsqueda",
                    "lengthMenu": "Mostrar _MENU_ productos por página",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ productos",
                    "infoEmpty": "Mostrando 0 a 0 de 0 productos",
                    "infoFiltered": "(filtrado de _MAX_ productos totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing": "Procesando...",
                    "loadingRecords": "Cargando...",
                    "searchPlaceholder": "Buscar productos...",
                    "decimal": ",",
                    "thousands": "."
                },
                "columnDefs": [
                    { "orderable": false, "targets": [1, 11] }, // Imagen y Acciones no ordenables
                    { "searchable": false, "targets": [1, 11] }, // Imagen y Acciones no buscables
                    { "width": "60px", "targets": [0] }, // ID
                    { "width": "70px", "targets": [1] }, // Imagen  
                    { "width": "120px", "targets": [3] }, // SKU
                    { "width": "100px", "targets": [7] }, // Precio
                    { "width": "80px", "targets": [8] }, // Stock
                    { "width": "80px", "targets": [9] }, // Comisión
                    { "width": "90px", "targets": [10] }, // Estado
                    { "width": "160px", "targets": [11] } // Acciones
                ],
                "order": [[ 0, "desc" ]], // Ordenar por ID descendente por defecto
                "lengthMenu": [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Todos los productos"]]
            });
            
            // Filtros del lado del cliente
            $('#filter-category').on('change', function() {
                var selectedValue = this.value;
                var selectedText = $(this).find('option:selected').text();
                
                if (selectedValue === '') {
                    table.column(4).search('').draw(); // Columna Categoría (índice 4)
                } else {
                    table.column(4).search(selectedText).draw();
                }
            });
            
            $('#filter-calidad').on('change', function() {
                var selectedValue = this.value;
                var selectedText = $(this).find('option:selected').text();
                
                if (selectedValue === '') {
                    table.column(5).search('').draw(); // Columna Calidad (índice 5)
                } else {
                    table.column(5).search(selectedText).draw();
                }
            });
            
            $('#filter-proveedor').on('change', function() {
                var selectedValue = this.value;
                var selectedText = $(this).find('option:selected').text();
                
                if (selectedValue === '') {
                    table.column(6).search('').draw(); // Columna Proveedor (índice 6)
                } else {
                    table.column(6).search(selectedText).draw();
                }
            });
            
            $('#filter-status').on('change', function() {
                if (this.value === '') {
                    table.column(10).search('').draw(); // Columna Estado (índice 10)
                } else {
                    var statusText = this.value === '1' ? 'Activo' : 'Inactivo';
                    table.column(10).search(statusText, false, false).draw();
                }
            });
            
            $('#filter-stock').on('change', function() {
                var stockFilter = this.value;
                
                // Limpiar filtros personalizados anteriores
                $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(function(fn) {
                    return fn.toString().indexOf('stockFilter') === -1;
                });
                
                if (stockFilter === 'low') {
                    // Filtro para stock bajo (1-10)
                    $.fn.dataTable.ext.search.push(function stockFilter(settings, data, dataIndex) {
                        var stock = parseInt(data[8]) || 0; // Columna de stock (índice 8)
                        return stock > 0 && stock <= 10;
                    });
                } else if (stockFilter === 'zero') {
                    // Filtro para sin stock (0)
                    $.fn.dataTable.ext.search.push(function stockFilter(settings, data, dataIndex) {
                        var stock = parseInt(data[8]) || 0; // Columna de stock (índice 8)
                        return stock === 0;
                    });
                }
                
                table.draw();
            });
            
            // Botón para limpiar filtros
            $('#clear-filters').on('click', function() {
                $('#filter-category').val('');
                $('#filter-calidad').val('');
                $('#filter-proveedor').val('');
                $('#filter-status').val('');
                $('#filter-stock').val('');
                
                // Limpiar filtros personalizados
                $.fn.dataTable.ext.search = [];
                
                table.search('').columns().search('').draw();
            });
        });

        // Función para cambiar el estado del producto
        function toggleStatus(productId) {
            if (confirm('¿Estás seguro de cambiar el estado de este producto?')) {
                fetch(`/admin/products/${productId}/toggle-status`, {
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
                        alert('Error al cambiar el estado del producto');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cambiar el estado del producto');
                });
            }
        }

        // Funciones de exportación
        function showExportModal(type) {
            // Obtener filtros actuales
            const filters = {
                category_filter: $('#filter-category').val(),
                calidad_filter: $('#filter-calidad').val(),
                proveedor_filter: $('#filter-proveedor').val(),
                status_filter: $('#filter-status').val(),
                stock_filter: $('#filter-stock').val()
            };

            $.ajax({
                url: '{{ route("admin.products.export-config") }}',
                method: 'GET',
                data: {
                    type: type,
                    ...filters
                },
                success: function(response) {
                    if (response.success) {
                        // Actualizar modal
                        $('#exportType').val(response.type);
                        
                        // Mostrar estado de configuración guardada
                        if (response.hasConfig) {
                            $('#configStatus').show();
                        } else {
                            $('#configStatus').hide();
                        }
                        
                        // Generar campos
                        let fieldsHtml = '';
                        fieldsHtml += '<div class="form-check mb-2">';
                        fieldsHtml += '<input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleAllFields(this.checked)">';
                        fieldsHtml += '<label class="form-check-label font-weight-bold" for="selectAll">Seleccionar todos</label>';
                        fieldsHtml += '</div><hr>';
                        
                        Object.keys(response.fields).forEach(function(field) {
                            const checked = response.selectedFields.includes(field) ? 'checked' : '';
                            fieldsHtml += '<div class="form-check mb-1">';
                            fieldsHtml += '<input class="form-check-input" type="checkbox" id="field_' + field + '" name="fields[]" value="' + field + '" ' + checked + '>';
                            fieldsHtml += '<label class="form-check-label" for="field_' + field + '">' + response.fields[field] + '</label>';
                            fieldsHtml += '</div>';
                        });
                        
                        $('#fieldsContainer').html(fieldsHtml);
                        
                        // Actualizar campos ocultos con filtros
                        Object.keys(filters).forEach(function(key) {
                            const input = $('input[name="' + key + '"]');
                            if (input.length) {
                                input.val(filters[key]);
                            } else {
                                $('#exportForm').append('<input type="hidden" name="' + key + '" value="' + filters[key] + '">');
                            }
                        });
                        
                        // Verificar "Seleccionar todos" si todos están seleccionados
                        updateSelectAllCheckbox();
                        
                        // Mostrar modal
                        $('#exportModal').modal('show');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading export config:', xhr.responseText);
                    alert('Error al cargar configuración de exportación');
                }
            });
        }

        function toggleAllFields(checked) {
            const checkboxes = document.querySelectorAll('#fieldsContainer input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = checked;
            });
        }

        function updateSelectAllCheckbox() {
            const checkboxes = document.querySelectorAll('#fieldsContainer input[type="checkbox"]:not(#selectAll)');
            const checkedBoxes = document.querySelectorAll('#fieldsContainer input[type="checkbox"]:not(#selectAll):checked');
            document.getElementById('selectAll').checked = checkboxes.length === checkedBoxes.length;
        }

        // Actualizar "Seleccionar todos" cuando cambie una casilla individual
        $(document).on('change', '#fieldsContainer input[type="checkbox"]:not(#selectAll)', function() {
            updateSelectAllCheckbox();
        });

        // Guardar configuración de exportación
        function saveExportConfig() {
            const exportType = document.getElementById('exportType').value;
            const selectedFields = [];
            
            // Obtener campos seleccionados
            const checkboxes = document.querySelectorAll('#fieldsContainer input[type="checkbox"]:checked:not(#selectAll)');
            checkboxes.forEach(checkbox => {
                selectedFields.push(checkbox.value);
            });
            
            if (selectedFields.length === 0) {
                alert('Debe seleccionar al menos un campo');
                return;
            }
            
            // Enviar configuración al servidor
            $.ajax({
                url: '{{ route("admin.products.save-export-config") }}',
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

        // Función para mostrar modal de importación
        function showImportModal() {
            console.log('showImportModal called - ULTRA FORCE METHOD');
            
            // Cerrar cualquier modal abierto primero
            $('.modal').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
            
            // Crear nuestro propio backdrop y modal
            const modalHTML = `
                <div id="customImportModal" style="
                    position: fixed !important;
                    top: 0 !important;
                    left: 0 !important;
                    width: 100% !important;
                    height: 100% !important;
                    background-color: rgba(0,0,0,0.5) !important;
                    z-index: 99999 !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                ">
                    <div style="
                        background: white !important;
                        border-radius: 8px !important;
                        padding: 20px !important;
                        max-width: 500px !important;
                        width: 90% !important;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
                        z-index: 100000 !important;
                        position: relative !important;
                    ">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h4 style="margin: 0; color: #333;">Importar Productos</h4>
                            <button onclick="closeCustomImportModal()" style="
                                background: none;
                                border: none;
                                font-size: 24px;
                                cursor: pointer;
                                color: #999;
                            ">&times;</button>
                        </div>
                        
                        <form id="customImportForm" enctype="multipart/form-data">
                            <input type="hidden" name="update_existing" value="1">
                            <input type="hidden" name="create_missing" value="1">
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Archivo CSV:</label>
                                <input type="file" name="file" accept=".csv,.xlsx,.xls" required style="
                                    width: 100%;
                                    padding: 8px;
                                    border: 1px solid #ddd;
                                    border-radius: 4px;
                                ">
                                <small style="color: #666; font-size: 12px;">
                                    Formato: CSV con punto y coma (;) como separador, o archivos Excel
                                </small>
                            </div>
                            
                            <div style="text-align: right;">
                                <button type="button" onclick="closeCustomImportModal()" style="
                                    background: #6c757d;
                                    color: white;
                                    border: none;
                                    padding: 10px 20px;
                                    border-radius: 4px;
                                    margin-right: 10px;
                                    cursor: pointer;
                                ">Cancelar</button>
                                <button type="submit" style="
                                    background: #007bff;
                                    color: white;
                                    border: none;
                                    padding: 10px 20px;
                                    border-radius: 4px;
                                    cursor: pointer;
                                ">Importar</button>
                            </div>
                        </form>
                        
                        <div id="customImportProgress" style="
                            display: none;
                            margin-top: 20px;
                            text-align: center;
                        ">
                            <div style="color: #007bff; font-size: 14px;">Procesando archivo...</div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remover modal anterior si existe
            $('#customImportModal').remove();
            
            // Agregar el modal al body
            $('body').append(modalHTML);
            
            console.log('Custom modal created and added to DOM');
            
            // Manejar el envío del formulario
            $('#customImportForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                // Mostrar progreso
                $('#customImportProgress').show();
                $('button[type="submit"]').prop('disabled', true);
                
                $.ajax({
                    url: '{{ route("admin.products.import") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        console.log('Import success:', response);
                        $('#customImportProgress').html('<div style="color: green; font-size: 14px;"><i class="fas fa-check-circle"></i> Productos importados correctamente</div>');
                        
                        setTimeout(function() {
                            closeCustomImportModal();
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        console.error('Import error:', xhr);
                        let errorMsg = 'Error al importar productos';
                        
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                // Manejo de errores de validación
                                const errors = Object.values(xhr.responseJSON.errors).flat();
                                errorMsg = errors.join(', ');
                            }
                        } else if (xhr.responseText) {
                            errorMsg = xhr.responseText;
                        }
                        
                        $('#customImportProgress').html('<div style="color: red; font-size: 14px;"><i class="fas fa-exclamation-triangle"></i> ' + errorMsg + '</div>');
                        $('button[type="submit"]').prop('disabled', false);
                        
                        setTimeout(function() {
                            $('#customImportProgress').hide();
                        }, 5000);
                    }
                });
            });
        }
        
        // Función para cerrar modal de importación
        function closeImportModal() {
            $('#importModal').css('display', 'none').removeClass('show');
            $('body').removeClass('modal-open');
            $(document).off('keydown.importModal');
            $('#importModal').off('click.importModal');
            console.log('Modal closed manually');
        }
        
        // Función para cerrar modal personalizado
        function closeCustomImportModal() {
            $('#customImportModal').remove();
            console.log('Custom modal closed and removed');
        }

        // Manejar envío del formulario de exportación con progreso
        $(document).on('submit', '#exportForm', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            
            // Agregar campos del formulario manualmente (excepto fields[])
            $(this).find('input:not([name^="fields"]), select').each(function() {
                if (this.name && this.value) {
                    formData.append(this.name, this.value);
                }
            });
            
            // Agregar campos seleccionados como array individual
            $('#fieldsContainer input[type="checkbox"]:checked:not(#selectAll)').each(function() {
                formData.append('fields[]', $(this).val());
            });
            
            // Mostrar barra de progreso
            $('#exportProgress').show();
            $('#exportStatus').text('Iniciando exportación...');
            updateExportProgress(10, 'Cargando productos...');
            
            // Deshabilitar botón de exportar
            $('button[type="submit"]').prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhrFields: {
                    responseType: 'blob'
                },
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = (evt.loaded / evt.total) * 100;
                            updateExportProgress(percentComplete, 'Generando archivo CSV...');
                        }
                    }, false);
                    return xhr;
                },
                success: function(blob, status, xhr) {
                    updateExportProgress(90, 'Preparando descarga...');
                    
                    // Crear enlace de descarga
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    
                    // Obtener nombre del archivo de los headers
                    const contentDisposition = xhr.getResponseHeader('Content-Disposition');
                    let filename = 'productos_' + new Date().getTime() + '.csv';  // Cambio a CSV
                    if (contentDisposition) {
                        const filenameMatch = contentDisposition.match(/filename="([^"]+)"/);
                        if (filenameMatch) {
                            filename = filenameMatch[1];
                        }
                    }
                    a.download = filename;
                    
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                    
                    updateExportProgress(100, 'Exportación completada exitosamente');
                    
                    setTimeout(function() {
                        $('#exportModal').modal('hide');
                        $('#exportProgress').hide();
                        $('button[type="submit"]').prop('disabled', false);
                    }, 2000);
                },
                error: function(xhr) {
                    console.error('Error en exportación:', xhr);
                    $('#exportStatus').html('<i class="fas fa-exclamation-triangle"></i> Error en la exportación');
                    $('#exportProgressBar').removeClass('progress-bar-striped progress-bar-animated').addClass('bg-danger');
                    $('#exportDetails').text('Error: ' + (xhr.responseJSON?.message || 'Error desconocido'));
                    
                    setTimeout(function() {
                        $('#exportProgress').hide();
                        $('button[type="submit"]').prop('disabled', false);
                    }, 3000);
                }
            });
        });

        // Manejar envío del formulario de importación con progreso
        $(document).on('submit', '#importForm', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Mostrar barra de progreso
            $('#importProgress').show();
            $('#importStatus').text('Iniciando importación...');
            updateImportProgress(10, 'Validando archivo...');
            
            // Deshabilitar botón de importar
            $('#importForm button[type="submit"]').prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = (evt.loaded / evt.total) * 50; // Upload es 50% del progreso
                            updateImportProgress(percentComplete, 'Subiendo archivo...');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    updateImportProgress(75, 'Procesando productos...');
                    
                    setTimeout(function() {
                        updateImportProgress(100, 'Importación completada exitosamente');
                        
                        setTimeout(function() {
                            closeImportModal();
                            $('#importProgress').hide();
                            $('#importForm button[type="submit"]').prop('disabled', false);
                            
                            // Recargar la página para mostrar los cambios
                            location.reload();
                        }, 2000);
                    }, 1000);
                },
                error: function(xhr) {
                    console.error('Error en importación:', xhr);
                    $('#importStatus').html('<i class="fas fa-exclamation-triangle"></i> Error en la importación');
                    $('#importProgressBar').removeClass('progress-bar-striped progress-bar-animated').addClass('bg-danger');
                    $('#importDetails').text('Error: ' + (xhr.responseJSON?.message || 'Error desconocido'));
                    
                    setTimeout(function() {
                        $('#importProgress').hide();
                        $('#importForm button[type="submit"]').prop('disabled', false);
                    }, 3000);
                }
            });
        });

        // Función para actualizar progreso de exportación
        function updateExportProgress(percent, message) {
            $('#exportProgressBar').css('width', percent + '%').attr('aria-valuenow', percent);
            $('#exportProgressText').text(Math.round(percent) + '%');
            $('#exportDetails').text(message);
            
            if (percent >= 100) {
                $('#exportProgressBar').removeClass('progress-bar-striped progress-bar-animated').addClass('bg-success');
                $('#exportStatus').html('<i class="fas fa-check"></i> Exportación completada');
            }
        }

        // Función para actualizar progreso de importación
        function updateImportProgress(percent, message) {
            $('#importProgressBar').css('width', percent + '%').attr('aria-valuenow', percent);
            $('#importProgressText').text(Math.round(percent) + '%');
            $('#importDetails').text(message);
            
            if (percent >= 100) {
                $('#importProgressBar').removeClass('progress-bar-striped progress-bar-animated').addClass('bg-success');
                $('#importStatus').html('<i class="fas fa-check"></i> Importación completada');
            }
        }
    </script>

    <style>
    /* Fix para modal que no se muestra correctamente */
    #importModal {
        z-index: 1060 !important;
    }
    
    #importModal .modal-dialog {
        margin: 30px auto;
        position: relative;
        z-index: 1061 !important;
    }
    
    #importModal .modal-content {
        background-color: white !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
        border: 1px solid #ddd;
    }
    
    /* Asegurar backdrop correcto */
    .modal-backdrop {
        z-index: 1040 !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
    </style>

    <!-- Modal de Exportación -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Configurar Exportación de Productos</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="exportForm" method="POST" action="{{ route('admin.products.export') }}">
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
                                
                                <!-- Instrucciones para CSV -->
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Nota:</strong> El archivo se exportará en formato CSV para máxima compatibilidad.
                                    <br>
                                    <small>
                                        <strong>Para convertir a Excel:</strong>
                                        <br>1. Abrir Excel → Archivo → Abrir
                                        <br>2. Seleccionar "Todos los archivos" → Elegir el archivo CSV descargado
                                        <br>3. En el asistente: Delimitado → Siguiente → Punto y coma (;) → Finalizar
                                        <br>4. Guardar Como → Formato: Libro de Excel (.xlsx)
                                    </small>
                                </div>
                            </div>
                        }
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6>Ordenar por:</h6>
                                <div class="form-group">
                                    <select class="form-control" id="sortBy" name="sort_by">
                                        <option value="id">ID (Orden de creación)</option>
                                        <option value="name">Nombre (Alfabético)</option>
                                        <option value="sku">SKU/Código</option>
                                        <option value="price">Precio</option>
                                        <option value="stock">Stock</option>
                                        <option value="category">Categoría</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Dirección:</h6>
                                <div class="form-group">
                                    <select class="form-control" id="sortDirection" name="sort_direction">
                                        <option value="asc">Ascendente (A-Z, 1-9)</option>
                                        <option value="desc">Descendente (Z-A, 9-1)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Barra de progreso para exportación -->
                        <div id="exportProgress" style="display: none;" class="mt-3">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-spinner fa-spin"></i> <span id="exportStatus">Preparando exportación...</span></h6>
                                <div class="progress">
                                    <div id="exportProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <span id="exportProgressText">0%</span>
                                    </div>
                                </div>
                                <small id="exportDetails" class="text-muted">Iniciando proceso...</small>
                            </div>
                        </div>
                        
                        <!-- Campos ocultos para mantener filtros -->
                        <input type="hidden" name="export_type" id="exportType">
                        <input type="hidden" name="category_filter" value="">
                        <input type="hidden" name="calidad_filter" value="">
                        <input type="hidden" name="proveedor_filter" value="">
                        <input type="hidden" name="status_filter" value="">
                        <input type="hidden" name="stock_filter" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-warning" onclick="saveExportConfig()">
                            <i class="fas fa-save"></i> Guardar Preferencias
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-csv"></i> Exportar CSV
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Importación -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Importar Productos desde Excel</h4>
                    <button type="button" class="close" onclick="closeImportModal()">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="importForm" method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h5><i class="fas fa-info-circle"></i> Instrucciones de Importación</h5>
                            <ul class="mb-0">
                                <li>El archivo debe ser un Excel (.xlsx) con el mismo formato que el exportado</li>
                                <li>Si un producto existe (mismo ID o SKU), se actualizará</li>
                                <li>Si un producto no existe, se creará uno nuevo</li>
                                <li>Si categoría, calidad o proveedor no existen, se crearán automáticamente</li>
                                <li>Los campos obligatorios son: Nombre, Precio y Stock</li>
                            </ul>
                        </div>
                        
                        <div class="form-group">
                            <label for="import_file">Seleccionar archivo Excel:</label>
                            <input type="file" class="form-control-file" id="import_file" name="import_file" accept=".xlsx,.xls" required>
                            <small class="form-text text-muted">Solo archivos Excel (.xlsx, .xls)</small>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="hidden" name="update_existing" value="0">
                                <input type="checkbox" class="custom-control-input" id="update_existing" name="update_existing" value="1" checked>
                                <label class="custom-control-label" for="update_existing">
                                    Actualizar productos existentes
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="hidden" name="create_missing" value="0">
                                <input type="checkbox" class="custom-control-input" id="create_missing" name="create_missing" value="1" checked>
                                <label class="custom-control-label" for="create_missing">
                                    Crear categorías, calidades y proveedores que no existan
                                </label>
                            </div>
                        </div>
                        
                        <!-- Barra de progreso para importación -->
                        <div id="importProgress" style="display: none;" class="mt-3">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-spinner fa-spin"></i> <span id="importStatus">Preparando importación...</span></h6>
                                <div class="progress">
                                    <div id="importProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <span id="importProgressText">0%</span>
                                    </div>
                                </div>
                                <small id="importDetails" class="text-muted">Iniciando proceso...</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeImportModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-import"></i> Importar Productos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop