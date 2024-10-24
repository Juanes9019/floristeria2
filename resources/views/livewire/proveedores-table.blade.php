<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de Proveedores</b>
                        </span>
                        <div class="float-right">
                            <a href="{{ route('Admin.proveedor.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Registrar Proveedor') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Exportar
                        </button>
                        <div class="dropdown-menu" aria-labelledby="exportDropdown">
                            <a class="dropdown-item" href="{{ route('Admin.proveedores.export', ['format' => 'xlsx']) }}">
                                {{ __('Exportar a Excel') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('Admin.proveedores.export', ['format' => 'pdf']) }}">
                                {{ __('Exportar a PDF') }}
                            </a>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @elseif($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
                @endif




                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center" wire:click="sortBy('id')">
                                        No
                                        @if ($ordenarColumna === 'id')
                                        @if ($ordenarForma === 'asc')
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                        </svg>
                                        @else
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                        @endif
                                        @else
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center" wire:click="sortBy('nombre')">
                                        Nombre
                                        @if ($ordenarColumna === 'nombre')
                                        @if ($ordenarForma === 'asc')
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                        </svg>
                                        @else
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                        @endif
                                        @else
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center">
                                        Telefono
                                    </th>
                                    <th scope="col" class="text-center">
                                        Correo
                                    </th>
                                    <th scope="col" class="text-center">
                                        Ubicacion
                                    </th>
                                    <th scope="col" class="text-center" wire:click="sortBy('estado')">
                                        Estado
                                        @if ($ordenarColumna === 'estado')
                                        @if ($ordenarForma === 'asc')
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                        </svg>
                                        @else
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                        @endif
                                        @else
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center" colspan="3">
                                        Acciones
                                    </th>
                                    <th class="text-center"></th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach($proveedores as $proveedor)
                                <tr>
                                    <td class="text-center"> {{ ($proveedores->currentPage() - 1) * $proveedores->perPage() + $loop->iteration }}</td>
                                    <td class="text-center">{{ $proveedor->nombre }}</td>
                                    <td class="text-center">{{ $proveedor->telefono }}</td>
                                    <td class="text-center">{{ $proveedor->correo }}</td>
                                    <td class="text-center">{{ $proveedor->ubicacion }}</td>
                                    <td class="text-center">{{ $proveedor->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-warning" href="{{ route('Admin.proveedor.edit', ['id' => $proveedor->id]) }}">
                                            <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                    </td>
                                    <td>
                                        <form id="form_eliminar_{{ $proveedor->id }}" action="{{ route('Admin.proveedor.destroy', $proveedor->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{ $proveedor->id }}')">
                                                <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm {{ $proveedor->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                            wire:click="changeStatus({{ $proveedor->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="changeStatus({{ $proveedor->id }})"
                                            style="cursor: pointer;">
                                            {{ $proveedor->estado == 1 ? 'Activo' : 'Inactivo' }}
                                            <i class="fas fa-toggle-{{ $proveedor->estado == 1 ? 'on' : 'off' }}"></i>
                                        </a>

                                        <div wire:loading wire:target="changeStatus({{ $proveedor->id }})">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <label>Páginas</label>
                        <select wire:model.live="porPagina">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <div class="mt-3">
                            {{ $proveedores->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <button wire.click="openmodal" data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Toggle modal
    </button>

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Product
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                            <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="$2999" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="">Select category</option>
                                <option value="TV">TV/Monitors</option>
                                <option value="PC">PC</option>
                                <option value="GA">Gaming/Console</option>
                                <option value="PH">Phones</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
                            <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write product description here"></textarea>                    
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Add new product
                    </button>
                </form>
            </div>
        </div>
</div> 


</div>


<script>
    function eliminar(proveedorId) {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas Eliminar este proveedor?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Proveedor Eliminado!",
                    text: "El proveedor se Eliminó Correctamente",
                    icon: "success"
                }).then(() => {
                    document.getElementById('form_eliminar_' + proveedorId).submit();
                });
            }
        });
    }
</script>