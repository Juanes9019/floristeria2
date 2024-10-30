@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<h2 class="text-center mb-5">Crear un nuevo rol</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.roles.store') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del rol</label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Nombre del rol" value="{{ old('nombre') }}">
                @error('nombre')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <!-- Lista de permisos -->
            <div class="form-group">
                <label>Selecciona permisos para el rol:</label>
                @foreach($todos_los_permisos as $permiso)
                    <div class="form-check form-switch">
                        <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox" name="permisos[]" value="{{ $permiso->id }}" id="permiso_{{ $permiso->id }}">
                        <label class="form-check-label" for="permiso_{{ $permiso->id }}">{{ $permiso->nombre }}</label>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <input type="button" class="btn btn-primary" value="Agregar rol" onclick="agregar()">
                <a href="{{ route('Admin.permisos_rol') }}" class="btn btn-primary">Cancelar</a>
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
                text: "El rol se agregó correctamente",
                icon: "success"
            });

            event.preventDefault();
            document.getElementById('formulario_crear').submit();
        }
    });
}
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@stop