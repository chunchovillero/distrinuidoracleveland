@extends('adminlte::page')
@section('title', 'Editar Tipo de Despacho')
@section('content_header')
    <h1><i class="fas fa-truck"></i> Editar Tipo de Despacho</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Información del tipo de despacho</h3></div>
        <form action="{{ route('admin.dispatch-types.update', $dispatchType) }}" method="POST">
            @csrf
            @method('PUT')
            @include('dispatch-types._form')
        </form>
    </div>
@stop
