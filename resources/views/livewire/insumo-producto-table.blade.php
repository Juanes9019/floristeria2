<div class="relative overflow-x-auto tx ">
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
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2 sm:col-span-1">
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria Insumo</label>
                        <select wire:model.lazy='categoria_seleccionada' id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Seleccionar Categoria</option>
                            @foreach ($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                        <label for="cantidad_usar" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad A Usar</label>
                        <input id="cantidad_usar" wire:model='cantidad_usada' type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="insumo" class="block mb-2 text-sm font-medium text-gray-900 dark:text">Insumos</label>
                        <select wire:model.live="insumo_seleccionado" id="insumo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Seleccionar Insumo</option>
                            @foreach ($insumos_por_categoria as $insumo)
                            <option wire:key="{{$insumo->id}}" value="{{$insumo->id}}">{{$insumo->nombre}}</option>
                            @endforeach
                        </select>
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
                                    <div class="me-2">
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


        <button wire:click='crearProducto' type="button" class="text-white inline-flex items-center bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-black dark:hover:bg-gray-700 dark:focus:ring-gray-800">
            <svg class="me-1 -ms-1 w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Crear Producto
        </button>
        <button wire:click='clearFields' class="text-black inline-flex items-center bg-white border border-gray-400 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            <svg class="me-1 -ms-1 w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="m16.24 3.56l4.95 4.94c.78.79.78 2.05 0 2.84L12 20.53a4.01 4.01 0 0 1-5.66 0L2.81 17c-.78-.79-.78-2.05 0-2.84l10.6-10.6c.79-.78 2.05-.78 2.83 0M4.22 15.58l3.54 3.53c.78.79 2.04.79 2.83 0l3.53-3.53l-4.95-4.95z" />
            </svg>
            Borrar Campos
        </button>
        </form>
    </div>
</div>
</div>