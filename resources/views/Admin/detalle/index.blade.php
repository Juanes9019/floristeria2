@extends('adminlte::page')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <b>Control de detalle de venta</b>
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
                                        <th class="text-center">id_producto</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Importe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($detalles as $item)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td class="text-center">{{ $item->id_pedido }}</td>
                                        <td class="text-center">{{ $item->id_producto }}</td>
                                        <td class="text-center">{{ number_format($item->precio, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->cantidad }}</td>
                                        <td class="text-center">{{ number_format($item->importe, 0, ',', '.') }}</td>

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
