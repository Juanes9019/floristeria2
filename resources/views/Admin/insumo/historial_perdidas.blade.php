@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Historial de Pérdidas</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Insumo</th>
                <th>Cantidad Pérdida</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historialPerdidas as $perdida)
            <tr>
                <td>{{ $perdida->fecha_perdida }}</td>
                <td>{{ $perdida->insumo->nombre }}{{ $perdida->insumo->color ? ' - ' . $perdida->insumo->color : '' }}</td>
                <td>{{ $perdida->cantidad_perdida }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="form-group">
        <a href="{{ route('Admin.insumo') }}" class="btn btn-primary ">Volver</a>
        <a href="{{ route('Admin.insumo.perdida') }}" class="btn btn-danger" data-placement="left">
        {{ __('Registrar') }}
    </a>
    </div>
</div>
@endsection
