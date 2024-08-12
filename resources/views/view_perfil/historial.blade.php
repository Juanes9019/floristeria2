<h2 class="text-center mb-3">Mis pedidos</h2>

@if($pedidos->isEmpty())
    <p class="text-center mb-3">En este momento no tienes pedidos realizados</p>
@else
    <div class="accordion" id="pedidosAccordion">
        <table class="table table-striped">
            <thead class="thead">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Fecha de pedido</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pedidos as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ number_format($item->total, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->fechapedido }}</td>
                    <td class="text-center">{{ $item->estado }}</td>
                    <td class="text-center">
                        <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#pedido-{{ $item->id }}" aria-expanded="false" aria-controls="pedido-{{ $item->id }}">
                            Ver Detalles
                        </button>
                    </td>
                </tr>
                <tr id="pedido-{{ $item->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $item->id }}" data-bs-parent="#pedidosAccordion">
                    <td colspan="5">
                        <div class="p-3">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-center">Pedido</th>
                                        <th class="text-center">Producto</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Importe</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center">Imagen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($item->detalles as $detalle)
                                    <tr>
                                        <td class="text-center">{{ $detalle->id_pedido }}</td>
                                        <td class="text-center">{{ $detalle->producto->nombre }}</td>
                                        <td class="text-center">{{ number_format($detalle->precio, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $detalle->cantidad }}</td>
                                        <td class="text-center">{{ number_format($detalle->importe, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <img src="{{ $detalle->imagen }}" alt="Imagen del producto" style="width: 100px; height: auto;">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
