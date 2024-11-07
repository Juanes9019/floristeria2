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
                                <th scope="col" class="text-center" wire:click="sortBy('id')">
                                    No
                                    @if ($ordenarColumna === 'id')
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
                                <th scope="col" class="text-center">
                                    Id pedido
                                </th>
                                <th scope="col" class="text-center">
                                    Id producto
                                </th>
                                <th scope="col" class="text-center">
                                    Precio
                                </th>
                                <th scope="col" class="text-center">
                                    Cantidad
                                </th>
                                <th scope="col" class="text-center">
                                    Subtotal
                                </th>
                                <th scope="col" class="text-center">
                                    Imagen
                                </th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($detalles->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No hay detalles disponibles.</td>
                                </tr>
                            @else
                                @foreach($detalles as $item)
                                    <tr>
                                        <td class="text-center"> {{ ($detalles->currentPage() - 1) * $detalles->perPage() + $loop->iteration }}</td>
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
                        {{ $detalles->links() }}
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
    </style>
</div>

