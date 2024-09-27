@extends('adminlte::page')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                <b>Detalles del Pedido #{{ $pedido->id }}</b>
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
                                        <th class="text-center">id_pedido</th>
                                        <th class="text-center">Producto</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">subtotal</th>
                                        <th class="text-center">Imagen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedido->detalles as $detalle)
                                        <tr>
                                            <td class="text-center">{{ ++$i }}</td>
                                            <td class="text-center">{{ $detalle->id_pedido }}</td>
                                            <td class="text-center">
                                                @if ($detalle->id_producto)
                                                    {{ optional($detalle->producto)->nombre ?? 'Producto no disponible' }}
                                                @else
                                                    Arreglo personalizado
                                                @endif
                                            </td>
                                            <td class="text-center">{{ number_format($detalle->precio, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $detalle->cantidad }}</td>
                                            <td class="text-center">{{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                @if ($detalle->imagen)
                                                    <img src="{{ $detalle->imagen }}" alt="Imagen del producto" style="width: 100px; height: auto;">
                                                @else
                                                    <img src="https://i.imgur.com/ia1BeKH.png" alt="Imagen por defecto" style="width: 100px; height: auto;">
                                                @endif
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


