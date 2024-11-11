@extends('adminlte::page')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de envios</b>
                        </span>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="table">
                        <tr>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pedidos as $item)
                            <tr>
                                <td class="text-center">
                                    @foreach($item->detalles as $item_detalle)
                                        {{ $item_detalle->producto->nombre }}<br>
                                    @endforeach
                                </td>
                                <td class="text-center">{{ number_format($item->total, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->fechapedido }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn btn-info" data-toggle="modal" data-target="#envioModal{{ $item->id }}"><i class="fa fa-info-circle"></i> Datos de envio</button>
                                    <button type="button" class="btn btn-info">{{ ucfirst($item->estado) }}</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="envioModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEnvioLabel" aria-hidden="true"> 
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEnvioLabel">Detalles de Envío</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php $datosEnvio = json_decode($item->datos_envio); @endphp

                    <!-- Contenedor con el grid de Bootstrap -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Nombre Destinatario:</strong> {{ $datosEnvio->nombre_destinatario }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fecha:</strong> {{ $datosEnvio->fecha }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Departamento:</strong> {{ $datosEnvio->departamento }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Ciudad:</strong> {{ $datosEnvio->ciudad }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p><strong>Dirección:</strong> {{ $datosEnvio->direccion }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p><strong>Instrucciones de Entrega:</strong> {{ $datosEnvio->instrucciones_entrega }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p><strong>Teléfono:</strong> {{ $datosEnvio->telefono }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-body p {
            font-size: 1rem;
            line-height: 1.5;
        }

        .modal-title {
            text-align: center;
            width: 100%;
        }

        .modal-header {
            background-color: #f7f7f7;
            border-bottom: 2px solid #ddd;
        }

        .modal-title {
            font-weight: bold;
            color: #333;
        }

        .close {
            font-size: 1.5rem;
            color: #000;
        }

        .row.mb-3 {
            margin-bottom: 15px;
        }

        .modal-body .col-md-6 p,
        .modal-body .col-md-12 p {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>


    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery (para capturar el evento del botón) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .centrar-formulario {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</div>


@stop
