@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">CREAR UN NUEVO PROVEEDOR</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            
        <form id="formulario_crear" method="POST" action="{{ route('Admin.proveedor.store') }}" novalidate >
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control  id="nombre" placeholder="Floristeria" value="{{ old('nombre') }}">

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="tel" name="telefono" class="form-control  id="telefono" placeholder="999-999-9999" value="{{ old('telefono') }}">

                    @error('telefono')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" name="correo" class="form-control  id="correo" placeholder="floristeria@correo.com" value="{{ old('correo') }}">

                    @error('correo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicacion</label>
                    <input type="text" name="ubicacion" class="form-control   id="ubicacion" placeholder="CR10 #31-13" value="{{ old('ubicacion') }}">

                    @error('ubicacion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                </select>
            </div>

                <br>

                <div class="form-group">
                    <button type="button" class="btn btn-primary" value="Agregar proveedor" onclick="agregar()">Agregar proveedor</button>
                    <a href="{{ route('Admin.proveedores') }}" class="btn btn-danger ">Cancelar</a>
                </div>
            </form>
        </div>
    </div> 

<script>
function agregar() {
    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas agregar este proveedor?",
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

            
            event.preventDefault();

            
            document.getElementById('formulario_crear').submit();
        }
    });
}
</script>

@stop
