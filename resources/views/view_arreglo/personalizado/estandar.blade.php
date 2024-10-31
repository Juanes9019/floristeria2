<div class="row mt-4">  
    <div class="card-header text-black rounded ml-3 mb-3" style="background-color: #FFB6C1; width: 95%;">Selecciona el producto que deseas:</div>
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
        <div id="imagen-producto-nuevo-container" class="bg-light border rounded shadow-sm p-3 mb-3" style="max-width: 100%; height: 200px; display: flex; align-items: center; justify-content: center;">
            <img id="imagen-producto-nuevo" src="ruta/default.jpg" alt="imagen producto" class="img-fluid" style="max-height: 100%; object-fit: contain;">
        </div>

        <div id="descripcion-producto-nuevo" class="bg-light border rounded shadow-sm p-3 mb-3">
            <p>Por favor selecciona un producto para ver más detalles.</p>
        </div>
        <div id="precio-producto-nuevo" class="bg-light border rounded shadow-sm p-3 mb-3">
            <p><strong>Precio:</strong> $0.00</p>
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
