<div class="row mt-4" style="width: 100%;">
    <div class="card-header text-black rounded ml-3 mb-3" style="background-color: #FFB6C1; width: 100%;">
        Selecciona el producto que deseas:
    </div>
    <div class="col-md-6">
        <form id="formAgregarInsumo" action="{{ route('agregar_producto_nuevo') }}" method="POST">
            @csrf
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
        <div id="imagen-producto-nuevo-container" class="bg-light border rounded shadow-sm p-3 mb-3" style="max-width: 100%; height: 200px; display: flex; align-items: center; justify-content: center;">
            <img id="imagen-producto-nuevo" src="ruta/default.jpg" alt="imagen producto" class="img-fluid" style="max-height: 100%; object-fit: contain;">
        </div>
        <div id="descripcion-producto-nuevo" class="bg-light border rounded shadow-sm p-3 mb-3">
            <p>Por favor selecciona un producto para ver más detalles.</p>
        </div>
        <div id="precio-producto-nuevo" class="bg-light border rounded shadow-sm p-3 mb-3">
            <p><strong>Precio:</strong> $0</p>
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
            precioProducto.innerHTML = '<p><strong>Precio:</strong> $0</p>';
        }
    });

    function mostrarInsumos(insumos) {
        // Agregar nuevo insumo primero
        let insumosList = 
            `<div class="mt-3">
                <label for="agregar-input" class="mt-3">Si deseas puedes agregar mas insumos:</label>
                <select id="insumo-select" class="form-select">
                    <option value="">Seleccionar insumos</option>
                    ${insumosData.map(ins => `<option value="${ins.id}">${ins.nombre}${ins.color ? ' - ' + ins.color : ''}</option>`).join('')}
                </select>
                <input type="number" id="nuevo-insumo-cantidad" class="form-control mt-2" placeholder="1" min="1" />
                <button class="btn btn-primary mt-3" onclick="agregarNuevoInsumo()">Agregar a tus productos</button>
            </div>`;
        
        // Si hay insumos, mostrar la tabla después del formulario
        if (insumos.length > 0) {
            insumosList += 
                `<table class="mt-4">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Nombre</th>
                            <th style="width: 100px;">Cantidad</th>
                            <th style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>`;
        
            insumos.forEach(insumo => {
                insumosList += 
                    `<tr data-insumo-id="${insumo.id}">
                        <td>${insumo.nombre}${insumo.color ? ' - ' + insumo.color : ''}</td>
                        <td>${insumo.cantidad_usada}</td> 
                        <td style="text-align: center;">
                            <button onclick="editarInsumo(event, ${insumo.id})" class="btn btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></button>
                            <button onclick="borrarInsumo(${insumo.id})" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></button>
                        </td>
                    </tr>`;
            });
        
            insumosList += `</tbody></table>`;
        }

        // Insertar todo en el div
        modificarDiv.innerHTML = insumosList;
    };

    function actualizarProductoSeleccionado(productoId) {
        const selectedProducto = productosData.find(producto => producto.id == productoId);
        if (selectedProducto) {
            imagenProducto.src = selectedProducto.foto || 'ruta/default.jpg';
            descripcionProducto.innerHTML = 
                `<h5>${selectedProducto.nombre}</h5>
                <p>${selectedProducto.descripcion || 'Descripción no disponible'}</p>`;
                precioProducto.innerHTML = `<p><strong>Precio:</strong> $${parseFloat(selectedProducto.precio).toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 2 })}</p>`;
        } else {
            descripcionProducto.innerHTML = '<p>No se encontró el producto seleccionado.</p>';
            precioProducto.innerHTML = '<p><strong>Precio:</strong> $0</p>';
        }
    };

    window.agregarNuevoInsumo = function() {
        const insumoSeleccionadoId = document.getElementById('insumo-select').value;
        let nuevaCantidad = document.getElementById('nuevo-insumo-cantidad').value;
        
        // Si la cantidad está vacía, se asigna 1 como valor predeterminado
        if (!nuevaCantidad || nuevaCantidad <= 0) {
            nuevaCantidad = 1;
        }
    
        if (insumoSeleccionadoId || nuevaCantidad > 0) {
            const insumoSeleccionado = insumosData.find(ins => ins.id == insumoSeleccionadoId);
            
            // Buscar si el insumo ya está en la lista
            const insumoExistente = insumosActuales.find(ins => ins.nombre === insumoSeleccionado.nombre && ins.color === insumoSeleccionado.color);
        
            if (insumoExistente) {
                // Si el insumo ya existe, solo sumamos la cantidad
                insumoExistente.cantidad_usada += parseInt(nuevaCantidad);
            } else {
                // Si el insumo no existe, lo agregamos como nuevo
                const nuevoInsumo = {
                    id: insumosActuales.length + 1, // Asigna un nuevo ID temporal
                    nombre: insumoSeleccionado.nombre,
                    color: insumoSeleccionado.color,  // Agrega el color aquí
                    cantidad_usada: nuevaCantidad // Usa la cantidad ingresada por el usuario
                };
            
                insumosActuales.push(nuevoInsumo);
            }
        
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
                            ${insumosData.map(ins => `<option value="${ins.id}" ${ins.id == insumo.id ? 'selected' : ''}>${ins.nombre}${ins.color ? ' - ' + ins.color : ''}</option>`).join('')}
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
