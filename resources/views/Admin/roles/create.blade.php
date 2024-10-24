@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">Crear un nuevo rol</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.roles.store') }}" novalidate >
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre del rol</label>
                    <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Nombre del rol" value="{{ old('nombre') }}">

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" value="Agregar rol" onclick="agregar()">
                    <a href="{{ route('Admin.permisos_rol') }}" class="btn btn-primary ">Volver</a>
                </div>


            </form>
        </div>
    </div> 
<script>
function agregar() {

    var nombre = document.getElementById('nombre').value;
    var regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

    if (!nombre) {
        Swal.fire('Error', 'Ingresa un nombre para el rol', 'error');
        return false;
     
    } else if (!regex.test(nombre)) {
        Swal.fire('Error', 'Solo se aceptan letras en el nombre', 'error');
        return false;
    } else if (nombre.length > 20) {
        Swal.fire('Error', 'El nombre es demasiado largo, Máximo 20 caracteres', 'error');
        return false;
    
    }

    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas agregar este rol?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, agregar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "!Rol agregado!",
                text: "El rol se agrego correctamente",
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
