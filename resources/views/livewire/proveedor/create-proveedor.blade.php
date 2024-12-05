<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form wire:submit.prevent="submit">
            @csrf
            <div class="card card-body">
                <div class="form-group">
                    <div class="row">
                        <!-- Selección de tipo de proveedor -->
                        <div class="col-md-6">
                            <label for="tipo">Tipo de Proveedor <span class="text-danger">*</span> </label>
                            <select id="tipo" name="tipo" class="form-select @error('tipo_proveedor') is-invalid @enderror" wire:model.lazy="tipo_proveedor">
                                <option value="">Seleccionar una opción</option>
                                <option value="empresa">Empresa</option>
                                <option value="persona">Persona Natural</option>
                            </select>
                            @error('tipo_proveedor')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Campos para empresa -->
                    @if($tipo_proveedor == 'empresa')
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="numero">NIT de la Empresa <span class="text-danger">*</span> </label>
                            <input type="number" name="numero" id="numero" wire:model="numero_documento" class="form-control @error('numero_documento') is-invalid @enderror" value="{{ old('numero') }}" min="0" step="1">
                            @error('numero_documento')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>

                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nombre">Nombre de la Empresa <span class="text-danger">*</span> </label>
                            <input type="text" wire:model="nombre" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}">
                            @error('nombre')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="telefono">Teléfono de la Empresa <span class="text-danger">*</span></label>
                            <input type="tel" wire:model="telefono" name="telefono" maxlength="10" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}">
                            @error('telefono')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Correo de la Empresa <span class="text-danger">*</span> </label>
                            <input type="email" wire:model="correo" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo') }}">
                            @error('correo')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="ubicacion">Ubicación de la Empresa <span class="text-danger">*</span> </label>
                            <input type="text" wire:model="ubicacion" name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion') }}">
                            @error('ubicacion')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado</label>
                                <div class="form-check form-switch">
                                    <input
                                        wire:model.defer='estado'
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="estado"
                                        value="1"
                                        {{ old('estado', $estado) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Campos para persona natural -->
                    @if($tipo_proveedor == 'persona')
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="numero">Número de Documento <span class="text-danger">*</span> </label>
                            <input type="number" wire:model="numero_documento" name="numero_documento" id="numero_documento" class="form-control @error('numero_documento') is-invalid @enderror" value="{{ old('numero') }}">
                            @error('numero_documento')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nombre">Nombre Completo <span class="text-danger">*</span> </label>
                            <input type="text" wire:model="nombre" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}">
                            @error('nombre')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="telefono">Teléfono <span class="text-danger">*</span></label>
                            <input type="tel" wire:model="telefono" maxlength="10" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}">
                            @error('telefono')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Correo <span class="text-danger">*</span></label>
                            <input type="email" wire:model="correo" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo') }}">
                            @error('correo')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="ubicacion">Ubicación <span class="text-danger">*</span> </label>
                            <input type="text" wire:model="ubicacion" name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion') }}">
                            @error('ubicacion')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado</label>
                                <div class="form-check form-switch">
                                    <input
                                        wire:model.defer='estado'
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="estado"
                                        value="1"
                                        {{ old('estado', $estado) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group mt-3">
                        <button class="btn btn-primary" onclick="agregar()">Agregar</button>
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
            title: "¡Estás seguro!",
            text: "¿Deseas agregar este Proveedor?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, agregar"
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();
                // Cambiar el ID aquí
                @this.call('submit');
            }
        });
    }
</script>