@extends('layouts.app')

@section('content')

<head>
    <!-- Otros enlaces y metadatos -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}"> <!-- Asegúrate de tener este archivo -->
    <script defer src="https://app.embed.im/snow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script> <!-- Si tienes algún script JS adicional -->
</head>


<div class="fondo-imagen">
    <img src="{{ asset('img/fondo.jpg') }}">
</div>
<div class="section">
    <div class="container">
        <div class="row full-height justify-content-center">
            <div class="col-12 text-center align-self-center py-5">
                <div class="section pb-5 pt-5 pt-sm-2 text-center">
                    <h6 class="mb-0 pb-3"><span>INGRESAR </span><span>REGISTRO</span></h6>
                    <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
                    <label for="reg-log"></label>
                    <div class="card-3d-wrap mx-auto">
                        <div class="card-3d-wrapper">
                            <!-- Inicio de Sesión -->
                            <div class="card-front">
                                <div class="center-wrap">
                                    <div class="section text-center">
                                        <h4 class="mb-4 pb-3">INICIO DE SESION</h4>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input id="email" type="email" class="form-style @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electronico">
                                                <i class="input-icon uil uil-at"></i>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Correo o contraseña invalida</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="form-group mt-2">
                                                <input id="password" type="password" class="form-style @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                                                <i class="input-icon uil uil-lock-alt"></i>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Correo o contraseña invalida</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- <div class="form-check mt-2 text-left">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Recordar') }}
                                                </label>
                                            </div> -->
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
                            <!-- Registro -->
                            <div class="card-back">
                                <div class="center-wrap">
                                    <div class="section text-center">
                                        <h4 class="mb-4 pb-3">REGISTRARSE</h4>
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input id="name" type="text" class="form-style @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre">
                                                <i class="input-icon uil uil-user"></i>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>nombre invalido</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <input id="surname" type="text" class="form-style @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus placeholder="Apellido">
                                                <i class="input-icon uil uil-user"></i>
                                                @error('surname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <input id="email" type="email" class="form-style @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo">
                                                <i class="input-icon uil uil-at"></i>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <input id="celular" type="tel" class="form-style @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required autocomplete="celular" autofocus placeholder="Celular">
                                                <i class="input-icon uil uil-phone"></i>
                                                @error('celular')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <input id="direccion" type="text" class="form-style @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion') }}" required autocomplete="direccion" autofocus placeholder="Dirección">
                                                <i class="input-icon uil uil-home-alt"></i>
                                                @error('direccion')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <input id="password" type="password" class="form-style @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">
                                                <i class="input-icon uil uil-lock-alt"></i>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <input id="password-confirm" type="password" class="form-style" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Contraseña">
                                                <i class="input-icon uil uil-lock-alt"></i>
                                            </div>
                                            <button type="submit" class="btn mt-4">REGISTRARME</button>
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
@endsection