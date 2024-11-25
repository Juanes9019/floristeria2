<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 800px;">
        <div class="card-header text-center bg-primary text-white">
            <h3>Crear Producto</h3>
        </div>
        <div class="card-body">
            <form id="formulario_crear" method="POST" enctype="multipart/form-data">
                <!-- Campos para crear producto -->
                <div class="bg-light p-3 rounded mb-4">
                    <h4 class="text-secondary">Datos del Producto</h4>
                    <div class="row g-4 mb-4 border border-300 rounded p-4">

                        <!-- Categoría de Producto -->
                        <div class="col-md-6">
                            <label for="categoria_producto" class="form-label">Categoría de Producto <span class="text-danger">*</span></label>
                            <select name="id_categoria_producto" id="categoria_producto" class="form-select @error('id_categoria_producto') is-invalid @enderror">
                                <option selected disabled>Seleccionar Categoría</option>
                                @foreach ($categorias_productos as $categoria_producto)
                                <option value="{{ $categoria_producto->id_categoria_producto }}">{{ $categoria_producto->nombre }}</option>
                                @endforeach
                            </select>
                            @error('id_categoria_producto')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Arreglo #1">
                            @error('nombre')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="col-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Arreglo para ocasiones especiales como cumpleaños"></textarea>
                            @error('descripcion')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="col-md-6">
                            <label for="foto" class="form-label">Foto <span class="text-danger">*</span></label>
                            <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror">
                            <small class="form-text text-muted">Cargue una imagen en formato JPG o PNG.</small>
                            @error('foto')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <!-- Precio -->
                        <div class="col-md-6">
                            <label for="precio" class="form-label">Precio <span class="text-danger">*</span></label>
                            <input type="number" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" placeholder="200.000">
                            @error('precio')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Estado</label>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Seleccionar Insumos -->
                <div class="bg-light p-4 rounded">
                    <h4 class="h5 mb-4 text-dark">Seleccionar Insumos</h4>
                    <div class="row g-4 mb-4 border border-300 rounded p-4">

                        <!-- Categoría de Insumo -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categoria_insumos" class="form-label">Categoría de Insumo <span class="text-danger">*</span></label>
                                <select wire:model.lazy="categoria_seleccionada" id="categoria_insumos" name="categoria_insumos" class="form-select @error('categoria_seleccionada') is-invalid @enderror">
                                    <option selected="">Seleccionar Categoría</option>
                                    @foreach ($categorias_insumos as $categoria_insumo)
                                    <option value="{{ $categoria_insumo->id }}">{{ $categoria_insumo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('categoria_seleccionada')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Insumo -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="insumo" class="form-label">Insumo <span class="text-danger">*</span></label>
                                <select wire:model.live="insumo_seleccionado" id="insumo" name="insumo" class="form-select @error('insumo_seleccionado') is-invalid @enderror">
                                    <option selected="">Seleccionar Insumo</option>
                                    @foreach ($insumos_por_categoria as $insumo)
                                    <option wire:key="{{ $insumo->id }}" value="{{ $insumo->id }}">{{ $insumo->nombre }} {{ $insumo->color ? ' - ' . $insumo->color : '' }}</option>
                                    @endforeach
                                </select>
                                @error('insumo_seleccionado')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Cantidad a Usar -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidad_usar" class="form-label">Cantidad a Usar <span class="text-danger">*</span></label>
                                <input id="cantidad_usar" name="cantidad_usar" wire:model='cantidad_usada' type="number" class="form-control @error('cantidad_usada') is-invalid @enderror" />
                                @error('cantidad_usada')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Cantidad Disponible -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidad_disponible" class="form-label">Cantidad Disponible <span class="text-danger">*</span></label>
                                <input type="number" value="{{$cantidad_disponible}}" disabled class="form-control" />
                            </div>
                        </div>

                        <!-- Botón Agregar Insumo -->
                        <div class="col-12">
                            <button type="button" wire:click="agregarInsumo" class="btn btn-success d-flex align-items-center">
                                <svg class="me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Agregar Insumo
                            </button>
                        </div>

                    </div>
                </div>


                <div class="card mt-4">
                    <div class="card-header bg-primary text-white font-weight-bold">Insumos seleccionados:</div>
                    <div class="card-body">
                        @if($insumos_agregados)
                        <ul class="list-group">
                            @foreach($insumos_agregados as $index => $insumo)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $insumo['nombre'] }} {{ $insumo['color'] ? ' - ' . $insumo['color'] : '' }}</strong> - Cantidad: {{ $insumo['cantidad'] }}
                                </div>
                                <div class="btn-group">
                                    <button wire:click.prevent="decrementarInsumo({{ $index }})" type="button" class="btn btn-danger btn-sm">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button wire:click.prevent="incrementarInsumo({{ $index }})" type="button" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button wire:click.prevent='eliminarInsumo({{ $index }})' type="button" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-muted">No hay insumos seleccionados</p>
                        @endif
                    </div>
                </div>



                <!-- Botones -->
                <div class="d-flex justify-content-end gap-2">
                    <button wire:click.prevent='crearProducto' type=" button" class="btn btn-primary">Crear Producto</button>
                    <a href="{{ route('Admin.productos') }}" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>