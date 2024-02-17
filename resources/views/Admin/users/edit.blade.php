@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">EDITAR CATEGORIA</h2>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
            <form id="formulario_editar" method="POST" action="{{ route('Admin.users.update', $usuarios->id) }}" novalidate>
                @method('PUT')
                @csrf        

                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" class="form-control  @error('name') is-invalid  @enderror" id="name" placeholder="Hombre..." value="{{ old('name', $usuarios->name) }}">
                    @error('nombre')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="surname">Apellido</label>
                    <input type="text" name="surname" class="form-control  @error('surname') is-invalid  @enderror" id="surname" placeholder="la tata" value="{{ old('surname', $usuarios->surname) }}">

                    @error('surname')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="text" name="email" class="form-control  @error('email') is-invalid  @enderror" id="email" placeholder="floristeria@correo.com" value="{{ old('email', $usuarios->email) }}">

                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="tel" name="celular" class="form-control  @error('celular') is-invalid  @enderror" id="celular" placeholder="999-999-9999" value="{{ old('celular', $usuarios->celular) }}">

                    @error('celular')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="form-control  @error('direccion') is-invalid  @enderror" id="direccion" placeholder="CR10 #31-13" value="{{ old('direccion', $usuarios->direccion) }}">

                    @error('direccion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Tipo de cuenta</label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                        <option selected disabled>Seleccionar una opción</option>
                        <option value="user" {{ old('type', $usuarios->type) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('type', $usuarios->type) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>
                
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Contraseña" id="password" autocomplete="new-password" value="{{ isset($usuarios) ? old('password', $usuarios->password) : old('password') }}">
                
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
                    <input type="submit" class="btn btn-primary" value="Editar usuario">
                    <a href="{{ route('Admin.users') }}" class="btn btn-primary">Volver</a>
                </div>
            </form>
        </div>
    </div>
@stop
