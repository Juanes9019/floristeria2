@extends('layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="fondo-imagen">
    <img src="{{ asset('img/fondo.jpg') }}">
</div>

<div class="section">
    <div class="container">
        <div class="row full-height justify-content-center">
            <div class="col-12 text-center align-self-center py-5">
                <div class="section pb-5 pt-5 pt-sm-2 text-center">
                    <label for="reg-log"></label>
                    <div class="card-3d-wrap mx-auto">
                        <div class="card-3d-wrapper">
                            

                            <div class="card-login">
                                <div class="center-wrap">
                                    <div class="section text-center">
                                        
                                        <form id="formulario_crear" method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <h4 class="mb-4 pb-3">Registrarse</h4>
                                            
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group mt-2">
                                                        <input type="text" name="name" class="form-style @error('name') is-invalid @enderror" id="name" placeholder="Nombre" value="{{ old('name') }}" autocomplete="name" autofocus maxlength="30">
                                                        <i class="input-icon uil uil-user"></i>

                                                        @error('name')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{$message}}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="form-group mt-2">
                                                        <input type="text" name="surname" class="form-style @error('surname') is-invalid @enderror" id="surname" placeholder="Apellido" value="{{ old('surname') }}" autocomplete="surname" autofocus maxlength="30">
                                                        <i class="input-icon uil uil-user"></i>
                                                        @error('surname')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{$message}}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="form-group mt-2">
                                                        <select 
                                                            name="tipo_documento" 
                                                            class="form-style @error('tipo_documento') is-invalid @enderror" 
                                                            id="tipo_documento" 
                                                            onchange="toggleDocumentoField()"
                                                        >
                                                            <option disabled {{ old('tipo_documento') ? '' : 'selected' }}>Seleccione el tipo de documento</option>
                                                            <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                                            <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                                            <option value="Pasaporte" {{ old('tipo_documento') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                                        </select>
                                                        <i class="input-icon uil uil-postcard"></i>
                                                        @error('tipo_documento')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="form-group mt-2">
                                                        <input 
                                                            type="tel" 
                                                            name="documento"
                                                            class="form-style @error('documento') is-invalid @enderror" 
                                                            id="documento" 
                                                            placeholder="Documento" 
                                                            value="{{ old('documento') }}" 
                                                            maxlength="10"
                                                            autocomplete="documento" 
                                                            autofocus
                                                        >
                                                        <i class="input-icon uil uil-postcard"></i>
                                                        @error('documento')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{$message}}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                            
                                                    
                                                </div>
                            
                                                <div class="col-md-6">

                                                    <div class="form-group mt-2">
                                                        <input type="email" name="email" class="form-style @error('email') is-invalid @enderror" id="email" placeholder="Correo electrónico" value="{{ old('email') }}" autocomplete="email" maxlength="80" autofocus>
                                                        <i class="input-icon uil uil-at"></i>
                                                        @error('email')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{$message}}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>


                                                    <div class="form-group mt-2">
                                                        <input 
                                                            type="tel" 
                                                            name="celular" 
                                                            class="form-style @error('celular') is-invalid @enderror" 
                                                            id="celular" 
                                                            placeholder="Celular" 
                                                            value="{{ old('celular') }}" 
                                                            pattern="\d*" 
                                                            maxlength="10"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                             
                                                            autocomplete="celular" 
                                                            autofocus
                                                        >
                                                        <i class="input-icon uil uil-phone"></i>
                                                        @error('celular')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{$message}}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                            


                                                    <div class="form-group mt-2">
                                                        <div class="input-group">                                                            
                                                            <input type="password" name="password" class="form-style @error('password') is-invalid @enderror" 
                                                                   placeholder="Contraseña" id="password" oninput="validatePassword()" 
                                                                   onfocus="toggleTooltip(true)" onblur="toggleTooltip(false)">
                                                                   <i class="input-icon uil uil-lock-alt"></i>
                                                            
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">

                                                                    <div class="tooltip-validation" id="passwordTooltip">
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
                                                    



                            
                                                    <div class="form-group mt-2">
                                                        <div class="input-group">
                                                            <input type="password" name="cpassword" class="form-style @error('cpassword') is-invalid @enderror" placeholder="Confirmar contraseña" id="cpassword">
                                                            <i class="input-icon uil uil-lock-alt"></i>
                                                            
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
                                            <button type="submit" class="btn mt-4">Registrarme</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Registro -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    if (!/\s/.test(password)) {
            espRequirement.classList.add('valid');
            espRequirement.classList.remove('invalid');
            metConditions++;
        } else {
            espRequirement.classList.add('invalid');
            espRequirement.classList.remove('valid');
        }

    if (metConditions === 6) { 
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
    var regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    var regex_password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_])([A-Za-z\d$@$!%*?&_]|[^ ]){8,15}$/;

    if (!name || !surname || !email || !celular || !password) {
        Swal.fire('Error', 'No se pueden ingresar campos vacíos', 'error');
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
@endsection