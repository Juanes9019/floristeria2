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
                    <div class="col-md-6">
                        <label for="nombre">Descripción:</label>
                        <input type="text" name="descripcion" class="form-control  @error('descripcion') is-invalid  @enderror" id="descripcion" placeholder="Descripción...">

                        @error('descripcion')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>   
                </div>
                
            </div>
            <br>
            <input type="button" class="btn btn-primary" value="Agregar" onclick="agregar(event)">
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
    });

    function agregar(event){
        event.preventDefault();

        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas agregar esta pérdida?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, agregar"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formulario_registrar').submit();
            }
        });
    }

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            position: 'top-end',
            toast: true,
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            position: 'top-end',
            toast: true,
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>
@stop
