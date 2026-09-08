@extends('adminlte::page')

@section('title', 'Ver Vendedor')

@section('content_header')
    <h1>{{ $seller->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del Vendedor</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID:</dt>
                        <dd class="col-sm-8">{{ $seller->id }}</dd>
                        
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $seller->name }}</dd>
                        
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $seller->email }}</dd>
                        
                        <dt class="col-sm-4">Teléfono:</dt>
                        <dd class="col-sm-8">{{ $seller->phone ?: 'No registrado' }}</dd>
                        
                        <dt class="col-sm-4">Dirección:</dt>
                        <dd class="col-sm-8">{{ $seller->address ?: 'No registrada' }}</dd>
                        
                        <dt class="col-sm-4">Estado:</dt>
                        <dd class="col-sm-8">
                            @if($seller->active)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-4">Registro:</dt>
                        <dd class="col-sm-8">{{ $seller->created_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-4">Actualización:</dt>
                        <dd class="col-sm-8">{{ $seller->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.sellers.edit', $seller) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('admin.sellers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
            
            <!-- Estadísticas del Vendedor -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estadísticas</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Ventas</span>
                                    <span class="info-box-number">{{ $sales->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Comisiones</span>
                                    <span class="info-box-number">${{ number_format($totalCommissions, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Historial de Ventas</h3>
                </div>
                <div class="card-body">
                    @if($sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Venta</th>
                                        <th>Cliente</th>
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
                                            <td>{{ $sale->invoice_number }}</td>
                                            <td>{{ $sale->customer->name }}</td>
                                            <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                            <td>${{ number_format($sale->total, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    ${{ number_format($sale->total_commission, 0, ',', '.') }}
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
                        <div class="mt-3">
                            {{ $sales->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Este vendedor aún no tiene ventas registradas.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop