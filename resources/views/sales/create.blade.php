@extends('adminlte::page')

@section('title', isset($sale) ? 'Duplicar Venta' : 'Nueva Venta')

@section('content_header')
    <h1>{{ isset($sale) ? 'Duplicar Venta #' . $sale->invoice_number : 'Nueva Venta' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de la Venta</h3>
                </div>
                <form action="{{ route('admin.sales.store') }}" method="POST" id="saleForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_id">Cliente *</label>
                                    <select class="form-control select2" id="customer_id" name="customer_id" required>
                                        <option value="">Seleccionar cliente...</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" 
                                                {{ old('customer_id', isset($sale) ? $sale->customer_id : '') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} - {{ $customer->document_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seller_id">Vendedor *</label>
                                    <select class="form-control select2" id="seller_id" name="seller_id" required>
                                        <option value="">Seleccionar vendedor...</option>
                                        @foreach($sellers as $seller)
                                            <option value="{{ $seller->id }}" 
                                                {{ old('seller_id', isset($sale) ? $sale->seller_id : '') == $seller->id ? 'selected' : '' }}>
                                                {{ $seller->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seller_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sale_date">Fecha de Venta *</label>
                                    <input type="date" class="form-control" id="sale_date" name="sale_date" 
                                           value="{{ old('sale_date', date('Y-m-d')) }}" required>
                                    @error('sale_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Método de Pago</label>
                                    <select class="form-control" id="payment_method" name="payment_method">
                                        <option value="cash" {{ old('payment_method', isset($sale) ? $sale->payment_method : 'cash') == 'cash' ? 'selected' : '' }}>Efectivo</option>
                                        <option value="card" {{ old('payment_method', isset($sale) ? $sale->payment_method : 'cash') == 'card' ? 'selected' : '' }}>Tarjeta</option>
                                        <option value="transfer" {{ old('payment_method', isset($sale) ? $sale->payment_method : 'cash') == 'transfer' ? 'selected' : '' }}>Transferencia</option>
                                        <option value="check" {{ old('payment_method', isset($sale) ? $sale->payment_method : 'cash') == 'check' ? 'selected' : '' }}>Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dispatch_type_id">Tipo de despacho *</label>
                                    <select class="form-control @error('dispatch_type_id') is-invalid @enderror" id="dispatch_type_id" name="dispatch_type_id" required>
                                        <option value="">Seleccionar tipo...</option>
                                        @foreach($dispatchTypes as $dispatchType)
                                            <option value="{{ $dispatchType->id }}" data-requires-address="{{ $dispatchType->requires_address ? 1 : 0 }}"
                                                {{ old('dispatch_type_id', isset($sale) ? $sale->dispatch_type_id : '') == $dispatchType->id ? 'selected' : '' }}>
                                                {{ $dispatchType->name }}{{ ! $dispatchType->active ? ' (inactivo)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dispatch_type_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dispatch_address">Dirección de despacho <span id="dispatchAddressRequired" class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('dispatch_address') is-invalid @enderror"
                                           id="dispatch_address" name="dispatch_address" maxlength="191"
                                           value="{{ old('dispatch_address', isset($sale) ? $sale->dispatch_address : '') }}"
                                           placeholder="Calle, número, comuna y ciudad">
                                    @error('dispatch_address')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    <small id="dispatchAddressHelp" class="form-text text-muted"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notas</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', isset($sale) ? $sale->notes : '') }}</textarea>
                        </div>

                        <!-- Sección de productos -->
                        <div class="form-group">
                            <label>Productos</label>
                            <div class="input-group mb-3">
                                <select class="form-control select2" id="product_search">
                                    <option value="">Buscar producto...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" 
                                                data-stock="{{ $product->stock }}" data-commission="{{ $product->commission }}">
                                            {{ $product->name }} - ${{ number_format($product->price, 0, ',', '.') }} (Stock: {{ $product->stock }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="addProduct">
                                        <i class="fas fa-plus"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de productos seleccionados -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="productsTable">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio Unit.</th>
                                        <th>Cantidad</th>
                                        <th>Comisión fija</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="productsTableBody">
                                    <tr id="emptyProductsRow">
                                        <td colspan="6" class="text-center text-muted">No hay productos agregados</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="submitBtn" {{ isset($originalProducts) && count($originalProducts) > 0 ? '' : 'disabled' }}>
                            <i class="fas fa-save"></i> {{ isset($sale) ? 'Duplicar Venta' : 'Crear Venta' }}
                        </button>
                        <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumen de Venta</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6">Subtotal:</dt>
                        <dd class="col-sm-6" id="subtotal">$0</dd>
                        
                        <dt class="col-sm-6">Comisión Total:</dt>
                        <dd class="col-sm-6" id="totalCommission">$0</dd>
                        
                        <dt class="col-sm-6">Total:</dt>
                        <dd class="col-sm-6"><strong id="total">$0</strong></dd>
                        
                        <dt class="col-sm-6">Items:</dt>
                        <dd class="col-sm-6" id="totalItems">0</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let selectedProducts = [];
        
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap'
            });

            function updateDispatchAddressRequirement() {
                const selected = $('#dispatch_type_id option:selected');
                const requiresAddress = selected.val() && selected.data('requires-address') == 1;
                $('#dispatch_address').prop('required', requiresAddress);
                $('#dispatchAddressRequired').toggle(!!requiresAddress);
                $('#dispatchAddressHelp').text(requiresAddress
                    ? 'Obligatoria para el tipo de despacho seleccionado.'
                    : 'Opcional para el tipo de despacho seleccionado.');
            }

            $('#dispatch_type_id').on('change', updateDispatchAddressRequirement);
            updateDispatchAddressRequirement();
            
            // Si estamos duplicando una venta, cargar los productos originales
            @if(isset($originalProducts))
                @foreach($originalProducts as $detail)
                    selectedProducts.push({
                        id: {{ $detail->product_id }},
                        name: '{{ addslashes($detail->product->name) }}',
                        price: {{ $detail->unit_price }},
                        stock: {{ $detail->product->stock + $detail->quantity }}, // Stock actual + cantidad usada en venta original
                        commission: {{ $detail->commission_unit_price ?? $detail->commission_percentage }},
                        quantity: {{ $detail->quantity }}
                    });
                @endforeach
                updateProductsTable();
            @endif
            
            $('#addProduct').click(function() {
                const productSelect = $('#product_search');
                const productId = productSelect.val();
                const productOption = productSelect.find('option:selected');
                
                if (!productId) {
                    alert('Seleccione un producto');
                    return;
                }
                
                // Verificar si el producto ya está agregado
                if (selectedProducts.find(p => p.id == productId)) {
                    alert('Este producto ya está agregado');
                    return;
                }
                
                const product = {
                    id: productId,
                    name: productOption.text().split(' - ')[0],
                    price: parseFloat(productOption.data('price')),
                    stock: parseInt(productOption.data('stock')),
                    commission: parseFloat(productOption.data('commission')),
                    quantity: 1
                };
                
                selectedProducts.push(product);
                updateProductsTable();
                productSelect.val('').trigger('change');
            });
            
            function updateProductsTable() {
                const tbody = $('#productsTableBody');
                tbody.empty();
                
                if (selectedProducts.length === 0) {
                    tbody.append(`
                        <tr id="emptyProductsRow">
                            <td colspan="6" class="text-center text-muted">No hay productos agregados</td>
                        </tr>
                    `);
                    $('#submitBtn').prop('disabled', true);
                } else {
                    selectedProducts.forEach((product, index) => {
                        tbody.append(`
                            <tr>
                                <td>
                                    ${product.name}
                                    <input type="hidden" name="products[${index}][id]" value="${product.id}">
                                </td>
                                <td>$${numberFormat(product.price)}</td>
                                <td>
                                    <input type="number" class="form-control quantity-input" 
                                           data-index="${index}" value="${product.quantity}" 
                                           min="1" max="${product.stock}" style="width: 80px;">
                                    <input type="hidden" name="products[${index}][quantity]" value="${product.quantity}">
                                </td>
                                <td>$${numberFormat(product.commission)}</td>
                                <td>$${numberFormat(product.price * product.quantity)}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-product" data-index="${index}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                    $('#submitBtn').prop('disabled', false);
                }
                
                updateSummary();
            }
            
            function updateSummary() {
                let subtotal = 0;
                let totalCommission = 0;
                
                selectedProducts.forEach(product => {
                    const productSubtotal = product.price * product.quantity;
                    subtotal += productSubtotal;
                    totalCommission += (product.commission * product.quantity);
                });
                
                $('#subtotal').text('$' + numberFormat(subtotal));
                $('#totalCommission').text('$' + numberFormat(totalCommission));
                $('#total').text('$' + numberFormat(subtotal));
                $('#totalItems').text(selectedProducts.length);
            }
            
            function numberFormat(number) {
                return new Intl.NumberFormat('es-CO').format(number);
            }
            
            // Event listeners
            $(document).on('change', '.quantity-input', function() {
                const index = $(this).data('index');
                const quantity = parseInt($(this).val());
                const max = parseInt($(this).attr('max'));
                
                if (quantity > max) {
                    alert('Cantidad no puede ser mayor al stock disponible');
                    $(this).val(max);
                    return;
                }
                
                selectedProducts[index].quantity = quantity;
                $(this).siblings('input[type="hidden"]').val(quantity);
                updateProductsTable();
            });
            
            $(document).on('click', '.remove-product', function() {
                const index = $(this).data('index');
                selectedProducts.splice(index, 1);
                updateProductsTable();
            });
        });
    </script>
@stop