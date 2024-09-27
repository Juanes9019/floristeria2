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
                            <div class="float-right">
                                <a href="{{ route('export_detalle.pdf') }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-file-pdf"></i> Exportar PDF
                                </a>
                            </div>
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
                                        <th class="text-center">subtotal</th>
                                        <th class="text-center">Imagen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detalles as $item)
                                        <tr>
                                            <td class="text-center">{{ ++$i }}</td>
                                            <td class="text-center">{{ $item->id_pedido }}</td>
                                            <td class="text-center">
                                                @if ($item->id_producto)
                                                    {{ optional($item->producto)->nombre ?? 'Producto no disponible' }}
                                                @else
                                                    Arreglo personalizado
                                                @endif
                                            </td>
                                            <td class="text-center">{{ number_format($item->precio, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $item->cantidad }}</td>
                                            <td class="text-center">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                @if ($item->imagen)
                                                    <img src="{{ $item->imagen }}" alt="Imagen del producto" style="width: 100px; height: auto;">
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