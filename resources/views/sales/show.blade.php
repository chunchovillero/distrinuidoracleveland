@extends('adminlte::page')


@section('title', 'Detalle de Venta')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Venta #{{ $sale->invoice_number }}</h1>
        <div class="no-print">
            <a href="{{ route('admin.sales.pdf', $sale) }}" class="btn btn-danger mr-2"><i class="fas fa-file-pdf"></i> PDF</a>
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Éxito!</strong> {{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error:</strong> {{ session('error') }}</div>@endif
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información de la Venta</h3>
                    <div class="card-tools">
                        <span class="badge badge-{{ $sale->status == 'completed' ? 'success' : (in_array($sale->status, ['pending', 'pending_authorization']) ? 'warning' : 'danger') }}">
                            {{ ['completed' => 'Completada', 'pending_authorization' => 'En espera de autorización', 'pending' => 'Pendiente', 'cancelled' => 'Cancelada'][$sale->status] ?? ucfirst($sale->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">Venta:</dt>
                                <dd class="col-sm-7">{{ $sale->invoice_number }}</dd>
                                
                                <dt class="col-sm-5">Cliente:</dt>
                                <dd class="col-sm-7">
                                    <a href="{{ route('admin.customers.show', $sale->customer) }}">
                                        {{ $sale->customer->name }}
                                    </a>
                                    <br>
                                    <small class="text-muted">{{ $sale->customer->document_number }}</small>
                                </dd>
                                
                                <dt class="col-sm-5">Vendedor:</dt>
                                <dd class="col-sm-7">
                                    <a href="{{ route('admin.sellers.show', $sale->seller) }}">
                                        {{ $sale->seller->name }}
                                    </a>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">Fecha:</dt>
                                <dd class="col-sm-7">{{ $sale->sale_date->format('d/m/Y') }}</dd>
                                
                                <dt class="col-sm-5">Método de Pago:</dt>
                                <dd class="col-sm-7">
                                    @switch($sale->payment_method)
                                        @case('cash')
                                            <i class="fas fa-money-bill"></i> Efectivo
                                            @break
                                        @case('card')
                                            <i class="fas fa-credit-card"></i> Tarjeta
                                            @break
                                        @case('transfer')
                                            <i class="fas fa-exchange-alt"></i> Transferencia
                                            @break
                                        @case('check')
                                            <i class="fas fa-money-check"></i> Cheque
                                            @break
                                        @default
                                            {{ ['cash' => 'Efectivo', 'card' => 'Tarjeta', 'transfer' => 'Transferencia', 'check' => 'Cheque'][$sale->payment_method] ?? ucfirst($sale->payment_method) }}
                                    @endswitch
                                </dd>
                                
                                <dt class="col-sm-5">Tipo de despacho:</dt>
                                <dd class="col-sm-7">{{ $sale->dispatchType?->name ?? 'No informado' }}</dd>

                                <dt class="col-sm-5">Dirección:</dt>
                                <dd class="col-sm-7">{{ $sale->dispatch_address ?: 'No aplica' }}</dd>

                                <dt class="col-sm-5">Estado:</dt>
                                <dd class="col-sm-7">
                                    @if($sale->status == 'completed')
                                        <span class="badge badge-success">Completada</span>
                                    @elseif($sale->status == 'pending_authorization')
                                        <span class="badge badge-warning">En espera de autorización</span>
                                @elseif($sale->status == 'pending')
                                        <span class="badge badge-warning">Pendiente</span>
                                    @else
                                        <span class="badge badge-danger">Cancelada</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                    
                    @if($sale->notes)
                        <div class="row">
                            <div class="col-12">
                                <dt>Notas:</dt>
                                <dd>{{ $sale->notes }}</dd>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detalles de productos -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Productos Vendidos</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio Unit.</th>
                                    <th>Cantidad</th>
                                    <th>Comisión fija/unidad</th>
                                    <th>Comisión $</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->saleDetails as $detail)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.products.show', $detail->product) }}">
                                                {{ $detail->product->name }}
                                            </a>
                                            <br>
                                            <small class="text-muted">{{ $detail->product->sku }}</small>
                                        </td>
                                        <td>${{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>${{ number_format($detail->commission_unit_price ?? $detail->commission_percentage, 0, ",", ".") }}</td>
                                        <td>
                                            <span class="badge badge-success">
                                                ${{ number_format($detail->commission_amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <th colspan="4">TOTALES</th>
                                    <th>
                                        <span class="badge badge-success">
                                            ${{ number_format($sale->total_commission, 0, ',', '.') }}
                                        </span>
                                    </th>
                                    <th>
                                        <strong>${{ number_format($sale->total, 0, ',', '.') }}</strong>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Resumen financiero -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumen Financiero</h3>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Venta</span>
                            <span class="info-box-number">${{ number_format($sale->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-percentage"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Comisión Total</span>
                            <span class="info-box-number">${{ number_format($sale->total_commission, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Productos</span>
                            <span class="info-box-number">{{ $sale->saleDetails->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="card no-print">
                <div class="card-header">
                    <h3 class="card-title">Acciones</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group-vertical d-block">
                        @if(auth()->user()->isAdmin() && $sale->status === 'pending_authorization')
                            <form action="{{ route('admin.sales.authorize', $sale) }}" method="POST" onsubmit="return confirm('¿Autorizar esta venta y descontar stock?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Autorizar Venta</button>
                            </form>
                        @endif
                        @if(!auth()->user()->isSeller())
                        <a href="{{ route('admin.sales.duplicate', $sale) }}" class="btn btn-info btn-block">
                            <i class="fas fa-copy"></i> Duplicar Venta
                        </a>
                        
                        @if($sale->status == 'pending')
                            <form action="{{ route('admin.sales.cancel', $sale) }}" method="POST" 
                                  onsubmit="return confirm('¿Está seguro de cancelar esta venta?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-times"></i> Cancelar Venta
                                </button>
                            </form>
                        @endif
                        
                        @endif
                        <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Volver a Lista
                        </a>
                    </div>
                </div>
            </div>

            <!-- Información de auditoría -->
            <div class="card no-print">
                <div class="card-header">
                    <h3 class="card-title">Información de Sistema</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6">Creado:</dt>
                        <dd class="col-sm-6">{{ $sale->created_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-6">Actualizado:</dt>
                        <dd class="col-sm-6">{{ $sale->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <style>
        @media print {
            @page { margin: 1.2cm; }
            .no-print,
            .main-sidebar,
            .main-header,
            .content-header,
            .main-footer,
            .control-sidebar,
            .navbar {
                display: none !important;
            }
            body, .content-wrapper, .content {
                background: #fff !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .content-wrapper { min-height: 0 !important; }
            .col-md-8 { width: 100% !important; max-width: 100% !important; flex: 0 0 100% !important; }
            .col-md-4 { display: none !important; }
            .card { border: 1px solid #ddd !important; box-shadow: none !important; page-break-inside: avoid; }
            .card-header { background: #f5f5f5 !important; color: #000 !important; }
            a { color: #000 !important; text-decoration: none !important; }
        }
    </style>
@stop