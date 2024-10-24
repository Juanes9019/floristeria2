@extends('adminlte::page')

@section('title', 'Crear Compra')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<h2 class="text-center mb-5">Crear una compra</h2>

<div class="w-75 mx-auto row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.compra.store') }}" novalidate>
            @csrf

            <div class="form-group">
                <label for="id_proveedor">Proveedor</label>
                <select id="id_proveedor_select" name="id_proveedor" class="form-control" onchange="updateHiddenFields()">
                    <option selected disabled>Seleccione un proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_categoria_insumo">Categoría Insumo</label>
                <select id="id_categoria_insumo" name="id_categoria_insumo" class="form-control">
                    <option selected disabled>Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_insumo">Insumo</label>
                <select id="id_insumo" name="id_insumo" class="form-control" onchange="updateCostoUnitario()">
                    <option selected disabled>Seleccione un insumo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="costo_unitario">Costo Unitario</label>
                <input type="text" name="costo_unitario" class="form-control" id="costo_unitario" readonly>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" id="cantidad" placeholder="Cantidad">
            </div>

            <div class="form-group">
                <a href="{{ route('Admin.compra.index') }}" class="btn btn-primary">Volver</a>
                <input type="button" class="btn btn-primary" value="Agregar" onclick="agregarCarrito()">
                <input type="button" class="btn btn-success" value="Finalizar" onclick="finalizarCompra()">
            </div>

            <!-- Campos hidden para enviar datos adicionales -->
            <input type="hidden" name="id_proveedor_hidden" id="id_proveedor_hidden">
            <input type="hidden" name="id_categoria_insumo_hidden" id="id_categoria_insumo_hidden">

        </form>

        <!-- Tabla tipo carrito -->
        <table class="table table-striped" id="tabla_carrito">
            <thead>
                <tr>
                    <th>Insumo</th>
                    <th>Cantidad</th>
                    <th>Costo Unitario</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td id="total_carrito">0.00</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
let carrito = [];

function agregarCarrito() {
    const id_categoria_insumo = $('#id_categoria_insumo').val();
    const id_insumo = $('#id_insumo').val();
    const nombre_insumo = $('#id_insumo option:selected').text();
    const cantidad = $('#cantidad').val();
    const costo_unitario = $('#costo_unitario').val();
    const subtotal = cantidad * costo_unitario;

    if (!id_categoria_insumo || !id_insumo || !cantidad || !costo_unitario) {
        Swal.fire("Error", "Por favor completa todos los campos", "error");
        return;
    }

    const item = { id_categoria_insumo, id_insumo, nombre_insumo, cantidad, costo_unitario, subtotal, total: subtotal };
    carrito.push(item);
    actualizarCarrito();

    $('#id_categoria_insumo').val('');
    $('#id_insumo').val(''); 
    $('#cantidad').val(''); 
    $('#costo_unitario').val(''); 
}

function actualizarCarrito() {
    const tabla = $('#tabla_carrito tbody');
    tabla.empty();
    let totalCarrito = 0;

    carrito.forEach((item, index) => {
        totalCarrito += item.subtotal;
        tabla.append(`
            <tr>
                <td>${item.nombre_insumo}</td>
                <td>${item.cantidad}</td>
                <td>${item.costo_unitario}</td>
                <td>${item.subtotal.toFixed(2)}</td>
                <td><button class="btn btn-danger" onclick="eliminarDelCarrito(${index})">Eliminar</button></td>
            </tr>
        `);
    });

    $('#total_carrito').text(totalCarrito.toFixed(2));
    $('#formulario_crear').append(`<input type="hidden" name="carrito" value='${JSON.stringify(carrito)}'>`);
}

function eliminarDelCarrito(index) {
    carrito.splice(index, 1);
    actualizarCarrito();
}

function finalizarCompra() {
    let totalCarrito = 0;
    carrito.forEach(item => {
        totalCarrito += item.subtotal;
    });

    if (carrito.length === 0) {
        Swal.fire("Error", "El carrito está vacío", "error");
        return;
    }

    $('#formulario_crear').append(`<input type="hidden" name="costo_total" value='${totalCarrito.toFixed(2)}'>`);
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Estás a punto de finalizar la compra.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, finalizar compra'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#formulario_crear').submit();
        }
    });
}

function updateCostoUnitario() {
    const costo = $('#id_insumo option:selected').data('costo');
    $('#costo_unitario').val(costo);
}

function updateHiddenFields() {
    $('#id_proveedor_hidden').val($('#id_proveedor_select').val());
    $('#id_categoria_insumo_hidden').val($('#id_categoria_insumo').val());
}

$(document).ready(function() {
    $('#id_proveedor_select').change(function() {
        const idProveedor = $(this).val();
        if (idProveedor) {
            $.ajax({
                url: `{{ url('/categorias') }}/${idProveedor}`,
                type: 'GET',
                success: function(data) {
                    $('#id_categoria_insumo').empty().append('<option selected disabled>Seleccione una categoría</option>');
                    data.forEach(function(categoria) {
                        $('#id_categoria_insumo').append(`<option value="${categoria.id}">${categoria.nombre}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar categorías:', error);
                }
            });
        } else {
            $('#id_categoria_insumo').empty().append('<option selected disabled>Seleccione una categoría</option>');
            $('#id_insumo').empty().append('<option selected disabled>Seleccione un insumo</option>');
        }
    });

    $('#id_categoria_insumo').change(function() {
        const idCategoria = $(this).val();
        if (idCategoria) {
            $.ajax({
                url: `{{ url('/insumos') }}/${idCategoria}`,
                type: 'GET',
                success: function(data) {
                    $('#id_insumo').empty().append('<option selected disabled>Seleccione un insumo</option>');
                    data.forEach(function(insumo) {
                        $('#id_insumo').append(`<option value="${insumo.id}" data-costo="${insumo.costo_unitario}">${insumo.nombre} ${insumo.color ? '- ' + insumo.color : ''}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar insumos:', error);
                }
            });
        } else {
            $('#id_insumo').empty().append('<option selected disabled>Seleccione un insumo</option>');
        }
    });
});
</script>
@endsection
