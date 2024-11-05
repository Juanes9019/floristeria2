<div class="row mt-4">  
    <div class="card-header text-black rounded ml-3 mb-3" style="background-color: #FFB6C1; width: 95%;">Selecciona el producto que deseas:</div>
    <div class="col-md-6">
        <form id="formAgregarInsumo" action="{{ route('agregar_producto_nuevo') }}" method="POST">
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
    let insumosActuales = [];

    const productosData = @json($productos);

    selectProducto.addEventListener("change", function () {
        const productoId = this.value;
        modificarDiv.innerHTML = "<p>Este arreglo tiene estos productos:</p>";

        if (productoId) {
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
                insumosActuales = data; // Guardar los insumos actuales
                mostrarInsumos(insumosActuales);
                actualizarProductoSeleccionado(productoId);
            })
            .catch(error => console.error('Error:', error));
        } else {
            modificarDiv.innerHTML = '';
            imagenProducto.src = 'ruta/default.jpg';
            descripcionProducto.innerHTML = '<p>Por favor selecciona un producto para ver más detalles.</p>';
            precioProducto.innerHTML = '<p><strong>Precio:</strong> $0.00</p>';
        }
    });

    function mostrarInsumos(insumos) {
        if (insumos.length > 0) {
            let insumosList = `
                <table>
                    <thead>
                        <tr>
                            <th style="width: 100px;">Nombre</th>
                            <th style="width: 100px;">Cantidad</th>
                            <th style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            insumos.forEach(insumo => {
                insumosList += `
                    <tr data-insumo-id="${insumo.id}">
                        <td>${insumo.nombre}</td>
                        <td>${insumo.cantidad_usada}</td>
                        <td style="text-align: center;">
                            <button onclick="editarInsumo(event, ${insumo.id})" class="btn btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></button>
                            <button onclick="borrarInsumo(${insumo.id})" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></button>
                        </td>
                    </tr>
                `;
            });

            insumosList += `
                    </tbody>
                </table>
            `;
            modificarDiv.innerHTML += insumosList; 
        }
    }

    function actualizarProductoSeleccionado(productoId) {
        const selectedProducto = productosData.find(producto => producto.id == productoId);
        if (selectedProducto) {
            imagenProducto.src = selectedProducto.foto || 'ruta/default.jpg';
            descripcionProducto.innerHTML = `
                <h5>${selectedProducto.nombre}</h5>
                <p>${selectedProducto.descripcion || 'Descripción no disponible'}</p>
            `;
            precioProducto.innerHTML = `<p><strong>Precio:</strong> $${parseFloat(selectedProducto.precio).toFixed(2)}</p>`;
        } else {
            descripcionProducto.innerHTML = '<p>No se encontró el producto seleccionado.</p>';
            precioProducto.innerHTML = '<p><strong>Precio:</strong> $0.00</p>';
        }
    }

    window.editarInsumo = function(event, insumoId) {
        event.preventDefault(); // Evita que se recargue la página
        const insumo = insumosActuales.find(i => i.id === insumoId);
        if (insumo) {
            // Crear un SweetAlert para editar insumo y cantidad
            Swal.fire({
                title: 'Editar Insumo',
                html: `
                    <div>
                        <label for="insumo-select">Selecciona un nuevo insumo:</label>
                        <select id="insumo-select" class="form-select">
                            <option value="">Selecciona el insumo</option>
                            @foreach($insumos as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                        <label for="cantidad-input" class="mt-3">Cantidad:</label>
                        <input type="number" id="cantidad-input" class="form-control" value="${insumo.cantidad_usada}" min="1">
                    </div>
                `,
                focusConfirm: false,
                preConfirm: () => {
                    const nuevoInsumoId = document.getElementById('insumo-select').value;
                    const nuevaCantidad = document.getElementById('cantidad-input').value;

                    // Validar la selección y la cantidad
                    if (!nuevoInsumoId || nuevaCantidad <= 0) {
                        Swal.showValidationMessage('Por favor selecciona un insumo y una cantidad válida.');
                    }

                    return { nuevoInsumoId, nuevaCantidad };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { nuevoInsumoId, nuevaCantidad } = result.value;

                    // Actualiza el insumo y cantidad en la lista
                    insumo.nombre = nuevoInsumoId; // Cambia esto para mostrar el nombre real
                    insumo.cantidad_usada = nuevaCantidad;
                    mostrarInsumos(insumosActuales); // Refresca la lista
                }
            });
        }
    };

    window.borrarInsumo = function(insumoId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás recuperar este insumo después de eliminarlo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Eliminar el insumo de la lista
                insumosActuales = insumosActuales.filter(i => i.id !== insumoId);
                mostrarInsumos(insumosActuales); // Refresca la lista

                Swal.fire('Eliminado!', 'El insumo ha sido eliminado.', 'success');
            }
        });
    };
});
</script>
