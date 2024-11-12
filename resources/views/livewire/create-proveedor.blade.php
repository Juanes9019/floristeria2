<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.proveedor.store') }}" novalidate>
            @csrf
            <div class="card card-body">
                <div class="form-group">
                    <div class="row">
                        <!-- Selección de tipo de proveedor -->
                        <div class="col-md-6">
                            <label for="tipo">Tipo de Proveedor <span class="text-danger">*</span> </label>
                            <select id="tipo" name="tipo" class="form-control" wire:model.lazy="tipo_proveedor">
                                <option value="empresa">Empresa</option>
                                <option value="persona">Persona Natural</option>
                            </select>
                        </div>
                    </div>

                    <!-- Campos para empresa -->
                    @if($tipo_proveedor == 'empresa')
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="numero">NIT de la Empresa <span class="text-danger">*</span> </label>
                            <input type="text" name="numero" id="numero"  class="form-control" value="{{ old('numero') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="nombre">Nombre de la Empresa <span class="text-danger">*</span> </label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="telefono">Teléfono de la Empresa</label>
                            <input type="tel" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Correo de la Empresa <span class="text-danger">*</span> </label>
                            <input type="email" name="correo" id="correo" class="form-control" value="{{ old('correo') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="ubicacion">Ubicación de la Empresa <span class="text-danger">*</span> </label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="estado">Estado <span class="text-danger">*</span> </label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    <!-- Campos para persona natural -->
                    @if($tipo_proveedor == 'persona')
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="nombre">Nombre Completo <span class="text-danger">*</span> </label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="numero">Número de Documento <span class="text-danger">*</span> </label>
                            <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Correo</label>
                            <input type="email" name="correo" id="correo" class="form-control" value="{{ old('correo') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="ubicacion">Ubicación <span class="text-danger">*</span> </label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion') }}">
                        </div>
                        <div class="col-md-6">
                        <label for="estado">Estado <span class="text-danger">*</span></label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                        <a href="{{ route('Admin.proveedores') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
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