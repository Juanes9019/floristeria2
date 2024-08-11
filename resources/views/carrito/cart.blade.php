@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('status'))
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first('status') }}
                    </div>
                @endif
            </div>

            <div class="card-body">
                @if (Cart::count())

                <form action="{{ route('confirmarCarrito') }}" method="POST">
                    @csrf
                    <!-- Contenido del carrito -->
                    <table class="table table-striped">
                        <thead>
                            <th class="text-center">FOTO</th>
                            <th class="text-center">NOMBRE</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">PRECIO</th>
                            <th class="text-center">SUBTOTAL</th>
                            <th class="text-center">ACCION</th>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                            <tr class="align-middle">
                                <td class="text-center">
                                    <img src="{{ $item->options['image'] }}" alt="imagen no disponible" width="100">
                                </td>
                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="small button group">
                                        <a href="{{ route('decrementarCantidad', ['id' => $item->rowId]) }}" class="btn btn-success efecto">-</a>
                                        <button type="button" class="btn">{{ $item->qty }}</button>
                                        <a href="{{ route('incrementarCantidad', ['id' => $item->rowId]) }}" class="btn btn-success efecto">+</a>
                                    </div>
                                </td>
                                <td class="text-center">${{ number_format($item->price,  0, ',', '.') }}</td>
                                <td class="text-center">{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('removeItem') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                                        <button type="submit" class="btn btn-sm text-danger"><i class="fa fa-trash fa-lg hover-scale"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            <tr class="fx-bolder">
                                <td colspan="4"></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr class="fx-bolder">
                                <td colspan="4"></td>
                                <td class="text-end"><strong>Total:</strong></td>
                                <td class="text-center">{{ number_format(Cart::total(), 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Detalles de envío -->
                    <div class="container mt-5">
                        <h1 class="text-center fs-4 p-3">Detalles de envío</h1>
                        <div class="form-group">
                            <label for="nombre_destinatario">Nombre del destinatario:</label>
                            <input type="text" class="form-control" id="nombre_destinatario" name="nombre_destinatario" placeholder="Ingresa el nombre del destinatario" required>

                            <br>

                            <label for="fecha">Fecha:</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" readonly>

                            <br>

                            <label for="departamento">Departamento:</label>
                            <input type="text" class="form-control" id="departamento" name="departamento" value="Antioquia" readonly>

                            <br>

                            <div class="form-group">
                                <label for="ciudad">Ciudad:</label>
                                <select class="form-control" id="ciudad" name="ciudad" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <br>

                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>

                            <br>

                            <label for="instrucciones_entrega">Instrucciones para la entrega:</label>
                            <textarea class="form-control" id="instrucciones_entrega" name="instrucciones_entrega" placeholder="Dejar en recepcion o en la puerta"></textarea>

                            <br>

                            <label for="telefono">Telefono:</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" placeholder="999-999-9999" required>
                        </div>
                        <br>

                        <div class="text-center">
                            <label for="metodo_pago">Metodo de pago:</label>
                            <label for="metodo_pago">Transferencia/QR:</label>
                            <img src="{{ asset('img/qr.jpg') }}" class="img-fluid mx-auto d-block" style="max-width: 200px;" alt="Código QR">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="row justify-content-center mt-5 mb-5 text-center">
                        <div class="col-sm-4">
                            <a href="{{ route('clear') }}" class="btn btn-danger efecto-botones">Vaciar carrito</a>
                        </div>

                        <div class="col-sm-4">
                            <a href="{{ route('home') }}" class="btn btn-primary efecto-botones">Seguir Comprando</a>
                        </div>

                        <div class="col-sm-4">
                            @auth
                            <button type="submit" class="btn btn-success efecto-botones">Comprar</button>
                            @else
                                <a href="/login" class="btn btn-danger efecto-botones">Regístrate primero</a>
                            @endauth
                        </div>
                    </div>
                </form>

                @else
                    <p class="text-center">Carrito vacío</p>
                    <div class="action-buttons1">
                        <a href="/home">
                            <i class="fas fa-shopping-bag" style="margin-right: 5px;"></i> Seguir comprando
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
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
@endsection