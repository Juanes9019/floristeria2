@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">EDITAR UN NUEVO PROVEEDOR</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.proveedor.update', $proveedor->id) }}" novalidate >
            @method('PUT')
                @csrf     
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre"
                     placeholder="Floristeria" value="{{ old('nombre', $proveedor->nombre) }}">

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" class="form-control  @error('telefono') is-invalid  @enderror"
                     id="telefono" placeholder="999-999-9999" value="{{ old('telefono', $proveedor->telefono) }}">

                    @error('telefono')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" name="correo" class="form-control  @error('correo') is-invalid  @enderror" 
                    id="correo" placeholder="floristeria@correo.com" value="{{ old('correo', $proveedor->correo) }}">

                    @error('correo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicacion</label>
                    <input type="text" name="ubicacion" class="form-control  @error('ubicacion') is-invalid  @enderror"
                     id="ubicacion" placeholder="CR10 #31-13" value="{{ old('ubicacion', $proveedor->ubicacion) }}">

                    @error('ubicacion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="1" {{ $proveedor->estado == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $proveedor->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

                <br>

                <div class="form-group">
                    <button type="button" class="btn btn-warning" value="Editar proveedor" onclick="editar()">Editar Proveedor</button>
                    <a href="{{ route('Admin.proveedores') }}" class="btn btn-danger ">Cancelar</a>
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
