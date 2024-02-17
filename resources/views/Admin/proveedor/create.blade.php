@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">CREAR UNA NUEVO PROVEEDOR</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.proveedor.store') }}" novalidate >
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Floristeria" value="{{ old('nombre') }}">

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" class="form-control  @error('telefono') is-invalid  @enderror" id="telefono" placeholder="999-999-9999" value="{{ old('telefono') }}">

                    @error('telefono')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" name="correo" class="form-control  @error('correo') is-invalid  @enderror" id="correo" placeholder="floristeria@correo.com" value="{{ old('correo') }}">

                    @error('correo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicacion</label>
                    <input type="text" name="ubicacion" class="form-control  @error('ubicacion') is-invalid  @enderror" id="ubicacion" placeholder="CR10 #31-13" value="{{ old('ubicacion') }}">

                    @error('ubicacion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <br>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" value="agregar proveedor" onclick="agregar()">
                    <a href="{{ route('Admin.proveedor') }}" class="btn btn-primary ">Volver</a>
                </div>
            </form>
        </div>
    </div> 
<script>
function agregar() {
    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas agregar este proveedor?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, agregar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "!Proveedor agregado!",
                text: "El proveedor se agrego correctamente",
                icon: "success"
            });

            // Prevent the form from submitting automatically
            event.preventDefault();

            // Manually submit the form
            document.getElementById('formulario_crear').submit();
        }
    });
}
</script>

@stop
