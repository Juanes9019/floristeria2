<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID Pedido</th>
                    <th class="text-center">Producto</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center">Imagen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->detalles as $detalle)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
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
