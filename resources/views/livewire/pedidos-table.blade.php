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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>
                
                        <div class="d-flex">
                            <div class="dropdown mr-2">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportar
                                </button>
                                <div class="dropdown-menu" aria-labelledby="exportDropdown">
                                    <a class="dropdown-item" href="{{ route('Admin.pedidos.export', ['format' => 'xlsx']) }}">
                                        {{ __('Exportar a Excel') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('Admin.pedidos.export', ['format' => 'pdf']) }}">
                                        {{ __('Exportar a PDF') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead class="table">
                            <tr>
                                <th scope="col" class="text-center">
                                    Usuario
                                </th>
                                <th scope="col" class="text-center">
                                    Total
                                </th>
                                <th scope="col" class="text-center">
                                    Fecha_pedido
                                </th>
                                <th scope="col" class="text-center">
                                    Comprobante de pago
                                </th>
                                <th scope="col" class="text-center" wire:click="sortBy('estado')">
                                    Estado
                                    @if ($ordenarColumna === 'estado')
                                    @if ($ordenarForma === 'asc')
                                    <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                    </svg>
                                    @else
                                    <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                    </svg>
                                    @endif
                                    @else
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                    </svg>
                                    @endif
                                </th>
                                <th scope="col" class="text-center" colspan="3">
                                    Acciones
                                </th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($pedidos->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No hay pedidos disponibles.</td>
                                </tr>
                            @else
                                @foreach($pedidos as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->user_id }}</td>
                                        <td class="text-center">{{ number_format($item->total, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->fechapedido }}</td>
                                        <td class="text-center">
                                            <div class="image-container">
                                                <img src="{{ $item->comprobante_url }}" alt="Comprobante de pago" class="thumbnail">
                                                <div class="overlay-wrapper">
                                                    <div class="image-overlay">
                                                        <img src="{{ $item->comprobante_url }}" alt="Comprobante de pago" class="full-image">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->estado === 'nuevo')
                                                <button type="button" class="btn btn-primary" 
                                                    wire:click="changeStatus({{ $item->id }}, 'accept')">
                                                    Aceptar Pedido
                                                </button>
                                            @elseif ($item->estado === 'preparacion')
                                                <button type="button" class="btn btn-warning" 
                                                    wire:click="changeStatus({{ $item->id }}, 'accept')">
                                                    En Preparación
                                                </button>
                                            @elseif ($item->estado === 'en camino')
                                                <button type="button" class="btn btn-info" 
                                                    wire:click="changeStatus({{ $item->id }}, 'accept')">
                                                    En Camino
                                                </button>
                                            @elseif ($item->estado === 'entregado')
                                                <button type="button" class="btn btn-success" disabled>
                                                    Entregado
                                                </button>
                                            @elseif ($item->estado === 'rechazado')
                                                <button type="button" class="btn btn-primary" disabled>
                                                    Nuevo
                                                </button>
                                            @endif

                                            <button type="button" class="btn btn-danger" 
                                                wire:click="changeStatus({{ $item->id }}, 'reject')"
                                                @if ($item->estado !== 'nuevo') disabled @endif>
                                                Rechazar
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info verDetalleBtn" data-id="{{ $item->id }}">Ver detalle</button>
                                        </td>   
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <label>Páginas</label>
                    <select wire:model.live="porPagina">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                    <div class="mt-3">
                        {{ $pedidos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery (para capturar el evento del botón) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <div id="detalleModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Pedido - id: <span id="pedidoId"></span></h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detallePedidoContent">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
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

    .image-container {
        position: relative;
        display: inline-block;
    }

    .thumbnail {
        max-width: 100px;
        max-height: 100px;
    }

    .overlay-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        pointer-events: none;
        z-index: 1000;
        /* Asegúrate de que esté por encima del contenido */
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        overflow: hidden;
        z-index: 1001;
        /* Asegúrate de que esté por encima del overlay-wrapper */
    }

    .image-container:hover .image-overlay {
        opacity: 1;
    }

    .full-image {
        max-width: 90%;
        max-height: 90%;
    }

    .swal2-container {
        position: fixed;
        bottom: 0 !important;
        top: auto !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        box-sizing: border-box;
    }

    .swal2-popup {
        width: 100% !important;
        border-radius: 0 !important;
        margin: 0 !important;
        border: none !important;
    }
</style>

<script>
$(document).ready(function() {
    $('.verDetalleBtn').on('click', function() {
        var pedidoId = $(this).data('id');

        $('#pedidoId').text(pedidoId);

        $.ajax({
            url: '/admin/pedido/' + pedidoId + '/detalles',     
            method: 'GET',
            success: function(response) {
                // Inserta los datos en el modal
                $('#detallePedidoContent').html(response);
                // Muestra el modal
                $('#detalleModal').modal('show');
            },
            error: function() {
                alert('Error al cargar los detalles del pedido.');
            }
        });
    });
});


</script>
</div>

