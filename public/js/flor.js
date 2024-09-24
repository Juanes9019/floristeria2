document.addEventListener('DOMContentLoaded', function () {
    const florSelect = document.getElementById('flor');
    const colorSelect = document.getElementById('color');
    const imagenFlor = document.getElementById('imagen-flor');
    const descripcionFlor = document.getElementById('descripcion-flor');

    // Manejar la selección de la flor
    florSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const colores = JSON.parse(selectedOption.getAttribute('data-colores'));

        // Limpiar el select de colores
        colorSelect.innerHTML = '<option value="">Selecciona un color</option>';
        descripcionFlor.innerHTML = '<p>Descripción por defecto de la flor seleccionada. Selecciona un color para ver la descripción.</p>'; // Restablecer la descripción

        // Agregar los colores disponibles al select
        colores.forEach(color => {
            const option = document.createElement('option');
            option.value = color.nombre;
            option.setAttribute('data-imagen', color.imagen);
            option.setAttribute('data-descripcion', color.descripcion); // Añadir descripción al dataset
            option.textContent = color.nombre;
            colorSelect.appendChild(option);
        });

        // Ocultar la imagen al cambiar la flor seleccionada
        imagenFlor.style.display = 'none';
    });

    // Manejar la selección del color
    colorSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const imagenUrl = selectedOption.getAttribute('data-imagen');
        const descripcion = selectedOption.getAttribute('data-descripcion');

        if (imagenUrl) {
            imagenFlor.src = imagenUrl;
            imagenFlor.style.display = 'block';
        } else {
            imagenFlor.style.display = 'none';
        }

        // Actualizar la descripción
        if (descripcion) {
            descripcionFlor.innerHTML = `<p>${descripcion}</p>`;
        } else {
            descripcionFlor.innerHTML = '<p>Selecciona un color para ver la descripción.</p>';
        }
    });
});
