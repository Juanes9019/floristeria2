document.addEventListener('DOMContentLoaded', function () {
    const categoriaSelect = document.getElementById('categoria');
    const productoSelect = document.getElementById('producto');
    const imagenInsumo = document.getElementById('imagen-insumo');
    const descripcionInsumo = document.getElementById('descripcion-insumo');

    // Manejar la selección de la categoría
    categoriaSelect.addEventListener('change', function () {
        const categoriaId = this.value;

        // Limpiar y deshabilitar selects
        productoSelect.innerHTML = '<option value="">Selecciona un producto</option>';
        productoSelect.disabled = true;

        if (categoriaId) {
            fetch(`/insumos/categoria/${categoriaId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error: ${response.status}`);
                    }
                    return response.json();
                })
                .then(insumos => {
                    if (insumos.length === 0) {
                        console.log('No se encontraron insumos para esta categoría.');
                    } else {
                        insumos.forEach(insumo => {
                            const option = document.createElement('option');
                            option.value = insumo.id;

                            // Formato del texto del insumo
                            const insumoTexto = insumo.color ? `${insumo.nombre} - ${insumo.color}` : insumo.nombre;
                            option.textContent = insumoTexto;

                            option.setAttribute('data-imagen', insumo.imagen);
                            option.setAttribute('data-descripcion', insumo.descripcion);
                            productoSelect.appendChild(option);
                        });
                    }
                    productoSelect.disabled = false; // Habilitar select de productos
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // Manejar la selección del producto
    productoSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const imagenUrl = selectedOption.getAttribute('data-imagen');
        const descripcion = selectedOption.getAttribute('data-descripcion');

        // Mostrar la imagen y descripción
        if (imagenUrl) {
            imagenInsumo.src = imagenUrl;
            imagenInsumo.style.display = 'block';
        } else {
            imagenInsumo.style.display = 'none';
        }

        descripcionInsumo.innerHTML = descripcion ? `<p>${descripcion}</p>` : '<p>Selecciona un insumo para ver más detalles.</p>';
    });
});
