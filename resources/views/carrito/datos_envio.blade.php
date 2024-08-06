<div class="container mt-5">
    <h1 class="text-center fs-4 p-3">Detalles de envío</h1>
    <form method="get" action="{{ route('confirmarCarrito') }}" id="formularioEnvio">
        @csrf
        <div class="form-group">
            <label for="nombre_destinatario">Nombre del destinatario:</label>
            <input type="text" class="form-control" id="nombre_destinatario"
                name="nombre_destinatario" placeholder="Ingresa el nombre del destinatario">

            <br>

            <label for="nombre_destinatario">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" readonly>

            <br>

            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion">

            <br>

            <label for="instrucciones_entrega">Instrucciones para la entrega:</label>
            <textarea class="form-control" id="instrucciones_entrega" name="instrucciones_entrega"
                placeholder="Dejar en recepcion o en la puerta"></textarea>

            <br>

            <label for="telefono">Telefono:</label>
            <input type="number" class="form-control" id="telefono" name="telefono" placeholder="999-999-9999">
        </div>
        <br>

        <div class="text-center">
            <label for="telefono">Metodo de pago:</label>
            <label for="telefono">Transferencia/QR:</label>
            <img src="{{ asset('img/qr.jpg') }}" class="img-fluid mx-auto d-block" style="max-width: 200px;" alt="Código QR">
        </div>
    </form>
</div> 

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
        $(document).ready(function() {
            $("#metodo_pago").change(function() {
                // Oculta todos los campos adicionales
                $(".camposAdicionales").hide();

                // Muestra el campo adicional correspondiente al método de pago seleccionado
                var metodo_seleccionado = $(this).val();
                $("#" + metodo_seleccionado).show();
            });
        });

        function validarEnvio() {
        // Obtén los valores de los campos de envío
        var nombreDestinatario = $("#nombre_destinatario").val();
        var direccion = $("#direccion").val();
        var instruccionesEntrega = $("#instrucciones_entrega").val();
        var telefono = $("#telefono").val();
        var metodoPago = $("#metodo_pago").val();

        // Realiza la validación
        if ( nombreDestinatario.trim() === '' || direccion.trim() === '' || instruccionesEntrega.trim() === '' ||telefono.trim() === '' || metodoPago === 'Seleccione una opción') {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, completa todos los campos de envío.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return false; // Evita que se envíe el formulario
        }

        if (!nombreDestinatario.match(/^[a-zA-Z\s]+$/)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Por favor, ingresa un nombre de destinatario válido.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                return false;

        }else if (!direccion.match(/^.{10,}$/)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Ingresa direccion válida de al menos 10 caracteres.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });            
                return false;
        }else if (!instruccionesEntrega.match(/^.{10,}$/)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Ingresa instrucciones válida de al menos 10 caracteres.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });            
                return false;
        }
        // Si todos los campos están llenos, procede con la compra
        mostrarConfirmacion();
    }

    function mostrarConfirmacion() {
        // Utiliza SweetAlert2 para mostrar la ventana emergente
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success swal-btn',
                cancelButton: 'btn btn-danger swal-btn'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Estás seguro de adquirir este producto?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "¡Sí, Comprar!",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirma la compra, haz submit del formulario
                document.getElementById("formularioEnvio").submit();

                // Muestra el mensaje de éxito después de confirmar la compra
                swalWithBootstrapButtons.fire({
                    title: "¡Producto comprado con éxito!",
                    text: "Gracias por comprar en JamDay",
                    icon: "success"
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Si se cancela la compra, muestra un mensaje de cancelación
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    icon: "error"
                });
            }
        });
    }
    </script>

    <script>
        window.onload = function() {
            var fecha = new Date();
            var dia = fecha.getDate();
            var mes = fecha.getMonth() + 1; // Los meses en JavaScript comienzan desde 0
            var ano = fecha.getFullYear();

            if (dia < 10) {
                dia = '0' + dia;
            }

            if (mes < 10) {
                mes = '0' + mes;
            }

            fecha = ano + '-' + mes + '-' + dia;

            document.getElementById('fecha').value = fecha;
        }
    </script> 