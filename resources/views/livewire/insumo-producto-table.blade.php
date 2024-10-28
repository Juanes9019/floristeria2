<div class="relative overflow-x-auto tx">
    <div id="crud-modal" class="relative w-full max-w-4xl mx-auto my-10">
        <div class="bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Crear Producto
                </h3>
            </div>

            <!-- Modal body -->
            <form class="p-4 md:p-5">
                <!-- Campos para crear producto -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6 dark:bg-gray-800">
                    <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Datos del Producto</h4>
                    <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-2">

                        <div class="form-group">
                            <label for="categoria_producto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoría de Producto</label>
                            <select wire:model="id_categoria_producto" id="categoria_producto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="">Seleccionar Categoría</option>
                                @foreach ($categorias_productos as $categoria_producto)
                                <option value="{{ $categoria_producto->id_categoria_producto }}">{{ $categoria_producto->nombre }}</option>
                                @endforeach
                            </select>
                            @error('id_categoria_producto')
                            <span class="invalid-feedback d-block text-sm text-red-600 mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" wire:model="nombre" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror mt-1 block w-full p-2.5 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" placeholder="Arreglo #1">
                            @error('nombre')
                            <span class="invalid-feedback d-block text-sm text-red-600 mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="form-group">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                            <textarea id="descripcion" wire:model="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror mt-1 block w-full p-2.5 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" placeholder="Arreglo para ocasiones especiales como cumpleaños"></textarea>
                            @error('descripcion')
                            <span class="invalid-feedback d-block text-sm text-red-600 mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            @if(isset($producto) && $producto->foto)
                            <div class="mb-2">
                                <img src="{{ $producto->foto }}" alt="Imagen del producto" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                            @endif
                            <input type="file" wire:model="foto" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror wire:loading.attr=" disabled"">
                            @error('foto')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Precio -->
                        <div class="form-group col-span-1">
                            <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                            <input type="number" wire:model="precio" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror mt-1 block w-full p-2.5 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" placeholder="200.000">
                            @error('precio')
                            <span class="invalid-feedback d-block text-sm text-red-600 mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select wire:model="estado" id="estado" class="form-control">
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option> 
                        </select>
                    </div>
                </div>


                <!-- Seleccionar Insumos -->
                <div class="bg-gray-50 p-4 rounded-lg dark:bg-gray-800">
                    <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Seleccionar Insumos</h4>
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-2">
                        <div class="form-group">
                            <label for="categoria_insumos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoría de Insumo</label>
                            <select wire:model.lazy='categoria_seleccionada' id="categoria_insumos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="">Seleccionar Categoría</option>
                                @foreach ($categorias_insumos as $categoria_insumo)
                                <option value="{{$categoria_insumo->id}}">{{$categoria_insumo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="insumo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Insumo</label>
                            <select wire:model.live="insumo_seleccionado" id="insumo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="">Seleccionar Insumo</option>
                                @foreach ($insumos_por_categoria as $insumo)
                                <option wire:key="{{$insumo->id}}" value="{{$insumo->id}}">{{$insumo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cantidad_usar" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad a Usar</label>
                            <input id="cantidad_usar" wire:model='cantidad_usada' type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                        </div>

                        <div class="form-group">
                            <label class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad Disponible</label>
                            <input type="number" value="{{$cantidad_disponible}}" disabled class="bg-gray-100 w-full p-2.5 rounded-lg border border-gray-300 text-gray-900" />
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <button type="button" wire:click="agregarInsumo" class="text-white inline-flex items-center bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-black dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                <svg class="me-1 -ms-1 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Agregar Insumo
                            </button>
                        </div>
                    </div>

                    <!-- Insumos agregados -->
                    <div class="card mt-4">
                        <div class="card-header text-black" style="background-color: #FFB6C1;">Insumos seleccionados:</div>
                        <div class="card-body">
                            @if($insumos_agregados)
                            <ul class="list-group">
                                @foreach($insumos_agregados as $index => $insumo)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $insumo['nombre'] }}</strong> - Cantidad: {{ $insumo['cantidad'] }}
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        <button wire:click.prevent="decrementarInsumo({{ $index }})" type="button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded-full shadow-sm transition duration-300 ease-in-out">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button wire:click.prevent="incrementarInsumo({{ $index }})" type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded-full shadow-sm transition duration-300 ease-in-out">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button wire:click.prevent='eliminarInsumo({{ $index }})' type="button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded shadow-sm transition duration-300 ease-in-out">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p>No hay insumos seleccionados</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-6 flex justify-between">
                    <button wire:click.prevent='crearProducto' type="button" class="text-white inline-flex items-center bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-black dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <svg class="me-1 -ms-1 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Crear Producto
                    </button>

                    <button wire:click='clearFields' class="text-black inline-flex items-center bg-white border border-gray-400 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="m16.24 3.56 4.95 4.94c.78.79.78 2.05 0 2.84L12 20.53a4.01 4.01 0 0 1-5.66 0L2.81 17c-.78-.79-.78-2.05 0-2.84l10.6-10.6c.79-.78 2.05-.78 2.83 0M4.22 15.58l3.54 3.53c.78.79 2.04.79 2.83 0l3.53-3.53-4.95-4.95z" />
                        </svg>
                        Borrar Campos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>