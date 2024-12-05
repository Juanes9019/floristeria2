@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<h2 class="text-center mb-5">Crear Proveedor</h2>
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_editar" method="POST" action="{{ route('Admin.proveedor.update', $proveedor->id) }}" novalidate>
            @method('PUT')
            @csrf
            <div class="card card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tipo">Tipo de Proveedor <strong style="color: red;">*</strong></label>
                            <select name="tipo" id="tipo" class="form-select">
                                <option value="empresa" {{ old('tipo', $proveedor->tipo_proveedor) == 'empresa' ? 'selected' : '' }}>Empresa</option>
                                <option value="persona" {{ old('tipo', $proveedor->tipo_proveedor) == 'persona' ? 'selected' : '' }}>Persona Natural</option>
                            </select>
                        </div>
                    </div>

                    @if($proveedor->tipo_proveedor == 'empresa')
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="nombre">Nombre de la Empresa <strong style="color: red;">*</strong></label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                placeholder="Floristeria" value="{{ old('nombre', $proveedor->nombre) }}" />
                            @error('nombre')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    @endif

                    @if($proveedor->tipo_proveedor == 'persona')
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="nombre">Nombre Completo <strong style="color: red;">*</strong></label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                value="{{ old('nombre', $proveedor->nombre) }}" />
                            @error('nombre')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    @endif

                    <!-- Teléfono -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="telefono">Teléfono <strong style="color: red;">*</strong></label>
                            <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                                value="{{ old('telefono', $proveedor->telefono) }}" />
                            @error('telefono')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- Correo -->
                        <div class="col-md-6">
                            <label for="correo">Correo <strong style="color: red;">*</strong></label>
                            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" id="correo"
                                value="{{ old('correo', $proveedor->correo) }}" />
                            @error('correo')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Ubicación -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="ubicacion">Ubicación <strong style="color: red;">*</strong></label>
                            <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" id="ubicacion"
                                value="{{ old('ubicacion', $proveedor->ubicacion) }}" />
                            @error('ubicacion')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- Estado -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado</label>
                                <div class="form-check form-switch">
                                    <!-- Campo hidden para enviar 0 cuando el switch está desmarcado -->
                                    <input type="hidden" name="estado" value="0">
                                    <input id="estado" name="estado" type="checkbox" class="form-check-input" value="1"
                                        {{ $proveedor->estado ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary" onclick="editar()">Editar Proveedor</button>
                        <a href="{{ route('Admin.proveedores') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Aumenta la visibilidad de los bordes de todos los inputs */
    .form-control,
    .form-select,
    .form-check-input {
        border: 2px solid #6c757d;
        /* Borde más oscuro (gris oscuro) */
        border-radius: 5px;
        /* Suaviza las esquinas */
        box-shadow: none;
        /* Elimina cualquier sombra predeterminada */
    }
</style>

<script>
    function editar() {
        event.preventDefault(); // Evitar que el formulario se envíe de inmediato

        Swal.fire({
            title: "¡Estás seguro!",
            text: "¿Deseas editar este proveedor?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, Editar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviamos el formulario
                Swal.fire({
                    title: "!Proveedor editado!",
                    text: "El proveedor  se editó correctamente",
                    icon: "success"
                }).then(() => {
                    document.getElementById('formulario_editar').submit(); // Enviar el formulario
                });
            }
        });
    }
</script>

@stop