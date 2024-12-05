@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


<h2 class="text-center mb-5">Crear Categoría Producto</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.categoria_producto.store') }}" novalidate>
            @csrf

            <div class="card card-body">
                <div class="row">
                    <!-- Columna 1: Nombre -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Ocasiones especiales" value="{{ old('nombre') }}">

                            @error('nombre')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Columna 2: Estado -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="form-check form-switch">
                                <input
                                    id="estado"
                                    name="estado"
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    value="1"
                                    {{ old('estado', 0) == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" value="agregar categoria" onclick="agregar()">
                    Agregar
                </button>
                <a href="{{ route('Admin.categorias_productos') }}" class="btn btn-danger">Cancelar</a>
            </div>

        </form>

    </div>
</div>
<script>
    function agregar() {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas agregar esta categoría de producto?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, agregar"
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();

                document.getElementById('formulario_crear').submit();
            }
        });
    }
</script>

@stop