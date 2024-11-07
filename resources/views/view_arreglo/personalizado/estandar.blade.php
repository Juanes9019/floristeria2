<div class="row mt-4">
    <div class="card-header text-black rounded ml-3 mb-3" style="background-color: #FFB6C1; width: 95%;">
        Selecciona el producto que deseas:
    </div>
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

            <!-- Botón de envío -->            
            <button type="submit" class="btn btn-primary mt-3">Agregar Producto Modificado</button>
        </form>
    </div>

    <div class="col-md-6">
        <div id="imagen-producto-nuevo-container" class="bg-light border rounded shadow-sm p-3 mb-3"
             style="max-width: 100%; height: 200px; display: flex; align-items: center; justify-content: center;">
            <img id="imagen-producto-nuevo" src="ruta/default.jpg" alt="imagen producto" class="img-fluid"
                 style="max-height: 100%; object-fit: contain;">
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
    const insumosData = @json($insumos); // Lista de insumos para usarlos en el script

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
                insumosActuales = data;
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
            let insumosList = 
                `<table>
                    <thead>
                        <tr>
                            <th style="width: 100px;">Nombre</th>
                            <th style="width: 100px;">Cantidad</th>
                            <th style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>`;

            insumos.forEach(insumo => {
                insumosList += 
                    `<tr data-insumo-id="${insumo.id}">
                        <td>${insumo.nombre}</td>
                        <td>${insumo.cantidad_usada}</td>
                        <td style="text-align: center;">
                            <button onclick="editarInsumo(event, ${insumo.id})" class="btn btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></button>
                            <button onclick="borrarInsumo(${insumo.id})" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></button>
                        </td>
                    </tr>`;
            });

            insumosList += `</tbody></table>`;
            modificarDiv.innerHTML = insumosList;
        }

        // Agregar nuevo insumo
        modificarDiv.innerHTML += 
            `<div class="mt-3">
                <h5>Agregar Insumo</h5>
                <label for="agregar-input" class="mt-3">Selecciona un insumo o agrega uno nuevo:</label>
                <select id="insumo-select" class="form-select">
                    <option value="">Selecciona el insumo</option>
                    ${insumosData.map(ins => `<option value="${ins.id}">${ins.nombre}</option>`).join('')}
                </select>
                <input type="number" id="nuevo-insumo-cantidad" class="form-control mt-2" placeholder="Cantidad del nuevo insumo" min="1" />
                <button class="btn btn-primary mt-3" onclick="agregarNuevoInsumo()">Agregar Insumo</button>
            </div>`;
    }

    function actualizarProductoSeleccionado(productoId) {
        const selectedProducto = productosData.find(producto => producto.id == productoId);
        if (selectedProducto) {
            imagenProducto.src = selectedProducto.foto || 'ruta/default.jpg';
            descripcionProducto.innerHTML = 
                `<h5>${selectedProducto.nombre}</h5>
                <p>${selectedProducto.descripcion || 'Descripción no disponible'}</p>`;
            precioProducto.innerHTML = `<p><strong>Precio:</strong> $${parseFloat(selectedProducto.precio).toFixed(2)}</p>`;
        } else {
            descripcionProducto.innerHTML = '<p>No se encontró el producto seleccionado.</p>';
            precioProducto.innerHTML = '<p><strong>Precio:</strong> $0.00</p>';
        }
    }

    window.agregarNuevoInsumo = function() {
        const insumoSeleccionadoId = document.getElementById('insumo-select').value;
        const nuevaCantidad = document.getElementById('nuevo-insumo-cantidad').value;

        if (insumoSeleccionadoId || (nuevaCantidad > 0)) {
            const nuevoInsumo = {
                id: insumosActuales.length + 1, // Asigna un nuevo ID temporal
                nombre: insumoSeleccionadoId ? insumosData.find(ins => ins.id == insumoSeleccionadoId).nombre : 'Nuevo Insumo',
                cantidad_usada: insumoSeleccionadoId ? 1 : nuevaCantidad
            };

            insumosActuales.push(nuevoInsumo);
            mostrarInsumos(insumosActuales); // Actualiza la lista de insumos

            // Limpiar los campos del formulario
            document.getElementById('insumo-select').value = '';
            document.getElementById('nuevo-insumo-cantidad').value = '';
        } else {
            Swal.fire('Error', 'Por favor, ingresa todos los campos correctamente.', 'error');
        }
    };

    window.editarInsumo = function(event, insumoId) {
        event.preventDefault();
        const insumo = insumosActuales.find(i => i.id === insumoId);
        
        if (insumo) {
            // Crear un SweetAlert para editar insumo y cantidad
            Swal.fire({
                title: 'Editar Insumo',
                html: `
                    <div>
                        <label for="label-insumo-select-edit">Selecciona un nuevo insumo:</label>
                        <select id="edit-insumo-select" class="form-select">
                            <option value="">Selecciona el insumo</option>
                            ${insumosData.map(ins => `<option value="${ins.id}" ${ins.id == insumo.id ? 'selected' : ''}>${ins.nombre}</option>`).join('')}
                        </select>
                        <label for="cantidad-input-edit" class="mt-3">Cantidad:</label>
                        <input type="number" id="cantidad-input-edit" class="form-control" value="${insumo.cantidad_usada}" min="1">
                    </div>`,
                focusConfirm: false,
                preConfirm: () => {
                    const nuevoInsumoId = document.getElementById('edit-insumo-select').value;
                    const nuevaCantidad = document.getElementById('cantidad-input-edit').value;
                
                    // Verifica que ambos campos sean válidos antes de proceder
                    if (nuevoInsumoId && nuevaCantidad > 0) {
                        // Obtener el insumo seleccionado por ID
                        const nuevoInsumo = insumosData.find(ins => ins.id == nuevoInsumoId);
                        
                        if (nuevoInsumo) {
                            // Actualizar el insumo con los nuevos valores (nombre y cantidad)
                            const insumoIndex = insumosActuales.findIndex(i => i.id === insumoId);
                            if (insumoIndex !== -1) {
                                // Reemplazar el insumo con los nuevos valores
                                insumosActuales[insumoIndex] = {
                                    ...insumosActuales[insumoIndex], // Mantener otros valores
                                    id: nuevoInsumoId,               // Actualizar el ID del insumo
                                    nombre: nuevoInsumo.nombre,       // Actualizar el nombre del insumo
                                    cantidad_usada: nuevaCantidad    // Actualizar la cantidad usada
                                };
                            }
                        }
                        
                        // Actualiza la vista de los insumos
                        mostrarInsumos(insumosActuales);
                    } else {
                        Swal.showValidationMessage('Por favor ingresa todos los campos correctamente.');
                        return false; // Evitar que cierre el modal si la validación falla
                    }
                }
            });
        }
    };





    window.borrarInsumo = function(insumoId) {
        insumosActuales = insumosActuales.filter(ins => ins.id !== insumoId);
        mostrarInsumos(insumosActuales); // Actualiza la lista de insumos
    };
});
</script>
