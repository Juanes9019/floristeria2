<div class="card mt-4">
    <div class="card-header text-black" style="background-color: #FFB6C1;">Productos seleccionados:</div>
    <div class="card-body">
    @if(session('insumosSeleccionados'))
        <ul class="list-group">
            @foreach(session('insumosSeleccionados') as $key => $personalizado)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $personalizado['nombre'] }}</strong> - Cantidad: {{ $personalizado['cantidad'] }}
                    </div>
                    <div class="btn-group" role="group">
                        <form action="{{ route('actualizar_producto', $key) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="action" value="incrementar" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="submit" name="action" value="decrementar" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-minus"></i>
                            </button>
                        </form>
                        <form action="{{ route('eliminar_producto', $key) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-1 btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-dark text-white">Total:</div>
    <div class="card-body">
        <p>Total: ${{ number_format($totalPrecio, 0) }}</p>
        <div class="d-flex justify-content-center">
            <form action="{{ route('add_personalizado') }}" method="POST">
                @csrf
                <button type="submit" class="btn custom-btn d-flex align-items-center justify-content-center text-white">
                    <i class="fas fa-cart-plus me-2"></i> Agregar Arreglo Personalizado al carrito
                </button>
            </form>
        </div>
    </div>
</div>


<!-- Modal para agregar insumos -->
<div class="modal fade" id="insumoModal" tabindex="-1" aria-labelledby="insumoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insumoModalLabel">Seleccionar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('agregar_producto') }}" method="POST">
                            @csrf
                            <!-- Selección de Categoría -->
                            <label for="categoria">Selecciona la categoría que desea:</label>
                            <select id="categoria" name="categoria_id" class="form-select">
                                <option value="">Selecciona la categoría</option>
                                @foreach($categorias_insumo as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>

                            <!-- Selección de Producto -->
                            <label for="producto">Selecciona el producto:</label>
                            <select id="producto" name="insumo_id" class="form-select" disabled>
                                <option value="">Selecciona un producto</option>
                            </select>

                            <!-- Cantidad -->
                            <label for="cantidad" class="mt-3">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" value="1">

                            <!-- Botón de envío -->
                            <button type="submit" class="btn btn-primary mt-3">Agregar Insumo</button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <div id="imagen-insumo-container" class="text-center" style="max-width: 200px; margin: auto;">
                            <img id="imagen-insumo" src="ruta/default.jpg" alt="imagen producto" class="img-fluid" style="display: block;">
                        </div>

                        <div id="descripcion-insumo" class="mt-3">
                            <p>Por favor selecciona un insumo para ver más detalles.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>