@extends('layouts.app')

@section('content')

<head>
    <!-- Otros enlaces y metadatos -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
                            <!-- Inicio de Sesión -->
                            <div class="card-login">
                                <div class="center-wrap">
                                    <div class="section text-center">
                                        <h4 class="mb-4 pb-3">Inicio de sesión</h4>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input id="email" type="email" class="form-style @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico" maxlength="80">
                                                <i class="input-icon uil uil-at"></i>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Correo electrónico o contraseña invalida</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="form-group mt-2">
                                                <input id="password" type="password" class="form-style @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                                                <i class="input-icon uil uil-lock-alt"></i>
                                                <span class="input-group-text">
                                                    <i class="bi bi-eye" id="togglePassword1" onclick="togglePasswordVisibility('password', 'togglePassword1')"></i>
                                                </span>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Correo electrónico o contraseña invalida</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn mt-4">
                                                {{ __('Iniciar sesion') }}
                                            </button>
                                            <br>
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}">
                                                    {{ __('¿Olvidaste tu contraseña?') }}
                                                </a>
                                            @endif
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