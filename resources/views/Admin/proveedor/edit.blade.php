@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h2 class="text-center  mb-5 mt-4">Editar Proveedor</h2>
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
                            <select name="tipo" id="tipo" class="form-control">
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
                        <div class="col-md-6">
                            <label for="numero">NIT de la Empresa <strong style="color: red;">*</strong></label>
                            <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror" id="numero"
                                value="{{ old('numero', $proveedor->numero_documento) }}" />
                            @error('numero')
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
                        <div class="col-md-6">
                            <label for="numero">Número de Documento <strong style="color: red;">*</strong></label>
                            <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror" id="numero"
                                value="{{ old('numero', $proveedor->numero_documento) }}" />
                            @error('numero')
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
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="1" {{ old('estado', $proveedor->estado) == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado', $proveedor->estado) == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                    </div>



                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Editar Proveedor</button>
                        <a href="{{ route('Admin.proveedores') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function editar() {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas Editar este proveedor?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Editar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Proveedor Editado!",
                    text: "El proveedor se Edito correctamente",
                    icon: "success"
                });


                event.preventDefault();


                document.getElementById('formulario_crear').submit();
            }
        });
    }
</script>

@stop