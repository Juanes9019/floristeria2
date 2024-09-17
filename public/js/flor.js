document.addEventListener('DOMContentLoaded', function () {
    const florSelect = document.getElementById('flor');
    const colorSelect = document.getElementById('color');
    const imagenFlor = document.getElementById('imagen-flor');

    // Manejar la selección de la flor
    florSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const colores = JSON.parse(selectedOption.getAttribute('data-colores'));

        // Limpiar el select de colores
        colorSelect.innerHTML = '<option value="">Selecciona un color</option>';

        // Agregar los colores disponibles al select
        colores.forEach(color => {
            const option = document.createElement('option');
            option.value = color.nombre;
            option.setAttribute('data-imagen', color.imagen);
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

        if (imagenUrl) {
            imagenFlor.src = imagenUrl;
            imagenFlor.style.display = 'block';
        } else {
            imagenFlor.style.display = 'none';
        }
    });
});

