@extends('adminlte::page')

@section('title', 'Detalle del Cliente')

@section('content_header')
    <h1>{{ $customer->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del Cliente</h3>
                    <div class="card-tools">
                        @if($customer->active)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">ID:</dt>
                                <dd class="col-sm-7">{{ $customer->id }}</dd>
                                
                                <dt class="col-sm-5">Nombre:</dt>
                                <dd class="col-sm-7">{{ $customer->name }}</dd>
                                
                                <dt class="col-sm-5">Documento:</dt>
                                <dd class="col-sm-7">
                                    @if($customer->document_type && $customer->document_number)
                                        <span class="badge badge-info">{{ strtoupper($customer->document_type) }}</span>
                                        {{ $customer->document_number }}
                                    @else
                                        <span class="text-muted">No registrado</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-5">Email:</dt>
                                <dd class="col-sm-7">
                                    @if($customer->email)
                                        <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                    @else
                                        <span class="text-muted">No registrado</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">Teléfono:</dt>
                                <dd class="col-sm-7">
                                    @if($customer->phone)
                                        <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                                    @else
                                        <span class="text-muted">No registrado</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-5">Dirección:</dt>
                                <dd class="col-sm-7">{{ $customer->address ?: 'No registrada' }}</dd>
                                
                                <dt class="col-sm-5">Estado:</dt>
                                <dd class="col-sm-7">
                                    @if($customer->active)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-5">Registro:</dt>
                                <dd class="col-sm-7">{{ $customer->created_at->format('d/m/Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $customer->active ? 'warning' : 'success' }}">
                            <i class="fas fa-{{ $customer->active ? 'pause' : 'play' }}"></i> 
                            {{ $customer->active ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <!-- Historial de compras -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Historial de Compras</h3>
                </div>
                <div class="card-body">
                    @if($customer->sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Venta</th>
                                        <th>Vendedor</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->sales()->latest()->limit(10)->get() as $sale)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.sales.show', $sale) }}">
                                                    {{ $sale->invoice_number }}
                                                </a>
                                            </td>
                                            <td>{{ $sale->seller->name }}</td>
                                            <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    ${{ number_format($sale->total, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($sale->status == 'completed')
                                                    <span class="badge badge-success">Completada</span>
                                                @elseif($sale->status == 'pending')
                                                    <span class="badge badge-warning">Pendiente</span>
                                                @else
                                                    <span class="badge badge-danger">Cancelada</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.sales.show', $sale) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($customer->sales->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Mostrando las últimas 10 compras de {{ $customer->sales->count() }} total
                                </small>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Este cliente aún no tiene compras registradas.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Estadísticas del cliente -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estadísticas</h3>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Compras</span>
                            <span class="info-box-number">{{ $customer->sales->count() }}</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Gastado</span>
                            <span class="info-box-number">${{ number_format($customer->sales->sum('total'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    @if($customer->sales->count() > 0)
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-chart-line"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Promedio por Compra</span>
                                <span class="info-box-number">
                                    ${{ number_format($customer->sales->avg('total'), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary"><i class="fas fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Última Compra</span>
                                <span class="info-box-number text-sm">
                                    {{ $customer->sales->sortByDesc('sale_date')->first()->sale_date->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Acciones Rápidas</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.sales.create') }}?customer={{ $customer->id }}" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Nueva Venta
                        </a>
                        
                        @if($customer->email)
                            <a href="mailto:{{ $customer->email }}" class="btn btn-info btn-block">
                                <i class="fas fa-envelope"></i> Enviar Email
                            </a>
                        @endif
                        
                        @if($customer->phone)
                            <a href="tel:{{ $customer->phone }}" class="btn btn-primary btn-block">
                                <i class="fas fa-phone"></i> Llamar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop