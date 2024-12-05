<!-- Contenedor flexible -->
<div class="d-flex flex-wrap justify-content-center align-items-center">
    <div class="d-flex justify-content-center align-items-center">
        <div class="card shadow-sm" style="max-width: 800px;"> <!-- Reducir tamaño del card -->
            <!-- Modal Header -->
            <div class="card-header text-center bg-primary text-white">
                <h3>Editar Producto</h3>
            </div>

            <!-- Modal Body -->
            <form wire:submit='updateProducto' id="formulario_crear" class="card-body">
                <h4 class="text-dark">Datos del Producto</h4
                    <!-- Sección: Datos del Producto -->
                <section class="bg-light p-4 rounded mb-4">
                    <div class="row g-4 mb-4 border border-300 rounded p-4">
                        <div class="row g-3">
                            <!-- Categoría -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoria_producto" class="form-label">Categoría de Producto</label>
                                    <select wire:model="id_categoria_producto" id="categoria_producto"
                                        class="form-select @error('id_categoria_producto') is-invalid @enderror">
                                        <option selected>Seleccionar Categoría</option>
                                        @foreach ($categorias_productos as $categoria_producto)
                                        <option value="{{ $categoria_producto->id_categoria_producto }}">{{ $categoria_producto->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_categoria_producto')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" wire:model="nombre" id="nombre" name="nombre"
                                        class="form-control @error('nombre') is-invalid @enderror" placeholder="Arreglo #1">
                                    @error('nombre')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea id="descripcion" wire:model="descripcion" name="descripcion"
                                        class="form-control @error('descripcion') is-invalid @enderror"
                                        placeholder="Arreglo para ocasiones especiales como cumpleaños"></textarea>
                                    @error('descripcion')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" wire:model="foto" id="foto" name="foto"
                                        class="form-control @error('foto') is-invalid @enderror">

                                    @if ($producto->foto) <!-- Muestra la imagen si ya existe -->
                                    <!-- <img src="{{ $producto->foto }}" alt="Foto" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;" loading="lazy"> -->
                                    @endif

                                    @error('foto')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Precio -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" wire:model="precio" id="precio" name="precio"
                                        class="form-control @error('precio') is-invalid @enderror" placeholder="200.000">
                                    @error('precio')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado" class="form-label">Estado</label>
                                    <div class="form-check form-switch">
                                        <input wire:model="estado" id="estado" name="estado" type="checkbox"
                                            class="form-check-input" value="1" {{ $estado ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <h4 class="mb-4">Insumos Seleccionados:</h4>

                <section class="row row-cols-1 row-cols-md-2 g-3">
                    @foreach ($insumos as $index => $insumo)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title font-weight-bold mb-2">
                                    {{ $insumo['nombre'] }} {{ $insumo['color'] ? ' - ' . $insumo['color'] : '' }}
                                </h5>
                                <p class="card-text text-muted mb-3">Cantidad: {{ $insumo['pivot']['cantidad_usada'] }}</p>
                                @if ($index_insumo_a_editar !== $index)
                                <div class=" justify-content-center" role="group">
                                    <button wire:click.prevent="seleccionarInsumoParaEditar({{ $index }})" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Editar
                                    </button>
                                    <button wire:click.prevent="eliminarInsumo({{ $index }})" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </div>
                                @endif

                                <!-- Formulario de Edición -->
                                @if ($index_insumo_a_editar === $index)
                                @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif

                                @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                                @endif
                                <div class="mt-4 p-3 border rounded bg-light">
                                    <h6 class="text-center font-weight-bold mb-3">Editar Insumo Seleccionado</h6>

                                    <!-- Categoría de Insumo -->
                                    <div class="form-group mb-3">
                                        <label for="categoria_insumos" class="form-label">Categoría de Insumo <strong style="color: red;">*</strong></label>
                                        <select wire:model="categoria_seleccionada" wire:change="actualizarInsumosPorCategoria" class="form-select">
                                            <option selected>Seleccionar Categoría</option>
                                            @foreach ($categorias_insumos as $categoria_insumo)
                                            <option value="{{ $categoria_insumo->id }}">{{ $categoria_insumo->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('categoria_seleccionada')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Insumo -->
                                    <div class="form-group mb-3">
                                        <label for="insumo" class="form-label">Insumo <strong style="color: red;">*</strong></label>
                                        <select wire:model="insumo_seleccionado" class="form-select">
                                            <option selected>Seleccionar Insumo </option>
                                            @foreach ($insumos_por_categoria as $insumo)
                                            <option value="{{ $insumo->id }}">{{ $insumo->nombre }}
                                                {{ $insumo->color ? ' - ' . $insumo->color : '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('insumo_seleccionado')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Cantidad Disponible -->
                                    <div class="form-group mb-3">
                                        <label for="cantidad_disponible" class="form-label">Cantidad Disponible </label>
                                        <input type="number" wire:model="cantidad_disponible" disabled class="form-control" />
                                    </div>

                                    <!-- Cantidad a Usar -->
                                    <div class="form-group mb-3">
                                        <label for="cantidad_usar" class="form-label">Cantidad a Usar <strong style="color: red;">*</strong></label>
                                        <input type="number" wire:model.live="cantidad_usada" class="form-control" step="1" min="1">
                                        @error('cantidad_usada')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Botón Guardar Cambios -->
                                    <div class="d-flex justify-content-between">
                                        <button wire:click.prevent="guardarCambiosInsumo({{ $index }})" class="btn btn-primary w-45">
                                            Guardar Cambios
                                        </button>
                                        <button wire:click.prevent="cancelarEdicion" class="btn btn-danger w-45">
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </section>



                <!-- Botones de Acción -->
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button
                        class="btn btn-primary d-inline-flex align-items-center" onclick="editar()">
                        <i class="bi bi-save"></i> Editar
                    </button>
                    <a href="{{ route('Admin.productos') }}" class="btn btn-danger d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function editar() {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas editar este producto?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, editar"
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();

                @this.call('updateProducto');
            }
        });
    }
</script>