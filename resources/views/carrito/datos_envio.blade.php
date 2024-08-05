<div class="container mt-5">
    <h1 class="text-center fs-4 p-3">Detalles de envío</h1>
    <form method="get" action="{{ route('confirmarCarrito') }}" id="formularioEnvio">
        @csrf
        <div class="form-group">
            <label for="nombre_destinatario">Nombre del destinatario:</label>
            <input type="text" class="form-control" id="nombre_destinatario"
                name="nombre_destinatario" placeholder="Ingresa el nombre del destinatario">

            <br>
            @error('nombre_destinatario')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label for="nombre_destinatario">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" readonly>

            <br>

            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion">

            <br>
            @error('direccion')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label for="instrucciones_entrega">Instrucciones para la entrega:</label>
            <textarea class="form-control" id="instrucciones_entrega" name="instrucciones_entrega"
                placeholder="Dejar en recepcion o en la puerta"></textarea>

            <br>
            @error('instrucciones_entrega')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror   

            <label for="telefono">Telefono:</label>
            <input type="number" class="form-control" id="telefono" name="telefono" placeholder="999-999-9999">
            @error('telefono')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror   
        </div>
        <br>
        <!-- <div class="form-group">
            <label for="metodo_pago">Método de Pago:</label>
            <select class="form-control" id="metodo_pago" name="metodo_pago">
                <option>Seleccione una opción</option>
                <option value="contraentrega">Contra Entrega</option>
                <option value="debito">Débito</option>
                <option value="credito">Crédito</option>
                <option value="paypal">PayPal</option>
            </select>
        </div> -->
    </form>
</div> 

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
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