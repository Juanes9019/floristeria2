<!-- Contenedor flexible -->
<div class="d-flex flex-wrap justify-content-between align-items-center">
    <div class="table-responsive tx">
        <div id="crud-modal" class="container mt-5">
            <div class="card">
                <!-- Modal Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">Editar Producto</h3>
                </div>

                <!-- Modal Body -->
                <form id="formulario_crear" class="card-body">
                    <!-- Sección: Datos del Producto -->
                    <section class="bg-light p-4 rounded mb-4 w-100">
                        <h4 class="h6 mb-4">Datos del Producto</h4>
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
                                    @if (isset($producto) && $producto->foto)
                                    <!-- <div class="mt-3">
                                        <img src="{{ $producto->foto }}" alt="Imagen del producto" class="img-thumbnail"
                                            style="max-width: 200px;">
                                    </div> -->
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
                    </section>



                    <!-- Separador -->
                    <hr class="w-100">

                    <!-- Sección: Insumos -->
                    <section class="row row-cols-1 row-cols-md-2 g-4 w-100">
                        @foreach ($insumos as $index => $insumo)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center">
                                    <!-- Nombre y Cantidad -->
                                    <h5 class="card-title font-weight-bold">
                                        {{ $insumo['nombre'] }} {{ $insumo['color'] ? ' - ' . $insumo['color'] : '' }}
                                    </h5>
                                    <p class="card-text text-muted">Cantidad: {{ $insumo['pivot']['cantidad_usada'] }}</p>

                                    <!-- Acciones -->
                                    @if ($index_insumo_a_editar !== $index)
                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        <button wire:click.prevent="seleccionarInsumoParaEditar({{ $index }})"
                                            class="btn btn-warning">
                                            Editar
                                        </button>
                                        <button wire:click.prevent="eliminarInsumo({{ $index }})"
                                            class="btn btn-danger">
                                            Eliminar
                                        </button>
                                    </div>
                                    @endif

                                    <!-- Formulario de Edición -->
                                    @if ($index_insumo_a_editar === $index)
                                    <div class="mt-4 p-3 bg-light rounded">
                                        <h6 class="text-center font-weight-bold mb-3">Editar Insumo Seleccionado</h6>

                                        <!-- Selección de Categoría -->
                                        <div class="form-group">
                                            <label for="categoria_insumos" class="form-label">Categoría de Insumo</label>
                                            <select wire:model="categoria_seleccionada"
                                                wire:change="actualizarInsumosPorCategoria" class="form-select">
                                                <option selected>Seleccionar Categoría</option>
                                                @foreach ($categorias_insumos as $categoria_insumo)
                                                <option value="{{ $categoria_insumo->id }}">{{ $categoria_insumo->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Selección de Insumo -->
                                        <div class="form-group">
                                            <label for="insumo" class="form-label">Insumo</label>
                                            <select wire:model="insumo_seleccionado" class="form-select">
                                                <option selected>Seleccionar Insumo</option>
                                                @foreach ($insumos_por_categoria as $insumo)
                                                <option value="{{ $insumo->id }}">{{ $insumo->nombre }}
                                                    {{ $insumo->color ? ' - ' . $insumo->color : '' }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Cantidad a Usar -->
                                        <div class="form-group">
                                            <label for="cantidad_usar" class="form-label">Cantidad a Usar</label>
                                            <input type="number" wire:model="cantidad_usada" class="form-control">
                                        </div>

                                        <!-- Botón Guardar Cambios -->
                                        <button wire:click.prevent="guardarCambiosInsumo({{ $index }})"
                                            class="btn btn-primary w-100 mt-3">
                                            Guardar Cambios
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </section>

                    <!-- Botones de Acción -->
                    <div class="mt-4 d-flex justify-content-between align-items-center w-100">
                        <button wire:click.prevent="updateProducto" type="button"
                            class="btn btn-dark d-inline-flex align-items-center">
                            Actualizar Producto
                        </button>
                        <a href="{{ route('Admin.productos') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
                            Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>