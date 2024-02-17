@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">CREAR UNA NUEVO USUARIO</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.users.store') }}" novalidate >
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" class="form-control  @error('name') is-invalid  @enderror" id="name" placeholder="Floristeria" value="{{ old('name') }}">

                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="surname">Apellido</label>
                    <input type="text" name="surname" class="form-control  @error('surname') is-invalid  @enderror" id="surname" placeholder="la tata" value="{{ old('surname') }}">

                    @error('surname')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="text" name="email" class="form-control  @error('email') is-invalid  @enderror" id="email" placeholder="floristeria@correo.com" value="{{ old('email') }}">

                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="tel" name="celular" class="form-control  @error('celular') is-invalid  @enderror" id="celular" placeholder="999-999-9999" value="{{ old('celular') }}">

                    @error('celular')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="form-control  @error('direccion') is-invalid  @enderror" id="direccion" placeholder="CR10 #31-13" value="{{ old('direccion') }}">

                    @error('direccion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('password', __('Contraseña'), ['class' => 'col-md-4 col-form-label text-md-end']) }}

                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Contraseña" id="password" autocomplete="new-password">

                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="bi bi-eye" id="togglePassword1"></i>
                                </span>
                            </div>
                        </div>
                        {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" value="agregar usuario" onclick="agregar()">
                    <a href="{{ route('Admin.users') }}" class="btn btn-primary ">Volver</a>
                </div>
            </form>
        </div>
    </div> 
<script>
function agregar() {
    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas agregar este usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, agregar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "!Usuario agregado!",
                text: "La categoria se agrego correctamente",
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
