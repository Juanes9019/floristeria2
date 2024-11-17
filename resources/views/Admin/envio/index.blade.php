@extends('adminlte::page')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de envíos</b>
                        </span>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pedidos->isEmpty())  
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="alert alert-warning">No hay envíos para ser repartidos.</div>
                                    </td>
                                </tr>
                            @else
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
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#envioModal{{ $item->id }}"><i class="fa fa-info-circle"></i> Datos de envio</button>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#noRecibidoModal{{ $item->id }}"><i class="fa fa-exclamation-triangle"></i> No recibido</button>                                            
                                            <button type="button" class="btn btn-info">{{ ucfirst($item->estado) }}</button>
                                        </td>
                                    </tr>
            
                                    <!-- Modal Datos de Envio -->
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

                                    <!-- Modal No Recibido -->
                                    <div class="modal fade" id="noRecibidoModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="noRecibidoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="noRecibidoModalLabel">Formulario para pedido no recibido</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('envio.rechazo') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id_pedido" value="{{ $item->id }}">

                                                        <div class="mb-3">
                                                            <label for="motivo" class="form-label">Selecciona el motivo del pedido no entregado <strong style="color: red;">*</strong></label>
                                                            <select class="form-control" id="motivo" name="motivo" required>
                                                                <option selected disabled>Selecciona el motivo</option>
                                                                <option>El destinatario no se encontraba en casa</option>
                                                                <option>Dirección incorrecta o incompleta</option>
                                                                <option>No se pudo acceder a la dirección</option>
                                                                <option>Destinatario rechazó la entrega</option>
                                                                <option>Problemas con el transporte</option>
                                                                <option>Pedido extraviado</option>
                                                                <option>Otro (especificar)</option>
                                                            </select>
                                                            @error('motivo')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="descripcion">Descripción del motivo: <strong style="color: red;">*</strong></label>
                                                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="No se encontraba en casa" required></textarea>
                                                            @error('descripcion')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-danger">Confirmar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
