@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">EDITAR CATEGORIA</h2>
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_editar" method="POST" action="{{ route('Admin.categoria_producto.update', ['id' => $categoria_producto->id_categoria_producto]) }}" novalidate>
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre de la categoria</label>
                <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Aniversario" value="{{ old('nombre', $categoria_producto->nombre) }}">
                @error('nombre')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="1" {{ $categoria_producto->estado == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $categoria_producto->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-warning" value="Editar categoria" onclick="editar()">Editar Categoría</button>
                <a href="{{ route('Admin.categorias_productos') }}" class="btn btn-danger ">Volver</a>
            </div>
        </form>
    </div>
</div>
<script>
    function editar() {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas editar esta categoria?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Editar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!categoria Editada!",
                    text: "La categoria se edito correctamente",
                    icon: "success"
                });


                event.preventDefault();


                document.getElementById('formulario_editar').submit();
            }
        });
    }
</script>

@stop