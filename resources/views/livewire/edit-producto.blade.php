<div class="relative overflow-x-auto tx">
    <div id="crud-modal" class="relative w-full max-w-4xl mx-auto my-10">
        <div class="bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar Producto
                </h3>
            </div>

            <!-- Modal body -->
            <form  id="formulario_crear" class="p-4 md:p-5">
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
                        <div class="form-group">
                            <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                            <input type="number" wire:model="precio" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror mt-1 block w-full p-2.5 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" placeholder="200.000">
                            @error('precio')
                            <span class="invalid-feedback d-block text-sm text-red-600 mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                            <label class="inline-flex items-center me-5 cursor-pointer">
                                <input wire:model="estado" id="estado" name="estado" type="checkbox" class="sr-only peer" value="1" {{ $estado ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                            </label>
                        </div>


                    </div>


                    <!-- Seleccionar Insumos -->
                   

                    <!-- Botones de acción -->
                    <div class="mt-6 flex justify-between">
                        <button wire:click.prevent='updateProducto' type="button" class="text-white inline-flex items-center bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-black dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            <svg class="me-1 -ms-1 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Crear Producto
                        </button>
                        <a href="{{ route('Admin.productos') }}" class="text-black inline-flex items-center bg-white border border-gray-400 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Volver
                        </a>

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


<script>
    function agregar(event) {
        event.preventDefault();

        Swal.fire({
            title: "¡Estás seguro!",
            text: "¿Deseas agregar este producto?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, agregar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Producto agregado!",
                    text: "El producto se agregó correctamente",
                    icon: "success"
                }).then(() => {
                    document.getElementById('formulario_crear').submit();
                });
            }
        });
    }
</script>