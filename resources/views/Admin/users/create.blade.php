@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="row justify-content-center">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.users.store') }}" novalidate>
            @csrf
            
            <div class="border p-4 rounded">
                <h2 class="text-center mb-5">Crear nuevo usuario</h2>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre <strong style="color: red;">*</strong></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nombre" value="{{ old('name') }}" maxlength="30">
                            @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="surname">Apellido <strong style="color: red;">*</strong></label>
                            <input type="text" name="surname" class="form-control @error('surname') is-invalid @enderror" id="surname" placeholder="Apellido" value="{{ old('surname') }}" maxlength="30">
                            @error('surname')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipo_documento">Tipo de Documento <strong style="color: red;">*</strong></label>
                            <select 
                                name="tipo_documento" 
                                class="form-control @error('tipo_documento') is-invalid @enderror" 
                                id="tipo_documento" 
                                onchange="toggleDocumentoField()"
                            >
                                <option disabled {{ old('tipo_documento') ? '' : 'selected' }}>Seleccione el tipo de documento</option>
                                <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                <option value="Pasaporte" {{ old('tipo_documento') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                            </select>
                            @error('tipo_documento')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="documento">Documento <strong style="color: red;">*</strong></label>
                            <input 
                                type="tel" 
                                name="documento"
                                class="form-control @error('documento') is-invalid @enderror" 
                                id="documento" 
                                placeholder="Documento" 
                                value="{{ old('documento') }}" 
                                maxlength="10"
                            >
                            @error('documento')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Correo electrónico <strong style="color: red;">*</strong></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Correo electrónico" value="{{ old('email') }}" maxlength="80">
                            @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>                        
                        
                    </div>

                    <div class="col-md-6">
                        
                        <div class="form-group">
                            <label for="celular">Celular <strong style="color: red;">*</strong></label>
                            <input 
                                type="tel" 
                                name="celular" 
                                class="form-control @error('celular') is-invalid @enderror" 
                                id="celular" 
                                placeholder="Celular" 
                                value="{{ old('celular') }}" 
                                pattern="\d*" 
                                maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            >
                            @error('celular')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_rol">Rol <strong style="color: red;">*</strong></label>
                            <select id="id_rol" name="id_rol" class="form-control @error('id_rol') is-invalid @enderror">
                                <option disabled {{ old('id_rol') ? '' : 'selected' }}>Seleccione un Rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('id_rol') == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                            @error('id_rol')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Contraseña <strong style="color: red;">*</strong></label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Contraseña" id="password" oninput="validatePassword()" 
                                       onfocus="toggleTooltip(true)" onblur="toggleTooltip(false)">
                                
                                <div class="input-group-append">
                                    <span class="input-group-text info-icon">
                                        <i class="bi bi-info-circle" id="infoPasswordIcon"></i>
                                        <div class="tooltip-validation" id="passwordTooltip" style="display: none;">
                                            <ul>
                                                <li id="length" class="invalid">Entre 8 y 15 caracteres</li>
                                                <li id="uppercase" class="invalid">Al menos una letra mayúscula</li>
                                                <li id="lowercase" class="invalid">Al menos una letra minúscula</li>
                                                <li id="digit" class="invalid">Al menos un dígito</li>
                                                <li id="special" class="invalid">Un carácter especial</li>
                                                <li id="esp" class="valid">Sin espacios</li>
                                            </ul>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-eye" id="togglePassword1" onclick="togglePasswordVisibility('password', 'togglePassword1')"></i>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="cpassword">Confirmar contraseña <strong style="color: red;">*</strong></label>
                            <div class="input-group">
                                <input type="password" name="cpassword" class="form-control @error('cpassword') is-invalid @enderror" placeholder="Confirmar contraseña" id="cpassword">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-eye" id="togglePassword2" onclick="togglePasswordVisibility('cpassword', 'togglePassword2')"></i>
                                    </span>
                                </div>
                            </div>
                            @error('cpassword')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <input type="button" class="btn btn-primary" value="Agregar" onclick="agregar()">
                <a href="{{ route('Admin.users') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDocumentoField() {
    var tipoDocumento = document.getElementById('tipo_documento').value;
    var documentoField = document.getElementById('documento');

    documentoField.value = '';

    if (tipoDocumento === 'Pasaporte') {
        documentoField.removeAttribute('pattern');
        documentoField.oninput = function() {
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        };
    } else {
        documentoField.setAttribute('pattern', '\\d*');
        documentoField.oninput = function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        };
    }
}

</script>

<script>
    function toggleTooltip(show) {
        const tooltip = document.getElementById('passwordTooltip');
        tooltip.style.display = show ? 'block' : 'none';
    }
</script>

<script>
    function validatePassword() {
    const password = document.getElementById('password').value;

    const lengthRequirement = document.getElementById('length');
    const uppercaseRequirement = document.getElementById('uppercase');
    const lowercaseRequirement = document.getElementById('lowercase');
    const digitRequirement = document.getElementById('digit');
    const specialRequirement = document.getElementById('special');
    const espRequirement = document.getElementById('esp');

    const infoIcon = document.getElementById('infoPasswordIcon');
    
    let metConditions = 0;

    if (password.length >= 8 && password.length <= 15) {
        lengthRequirement.classList.add('valid');
        lengthRequirement.classList.remove('invalid');
        metConditions++;
    } else {
        lengthRequirement.classList.add('invalid');
        lengthRequirement.classList.remove('valid');
    }

    if (/[A-Z]/.test(password)) {
        uppercaseRequirement.classList.add('valid');
        uppercaseRequirement.classList.remove('invalid');
        metConditions++;
    } else {
        uppercaseRequirement.classList.add('invalid');
        uppercaseRequirement.classList.remove('valid');
    }

    if (/[a-z]/.test(password)) {
        lowercaseRequirement.classList.add('valid');
        lowercaseRequirement.classList.remove('invalid');
        metConditions++;
    } else {
        lowercaseRequirement.classList.add('invalid');
        lowercaseRequirement.classList.remove('valid');
    }

    if (/\d/.test(password)) {
        digitRequirement.classList.add('valid');
        digitRequirement.classList.remove('invalid');
        metConditions++;
    } else {
        digitRequirement.classList.add('invalid');
        digitRequirement.classList.remove('valid');
    }

    if (/[$@!%*?&#_\-]/.test(password)) {
        specialRequirement.classList.add('valid');
        specialRequirement.classList.remove('invalid');
        metConditions++;
    } else {
        specialRequirement.classList.add('invalid');
        specialRequirement.classList.remove('valid');
    }

    // No debe tener espacios
    if (!/\s/.test(password)) {
            espRequirement.classList.add('valid');
            espRequirement.classList.remove('invalid');
            metConditions++;
        } else {
            espRequirement.classList.add('invalid');
            espRequirement.classList.remove('valid');
        }

        // Resaltar el icono si todas las condiciones se cumplen
        if (metConditions === 6) { // Ajustado a 6 condiciones
            infoIcon.classList.add('highlighted');
        } else {
            infoIcon.classList.remove('highlighted');
        }

}
</script>
    

<script>
    function togglePasswordVisibility(inputId, toggleIconId) {
        const passwordField = document.getElementById(inputId);
        const toggleIcon = document.getElementById(toggleIconId);
    
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("bi-eye");
            toggleIcon.classList.add("bi-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("bi-eye-slash");
            toggleIcon.classList.add("bi-eye");
        }
    }
</script>    

<script>
function agregar() {
    var name = document.getElementById('name').value;
    var surname = document.getElementById('surname').value;
    var email = document.getElementById('email').value;
    var celular = document.getElementById('celular').value;
    var password = document.getElementById('password').value;
    var cpassword = document.getElementById('cpassword').value;
    var id_rol = document.getElementById('id_rol').value;
    var regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    var regex_password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_])([A-Za-z\d$@$!%*?&_]|[^ ]){8,15}$/;

    if (!name || !surname || !email || !celular || !password) {
        Swal.fire('Error', 'No se pueden ingresar campos vacíos', 'error');
        document.getElementById('formulario_crear').submit();
        return false;
    } else if (id_rol == 'Seleccione un Rol') {
        Swal.fire('Error', 'Seleccione un rol para este usuario', 'error');
        document.getElementById('formulario_crear').submit();
        return false;
    } else if (!regex.test(name)) {
        Swal.fire('Error', 'Solo se aceptan letras en el nombre', 'error');
        document.getElementById('formulario_crear').submit();
        return false;
    } else if (name.length > 30) {
        Swal.fire('Error', 'El nombre es demasiado largo, Máximo 30 caracteres', 'error');
        document.getElementById('formulario_crear').submit();
        return false;
    
    } else if (surname.length > 30) {
        Swal.fire('Error', 'El apellido es demasiado largo, Máximo 30 caracteres', 'error');
        document.getElementById('formulario_crear').submit();
        return false;
    
    } else if (!regex.test(surname)) {
        Swal.fire('Error', 'Solo se aceptan letras en el apellido', 'error');
        document.getElementById('formulario_crear').submit();
        return false;
    } else if (celular.length != 10 || isNaN(celular)) {
        Swal.fire('Error', 'El celular debe tener 10 caracteres y ser numérico', 'error');
        document.getElementById('formulario_crear').submit();
        return false;
    } else if (!regex_password.test(password)) {
        Swal.fire('Error', 'La contraseña no es válida. Debe contener: \n Min. 8 caracteres \n Máx. 15 \n Al menos una letra mayúscula y minúscula \n Un dígito \n Un caracter especial', 'error');
        document.getElementById('formulario_crear').submit();
        return false;
    } else if (password !== cpassword) {
        Swal.fire('Error', 'Las contraseñas no coinciden', 'error');
        document.getElementById('formulario_crear').submit();
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