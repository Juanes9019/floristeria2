@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 mt-4">
            <div class="card">
                <div class="card-header text-black" style="background-color: #FFB6C1;">{{ __('Arreglo personalizado') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <!-- Botón para abrir el modal de agregar insumos -->
                    <div class="d-flex justify-content-between mb-4">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#insumoModal"><i class="fas fa-box-open"></i> Agregar producto</button>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal_producto"><i class="fas fa-edit"></i> Personalizar producto predeterminado</button>
                    </div>

                    <!-- Mostrar insumos seleccionados -->
                    <div class="card mt-4">
                        <div class="card-header text-black" style="background-color: #FFB6C1;">Insumos seleccionados:</div>
                        <div class="card-body">
                        @if(session('insumosPersonalizados'))
                            <ul class="list-group">
                                @foreach(session('insumosPersonalizados') as $key => $personalizado)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $personalizado['nombre_producto'] }} - Insumo: {{ $personalizado['nombre_insumo'] }}</strong> - Cantidad: {{ $personalizado['cantidad'] }}
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
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
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

                    <!-- Total -->
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
                </div>
            </div>
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


<!-- Modal para agregar insumos -->
<div class="modal fade" id="modal_producto" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productoModalLabel">Seleccionar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('agregar_producto') }}" method="POST">
                            @csrf
                            <label for="id_producto">Selecciona el producto que desea:</label>
                            <select id="id_producto" name="id_producto" class="form-select">
                                <option value="">Selecciona el producto</option>
                                @foreach($productos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>

                            <label for="id_insumo">Selecciona el insumo:</label>
                            <select id="id_insumo" name="id_insumo" class="form-select">
                                <option value="">Selecciona el insumo</option>
                                @foreach($insumos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>

                            <label for="cantidad" class="mt-3">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" value="1">

                            <!-- Botón de envío -->
                            <button type="submit" class="btn btn-primary mt-3">Agregar Producto modificado</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div id="imagen-producto-container" class="text-center" style="max-width: 200px; margin: auto;">
                            <img id="imagen-producto" src="ruta/default.jpg" alt="imagen producto" class="img-fluid" style="display: block;">
                        </div>

                        <div id="descripcion-producto" class="mt-3">
                            <p>Por favor selecciona un producto para ver más detalles.</p>
                        </div>
                        <div id="precio-producto" class="mt-3">
                            <p><strong>Precio:</strong> $0.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
   document.addEventListener('DOMContentLoaded', function() {
    const selectProducto = document.getElementById('id_producto');
    const imagenProducto = document.getElementById('imagen-producto');
    const descripcionProducto = document.getElementById('descripcion-producto');
    const precioProducto = document.getElementById('precio-producto');

    // Asume que los datos de productos son generados en tu backend y están disponibles aquí
    const productosData = @json($productos);

    selectProducto.addEventListener('change', function() {
        const productoId = this.value;

        if (productoId) {
            // Busca el producto correspondiente al ID seleccionado
            const selectedProducto = productosData.find(producto => producto.id == productoId);

            if (selectedProducto) {
                // Actualiza la imagen del producto
                imagenProducto.src = selectedProducto.foto || 'ruta/default.jpg';

                // Actualiza la descripción
                descripcionProducto.innerHTML = `
                    <h5>${selectedProducto.nombre}</h5>
                    <p>${selectedProducto.descripcion || 'Descripción no disponible'}</p>
                `;

                // Actualiza el precio
                precioProducto.innerHTML = `<p><strong>Precio:</strong> $${parseFloat(selectedProducto.precio).toFixed(2)}</p>`;
            } else {
                // Mensaje de producto no encontrado
                descripcionProducto.innerHTML = '<p>No se encontró el producto seleccionado.</p>';
                precioProducto.innerHTML = '<p><strong>Precio:</strong> $0.00</p>';
            }
        } else {
            // Restablece si no hay selección
            imagenProducto.src = 'ruta/default.jpg';
            descripcionProducto.innerHTML = '<p>Por favor selecciona un producto para ver más detalles.</p>';
            precioProducto.innerHTML = '<p><strong>Precio:</strong> $0.00</p>';
        }
    });
});

</script>





@endsection
