@extends('adminlte::page')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de pedidos</b>
                        </span>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Fecha_pedido</th>
                                    <th class="text-center">Procedencia</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center" colspan="2">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($pedidos as $item)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="text-center">{{ $item->user_id }}</td>
                                    <td class="text-center">{{ number_format($item->total, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->fechapedido }}</td>
                                    <td class="text-center">{{ $item->procedencia }}</td>
                                    <td class="text-center">{{ $item->estado }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('cambiar_estado', $item->id) }}" method="POST">
                                            @csrf
                                            @if ($item->estado === 'nuevo')
                                                <button type="submit" class="btn btn-primary">Aceptar Pedido</button>
                                            @elseif ($item->estado === 'preparacion')
                                                <button type="submit" class="btn btn-warning">En Preparación</button>
                                            @elseif ($item->estado === 'en camino')
                                                <button type="submit" class="btn btn-info">En Camino</button>
                                            @elseif ($item->estado === 'entregado')
                                                <button type="submit" class="btn btn-success" disabled>Entregado</button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('pedidos.detalles', $item->id) }}" class="btn btn-info">Ver Detalles</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .centrar-formulario {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

@stop
