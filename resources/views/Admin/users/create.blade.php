@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h2 class="text-center mb-5">Crear nuevo usuario</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.users.store') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nombre" value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="surname">Apellido</label>
                <input type="text" name="surname" class="form-control @error('surname') is-invalid @enderror" id="surname" placeholder="Apellido" value="{{ old('surname') }}">
                @error('surname')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Correo electrónico" value="{{ old('email') }}">
                @error('email')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="celular">Celular</label>
                <input type="tel" name="celular" class="form-control @error('celular') is-invalid @enderror" id="celular" placeholder="Celular" value="{{ old('celular') }}">
                @error('celular')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" id="direccion" placeholder="Dirección" value="{{ old('direccion') }}">
                @error('direccion')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="id_rol">Tipo de cuenta</label>
                <select id="id_rol" name="id_rol" class="form-control @error('id_rol') is-invalid @enderror">
                    <option selected disabled>Seleccione un Rol</option>
                    @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                    @endforeach
                </select>
                @error('id_rol')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{"El campo de rol es necesario"}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password">Contraseña</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" id="password">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bi bi-eye" id="togglePassword1"></i></span>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="cpassword">Confirmar contraseña</label>
                <div class="input-group">
                    <input type="password" name="cpassword" class="form-control @error('cpassword') is-invalid @enderror" placeholder="Confirmar contraseña" id="cpassword">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bi bi-eye" id="togglePassword2"></i></span>
                    </div>
                </div>
                @error('cpassword')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{"El campo de confirmación de contraseña es necesario"}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="button" class="btn btn-primary" value="Agregar usuario" onclick="agregar()">
                <a href="{{ route('Admin.users') }}" class="btn btn-danger ">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
function agregar() {
    var name = document.getElementById('name').value;
    var surname = document.getElementById('surname').value;
    var email = document.getElementById('email').value;
    var celular = document.getElementById('celular').value;
    var direccion = document.getElementById('direccion').value;
    var password = document.getElementById('password').value;
    var cpassword = document.getElementById('cpassword').value;
    var id_rol = document.getElementById('id_rol').value;
    var regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    var regex_password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_])([A-Za-z\d$@$!%*?&_]|[^ ]){8,15}$/;

    if (!name || !surname || !email || !celular || !direccion || !password) {
        Swal.fire('Error', 'No se pueden ingresar campos vacíos', 'error');
        return false;
    } else if (id_rol == 'Seleccione un Rol') {
        Swal.fire('Error', 'Seleccione un rol para este usuario', 'error');
        return false;
    } else if (!regex.test(name)) {
        Swal.fire('Error', 'Solo se aceptan letras en el nombre', 'error');
        return false;
    } else if (name.length > 20) {
        Swal.fire('Error', 'El nombre es demasiado largo, Máximo 20 caracteres', 'error');
        return false;
    
    } else if (surname.length > 20) {
        Swal.fire('Error', 'El apellido es demasiado largo, Máximo 20 caracteres', 'error');
        return false;
    
    } else if (!regex.test(surname)) {
        Swal.fire('Error', 'Solo se aceptan letras en el apellido', 'error');
        return false;
    } else if (celular.length != 10 || isNaN(celular)) {
        Swal.fire('Error', 'El celular debe tener 10 caracteres y ser numérico', 'error');
        return false;
    } else if (!regex_password.test(password)) {
        Swal.fire('Error', 'La contraseña no es válida. Debe contener: \n Min. 8 caracteres \n Máx. 15 \n Al menos una letra mayúscula y minúscula \n Un dígito \n Un caracter especial', 'error');
        return false;
    } else if (password !== cpassword) {
        Swal.fire('Error', 'Las contraseñas no coinciden', 'error');
        return false;
    }

    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas agregar este usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, agregar"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formulario_crear').submit();
        }
    });
}
</script>

@stop
