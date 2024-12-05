<div>
    <div class="row">
        <!-- Imagen del producto -->
        <div class="col-md-5 text-center mb-4">
            <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto;">
        </div>

        <!-- Detalles del producto -->
        <div class="col-md-7">
            <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p><strong>Categoría:</strong> {{ $producto->categoria_producto->nombre }}</p>
            <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2, ',', '.') }}</p>
            <p><strong>Estado:</strong> 
                <span class="badge badge-{{ $producto->estado == 1 ? 'success' : 'danger' }}">
                    {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                </span>
            </p>
        </div>
    </div>

    <!-- Insumos utilizados -->
    <h5 class="mt-4">Insumos utilizados</h5>
    @if($producto->insumos->isEmpty())
        <p>No hay insumos asociados a este producto.</p>
    @else
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($producto->insumos as $insumo)
                    <tr>
                        <td><strong>{{ $insumo->nombre }}</strong></td>
                        <td>{{ $insumo->color ? $insumo->color : 'Sin descripción' }}</td>
                        <td>{{ $insumo->pivot->cantidad_usada }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
