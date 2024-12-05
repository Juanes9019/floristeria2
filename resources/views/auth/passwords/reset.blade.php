@extends('layouts.app')

@section('content')

<head>
    <!-- Otros enlaces y metadatos -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script defer src="https://app.embed.im/snow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</head>


<div class="fondo-imagen">
    <img src="{{ asset('img/fondo.jpg') }}">
</div>
<div class="section">
    <div class="container">
        <div class="row full-height justify-content-center">
            <div class="col-12 text-center align-self-center py-5">
                <div class="section pb-5 pt-5 pt-sm-2 text-center">
                    <div class="card-3d-wrap mx-auto">
                        <div class="card-3d-wrapper">
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">
                                    <div class="card-login">
                                        <div class="center-wrap">
                                            <h4 class="mb-4 pb-3">Restablecer contraseña</h4>
                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $token }}">

                                            <div class="form-group">
                                                <input id="email" type="email" class="form-style @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Correo" readonly>
                                                <i class="input-icon uil uil-at"></i>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ "El token expiró" }}</strong>
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
                                                <input id="password-confirm" type="password" class="form-style" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Contraseña">
                                                <i class="input-icon uil uil-lock-alt"></i>
                                                <span class="input-group-text">
                                                    <i class="bi bi-eye" id="togglePassword1" onclick="togglePasswordVisibility('password-confirm', 'togglePassword1')"></i>
                                                </span>
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ "las contraseñas no coinciden" }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn mt-4">Restablecer contraseña</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
@endsection
