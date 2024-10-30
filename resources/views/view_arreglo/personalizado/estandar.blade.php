<div class="card mt-4">
    <div class="card-header text-black" style="background-color: #FFB6C1;">Productos seleccionados:</div>
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


<!-- Modal para agregar productos -->
<div class="modal fade" id="modal_producto_nuevo" tabindex="-1" aria-labelledby="modalProductoNuevoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductoNuevoLabel">Seleccionar producto nuevo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
        <!-- Columna izquierda: Formulario -->
        <div class="col-md-6">
            <form action="{{ route('agregar_producto_nuevo') }}" method="POST">
                @csrf
                <label for="id_producto_nuevo">Selecciona el producto que desea:</label>
                <select id="id_producto_nuevo" name="id_producto_nuevo" class="form-select">
                    <option value="">Selecciona el producto</option>
                    @foreach($productos as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>

                <div id="modificarDiv" class="modificar mt-3">
                    <!-- Aquí se mostrarán los insumos del producto -->
                </div>

                <label for="id_insumo_nuevo" class="mt-3">Puedes agregar un insumo adicional:</label>
                <select id="id_insumo_nuevo" name="id_insumo_nuevo" class="form-select">
                    <option value="">Selecciona el insumo</option>
                    @foreach($insumos as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>

                <label for="cantidad_nueva" class="mt-3">Cantidad:</label>
                <input type="number" id="cantidad_nueva" name="cantidad_nueva" class="form-control" min="1" value="1">

                <!-- Botón de envío -->
                <button type="submit" class="btn btn-primary mt-3">Agregar Producto Modificado</button>
            </form>
        </div>

        <!-- Columna derecha: Información del producto -->
        <div class="col-md-6">
            <div id="imagen-producto-nuevo-container" class="text-center mb-3" style="max-width: 200px; margin: auto;">
                <img id="imagen-producto-nuevo" src="ruta/default.jpg" alt="imagen producto" class="img-fluid">
            </div>

            <div id="descripcion-producto-nuevo" class="mt-3">
                <p>Por favor selecciona un producto para ver más detalles.</p>
            </div>
            <div id="precio-producto-nuevo" class="mt-3">
                <p><strong>Precio:</strong> $0.00</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const modificarDiv = document.getElementById("modificarDiv");
    const selectProducto = document.getElementById("id_producto_nuevo");
    const imagenProducto = document.getElementById("imagen-producto-nuevo");
    const descripcionProducto = document.getElementById("descripcion-producto-nuevo");
    const precioProducto = document.getElementById("precio-producto-nuevo");

    const productosData = @json($productos);

    // Función para mostrar los insumos cuando se selecciona un producto
    selectProducto.addEventListener("change", function () {
        const productoId = this.value;
        modificarDiv.innerHTML = "<p>Este arreglo tiene estos productos:</p>";

        if (productoId) {
            // Hacer la solicitud AJAX para obtener insumos
            fetch('/obtener-insumos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ producto_id: productoId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                if (data.length > 0) {
                    let insumosList = '<ul>';
                    data.forEach(insumo => {
                        insumosList += `<li>${insumo.nombre}, se utilizó esta cantidad: ${insumo.cantidad_usada}</li>`;
                    });
                    insumosList += '</ul>';
                    modificarDiv.innerHTML += insumosList; 
                } else {
                    modificarDiv.innerHTML += '<p>No se encontraron insumos para este producto.</p>';
                }

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
            })
            .catch(error => console.error('Error:', error));
        } else {
            modificarDiv.innerHTML = ''; // Limpiar si no se selecciona ningún producto
            // Restablece la imagen y descripción si no hay selección
            imagenProducto.src = 'ruta/default.jpg';
            descripcionProducto.innerHTML = '<p>Por favor selecciona un producto para ver más detalles.</p>';
            precioProducto.innerHTML = '<p><strong>Precio:</strong> $0.00</p>';
        }
    });
});
</script>
