@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<h2 class="text-center mb-5">Editar usuario</h2>
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_editar" method="POST" action="{{ route('Admin.users.update', $usuarios->id) }}" onsubmit="return editar(event);" novalidate>
            @method('PUT')
            @csrf

            <input type="hidden" name="_method" value="PUT">

            <div class="border p-4 rounded">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre <strong style="color: red;">*</strong></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nombre" value="{{ old('name', $usuarios->name) }}" maxlength="30">
                            @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="surname">Apellido <strong style="color: red;">*</strong></label>
                            <input type="text" name="surname" class="form-control @error('surname') is-invalid @enderror" id="surname" placeholder="Apellido" value="{{ old('surname', $usuarios->surname) }}" maxlength="30">
                            @error('surname')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipo_documento">Tipo de documento <strong style="color: red;">*</strong></label>
                            <input type="text" name="tipo_documento" class="form-control @error('tipo_documento') is-invalid @enderror" id="tipo_documento" placeholder="Tipo de documento" value="{{ old('tipo_documento', $usuarios->tipo_documento) }}" readonly>
                            @error('tipo_documento')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="documento">Documento <strong style="color: red;">*</strong></label>
                            <input type="text" name="documento" class="form-control @error('documento') is-invalid @enderror" id="documento" placeholder="Documento" value="{{ old('documento', $usuarios->documento) }}" readonly>
                            @error('documento')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo electrónico <strong style="color: red;">*</strong></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="correo@ejemplo.com" value="{{ old('email', $usuarios->email) }}" maxlength="80">
                            @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="celular">Celular <strong style="color: red;">*</strong></label>
                            <input type="tel" name="celular" class="form-control @error('celular') is-invalid @enderror" id="celular" placeholder="Celular" value="{{ old('celular', $usuarios->celular) }}"  pattern="\d*" 
                            maxlength="10"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                            @error('celular')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_rol">Rol <strong style="color: red;">*</strong></label>
                            <select id="id_rol" name="id_rol" class="form-control @error('id_rol') is-invalid @enderror">
                                <option disabled {{ old('id_rol') ? '' : 'selected' }}>Seleccione un Rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('id_rol', $usuarios->id_rol) == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                            @error('id_rol')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <input type="submit" class="btn btn-primary" value="Editar usuario">
                <a href="{{ route('Admin.users') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    function editar(event) {
        event.preventDefault();
        var name = document.getElementById('name').value;
        var surname = document.getElementById('surname').value;
        var email = document.getElementById('email').value;
        var celular = document.getElementById('celular').value;
        var id_rol = document.getElementById('id_rol').value;
        var regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

        if (!name || !surname || !email || !celular || !id_rol) {
            Swal.fire('¡Error!', 'Todos los campos son obligatorios.', 'error');
            document.getElementById('formulario_editar').submit();
            return false;
        }
        else if (!regex.test(name)) {
            Swal.fire('Error', 'Solo se aceptan letras en el nombre', 'error');
            document.getElementById('formulario_editar').submit();
            return false;
        } else if (name.length > 20) {
            Swal.fire('Error', 'El nombre es demasiado largo, Máximo 20 caracteres', 'error');
            document.getElementById('formulario_editar').submit();
            return false;
        } else if (surname.length > 20) {
            Swal.fire('Error', 'El apellido es demasiado largo, Máximo 20 caracteres', 'error');
            document.getElementById('formulario_editar').submit();
            return false;
        } else if (!regex.test(surname)) {
            Swal.fire('Error', 'Solo se aceptan letras en el apellido', 'error');
            document.getElementById('formulario_editar').submit();
            return false;
        } else if (celular.length != 10 || isNaN(celular)) {
            Swal.fire('Error', 'El celular debe tener 10 caracteres y ser numérico', 'error');
            document.getElementById('formulario_editar').submit();
            return false;
        }

        Swal.fire({
            title: "¡Estás seguro!",
            text: "¿Deseas editar este usuario?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, editar"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formulario_editar').submit();
            }
        });
    }
</script>

@endsection
