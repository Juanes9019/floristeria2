@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<h2 class="text-center mb-5">Crear Un Nuevo Proveedor</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">

        <form id="formulario_crear" method="POST" action="{{ route('Admin.proveedor.store') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="tipo">Tipo de Proveedor</label>
                <select id="tipo" name="tipo" class="form-control" onchange="toggleProveedorForm()">
                    <option value="empresa">Empresa</option>
                    <option value="persona_natural">Persona Natural</option>
                </select>
            </div>

            <!-- Campos para empresa -->
            <div id="empresaFields">
                <div class="form-group">
                    <label for="nombre_empresa">Nombre de la Empresa</label>
                    <input type="text" name="nombre_empresa" id="nombre_empresa" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nit">NIT de la Empresa</label>
                    <input type="text" name="nit" id="nit" class="form-control">
                </div>
                <div class="form-group">
                    <label for="telefono_empresa">Teléfono de la Empresa</label>
                    <input type="text" name="telefono_empresa" id="telefono_empresa" class="form-control">
                </div>
                <div class="form-group">
                    <label for="correo_empresa">Correo de la Empresa</label>
                    <input type="email" name="correo_empresa" id="correo_empresa" class="form-control">
                </div>
                <div class="form-group">
                    <label for="ubicacion_empresa">Ubicación de la Empresa</label>
                    <input type="text" name="ubicacion_empresa" id="ubicacion_empresa" class="form-control">
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                    </select>
                </div>
            </div>

            <!-- Campos para persona natural -->
            <div id="personaNaturalFields" style="display: none;">
                <div class="form-group">
                    <label for="nombre_persona">Nombre Completo</label>
                    <input type="text" name="nombre_persona" id="nombre_persona" class="form-control">
                </div>
                <div class="form-group">
                    <label for="numero_documento">Número de Documento</label>
                    <input type="text" name="numero_documento" id="numero_documento" class="form-control">
                </div>
                <div class="form-group">
                    <label for="telefono_persona">Teléfono</label>
                    <input type="text" name="telefono_persona" id="telefono_persona" class="form-control">
                </div>
                <div class="form-group">
                    <label for="correo_persona">Correo</label>
                    <input type="email" name="correo_persona" id="correo_persona" class="form-control">
                </div>
                <div class="form-group">
                    <label for="ubicacion_persona">Ubicación</label>
                    <input type="text" name="ubicacion_persona" id="ubicacion_persona" class="form-control">
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                    </select>
                </div>

            </div>


            <div class="form-group">
                <button type="button" class="btn btn-success" value="Agregar proveedor" onclick="agregar()">Agregar</button>
                <a href="{{ route('Admin.proveedores') }}" class="btn btn-danger ">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleProveedorForm() {
        let tipo = document.getElementById('tipo').value;
        document.getElementById('empresaFields').style.display = tipo === 'empresa' ? 'block' : 'none';
        document.getElementById('personaNaturalFields').style.display = tipo === 'persona_natural' ? 'block' : 'none';
    }

    // Ejecuta la función al cargar la página para establecer el estado inicial
    window.onload = toggleProveedorForm;

    function agregar() {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas agregar este proveedor?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, agregar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Proveedor agregado!",
                    text: "El proveedor se agrego correctamente",
                    icon: "success"
                });
                event.preventDefault();
                document.getElementById('formulario_crear').submit();
            }
        });
    }
</script>

@stop