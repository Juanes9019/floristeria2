<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead">
                <tr>
                    <th class="text-center">Categoría</th>
                    <th class="text-center">Insumo</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Costo Unitario</th>
                    <th class="text-center">SubTotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compra->detalles as $detalle)
                <tr>
                    <td class="text-center">{{ $detalle->categoria_insumo->nombre }}</td>
                    <td class="text-center">{{ $detalle->insumo->nombre }}{{ $detalle->color ? ' - ' . $detalle->color : '' }}</td>      
                    <td class="text-center">{{ $detalle->cantidad }}</td>
                    <td class="text-center">{{ $detalle->costo_unitario }}</td>
                    <td class="text-center">{{ $detalle->subtotal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
