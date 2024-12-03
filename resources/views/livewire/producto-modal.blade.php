<div>
    <!-- Modal -->
    @if($showModal)
    <div class="modal fade show" tabindex="-1" style="display: block;" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $producto->nombre }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Detalles del producto -->
                    <div class="product-details row">
                        <div class="col-md-5 text-center mb-4">
                            <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-md-7">
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
                        <ul class="list-group">
                            @foreach($producto->insumos as $insumo)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $insumo->nombre }} {{ $insumo->color ? ' - ' . $insumo->color : '' }}
                                    <span class="badge badge-secondary">Cantidad: {{ $insumo->pivot->cantidad_usada }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Cerrar</button>
                    <a href="{{ route('Admin.productos') }}" class="btn btn-danger">Volver a la lista de productos</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
