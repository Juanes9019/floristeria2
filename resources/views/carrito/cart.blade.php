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
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: '{{ session('success') }}',
                        position: 'top-end',
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000
                    });
                </script>
            @endif


            <div class="card-body">
                @if (Cart::count())
                <h1 class="text-center fs-4 p-3">Datos de Compra</h1>

                <form action="{{ route('confirmarCarrito') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-striped">
                        <thead>
                            <th class="text-center">Foto</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Acción</th>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                            <tr class="align-middle">
                                <td class="text-center">
                                    <img src="{{ $item->options['image'] ?? 'https://i.imgur.com/ia1BeKH.png' }}" alt="imagen no disponible" width="100">
                                </td>
                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="small button group">
                                        <a href="{{ route('decrementarCantidad', ['id' => $item->rowId]) }}" class="btn btn-success efecto">-</a>
                                        <button type="button" class="btn">{{ $item->qty }}</button>
                                        <a href="{{ route('incrementarCantidad', ['id' => $item->rowId]) }}" class="btn btn-success efecto">+</a>
                                    </div>
                                </td>
                                <td class="text-center">${{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('removeItem') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                                        <button type="submit" class="btn btn-sm text-danger">
                                            <i class="fa fa-trash fa-lg hover-scale"></i>
                                        </button>
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

                    <div class="container mt-5">
                        <div class="card mb-3" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#detallesEnvio" aria-expanded="false" aria-controls="detallesEnvio">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Detalle de Envío</h5>
                                <i class="fas fa-chevron-down"></i> 
                            </div>
                        </div>

                        <div class="collapse show mt-3" id="detallesEnvio">
                            <div class="card card-body">
                                <div class="form-group">
                                    <label for="nombre_destinatario">Nombre del destinatario:</label>
                                    <input type="text" class="form-control" id="nombre_destinatario" name="nombre_destinatario" placeholder="Ingresa el nombre del destinatario" required>
                                    @error('nombre_destinatario')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    
                                    <br>

                                    <label for="fecha">Fecha:</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" readonly>
                                    @error('fecha')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <br>

                                    <label for="departamento">Departamento:</label>
                                    <input type="text" class="form-control" id="departamento" name="departamento" value="Antioquia" readonly>
                                    @error('departamento')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <br>

                                    <div class="form-group">
                                        <label for="ciudad">Ciudad:</label>
                                        <select class="form-control" id="ciudad" name="ciudad" required>
                                            <option value="" disabled selected>Seleccione una ciudad</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                            @endforeach
                                        </select>
                                        @error('ciudad')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <br>

                                    <label for="direccion">Dirección:</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                    @error('direccion')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <br>

                                    <label for="instrucciones_entrega">Instrucciones para la entrega:</label>
                                    <textarea class="form-control" id="instrucciones_entrega" name="instrucciones_entrega" placeholder="Dejar en recepción o en la puerta"></textarea>
                                    @error('instrucciones_entrega')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <br>

                                    <label for="telefono">Teléfono:</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono" placeholder="999-999-9999" required>
                                    @error('telefono')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3 mb-3" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#metodosPago" aria-expanded="false" aria-controls="metodosPago">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Métodos de Pago</h5>
                                <i class="fas fa-chevron-down"></i> 
                            </div>
                        </div>

                        <div class="collapse show mt-3" id="metodosPago">
                            <div class="card card-body text-center">
                                <p class="alert alert-primary text-dark">
                                    Por favor, asegúrese de rellenar todos los campos del detalle de envío y subir el comprobante de pago de los productos que desea adquirir. Espere que el estado de su pedido esté en Aprobado antes de realizar cualquier acción adicional.
                                </p>

                                <p class="alert alert-primary text-dark">
                                    Cómo hacerlo: Por favor, escanee el código QR utilizando su aplicación bancaria y realice la transferencia con el valor total indicado en su carrito. Una vez que haya finalizado la transferencia, tome una captura de pantalla del comprobante de pago y súbalo en el campo a continuación.
                                </p>

                                <label for="comprobante_pago">Comprobante de Pago:</label>
                                <input type="file" class="form-control" id="comprobante_pago" name="comprobante_pago" required>
                                @error('comprobante_pago')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <br>

                                <img src="{{ asset('img/qr.jpg') }}" class="img-fluid mx-auto d-block" style="max-width: 200px;" alt="Código QR">
                                <label for="metodo_pago">Transferencia/QR:</label>
                            </div>
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
                    <p class="text-center">No hay productos en el carrito.</p>

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-block efecto-botones">Ir a comprar</a>
                @endif
            </div>
        </div>
    </div>
</div>



<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        window.onload = function() {
            var fecha = new Date();
            var dia = fecha.getDate();
            var mes = fecha.getMonth() + 1; 
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

        document.querySelector('form').addEventListener('submit', function(e) {
    // Verifica si la sección de detalles de envío está colapsada
    if (!document.getElementById('detallesEnvio').classList.contains('show')) {
        document.getElementById('nombre_destinatario').removeAttribute('required');
        document.getElementById('ciudad').removeAttribute('required');
        document.getElementById('direccion').removeAttribute('required');
        document.getElementById('telefono').removeAttribute('required');
    }

    // Verifica si la sección de métodos de pago está colapsada
    if (!document.getElementById('metodosPago').classList.contains('show')) {
        document.getElementById('comprobante_pago').removeAttribute('required');
    }
});

    </script> 

@endsection