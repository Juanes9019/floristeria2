@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">CREAR UNA NUEVA CATEGORIA</h2>


<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.categoria_producto.store') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre de la categoria</label>
                <input type="text" id="nombre" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" placeholder="Ocasiones especiales" value="{{old('nombre', $categoria_producto->nombre)  }}">

                @error('nombre')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>



            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-success" value="agregar categoria" onclick="agregar(event)">
                    Agregar Categoría
                </button>
                <a href="{{ route('Admin.categorias_productos') }}" class="btn btn-danger ">Cancelar</a>
            </div>


        </form>
    </div>
</div>
<script>
    function agregar(event) {
        event.preventDefault();

        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas agregar esta categoría?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, agregar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Categoría agregada!",
                    text: "La categoría se agregó correctamente",
                    icon: "success"
                }).then(() => {
                    document.getElementById('formulario_crear').submit(); // Envía el formulario después de la confirmación
                });
            }
        });
    }
</script>

@stop