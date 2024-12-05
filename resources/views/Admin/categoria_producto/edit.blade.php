@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<h2 class="text-center mb-5">Editar Categoría Producto</h2>
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_editar" method="POST" action="{{ route('Admin.categoria_producto.update', ['id' => $categoria_producto->id_categoria_producto]) }}" novalidate>

            @method('PUT')
            @csrf
            <div class="card card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">

                            <label for="nombre">Nombre de la categoría</label>
                            <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Aniversario" value="{{ old('nombre', $categoria_producto->nombre) }}">
                            @error('nombre')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado</label>
                                <div class="form-check form-switch">
                                    <!-- Campo hidden para enviar 0 cuando el switch está desmarcado -->
                                    <input type="hidden" name="estado" value="0">
                                    <input id="estado" name="estado" type="checkbox" class="form-check-input" value="1"
                                        {{ $categoria_producto->estado ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                        <button class="btn btn-primary" value="Editar categoria" onclick="editar()">Editar</button>
                        <a href="{{ route('Admin.categorias_productos') }}" class="btn btn-danger ">Cancelar</a>
                    </div>
            </div>
        </form>
    </div>
</div>
<script>
    function editar() {
        event.preventDefault(); // Evitar que el formulario se envíe de inmediato

        Swal.fire({
            title: "¡Estás seguro!",
            text: "¿Deseas editar esta categoría de producto?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, Editar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviamos el formulario
                Swal.fire({
                    title: "!Categoría editada!",
                    text: "La categoría producto se editó correctamente",
                    icon: "success"
                }).then(() => {
                    document.getElementById('formulario_editar').submit(); // Enviar el formulario
                });
            }
        });
    }
</script>

@stop
