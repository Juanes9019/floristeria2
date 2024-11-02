@extends('adminlte::page')

@section('title', 'Registrar Pérdida de Insumo')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container">
    <br><center><h3>Registrar Pérdida de Insumo</h3></center><br>

    <div class="card card-body">
        <form action="{{ route('admin.insumo.storePerdida') }}" method="POST" id="formulario_registrar">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="id_categoria_insumo">Categoría Insumo</label>
                        <select id="id_categoria_insumo" name="id_categoria_insumo" class="form-control" required>
                            <option selected disabled>Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="id_insumo">Insumo</label>
                        <select id="id_insumo" name="insumo_id" class="form-control" required>
                            <option selected disabled>Seleccione un insumo</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="cantidad_perdida">Cantidad:</label><br>
                        <input type="number" name="cantidad_perdida" id="cantidad_perdida" placeholder="000" class="form-control" required>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="{{ route('Admin.insumo.historialPerdidas') }}" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
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

        // Manejo del envío del formulario con confirmación
        $('#formulario_registrar').on('submit', function(event) {
            event.preventDefault(); // Previene el envío automático del formulario

            Swal.fire({
                title: "¡Estas seguro!",
                text: "¿Deseas registrar esta pérdida?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, registrar"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Envía el formulario
                }
            });
        });
    });
</script>
@stop
