<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de Proveedores</b>
                        </span>
                    </div>
                </div>


                @if ($message = Session::get('error'))
                <script>
                    Swal.fire({
                        title: '¡Error!',
                        text: '{{ $message }}',
                        icon: 'error',
                        position: 'top-end',
                        toast: true,
                        showConfirmButton: false,
                        timer: 5000
                    });
                </script>
                @endif

                @if ($message = Session::get('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: '{{ $message }}',
                        position: 'top-end',
                        toast: true,
                        showConfirmButton: false,
                        timer: 5000
                    });
                </script>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>

                        <div class="d-flex">
                            <div class="dropdown mr-2">
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
                        <a href="{{ route('Admin.proveedor.create') }}" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center">
                                    Tipo Proveedor
                                </th>
                                <!-- <th scope="col" class="text-center">
                                    Número de Documento
                                </th> -->
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
                                    Teléfono
                                </th>
                                <th scope="col" class="text-center">
                                    Correo
                                </th>
                                <th scope="col" class="text-center">
                                    Ubicación
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
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($proveedores as $proveedor)
                            <tr>
                                <td class="text-center">{{ ucfirst(strtolower($proveedor->tipo_proveedor)) }}</td>
                                <td class="text-center">{{ $proveedor->nombre }}</td>
                                <td class="text-center">{{ $proveedor->telefono }}</td>
                                <td class="text-center">{{ $proveedor->correo }}</td>
                                <td class="text-center">{{ $proveedor->ubicacion }}</td>
                                <td class="text-center">
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

                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 1rem;">
                                        <!-- Botón de editar -->
                                        <a class="btn btn-sm btn-warning" href="{{ route('Admin.proveedor.edit', ['id' => $proveedor->id]) }}">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>

                                        <!-- Botón de eliminar -->
                                        <form id="form_eliminar_{{ $proveedor->id }}" action="{{ route('Admin.proveedor.destroy', $proveedor->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{ $proveedor->id}}','{{$proveedor->estado}}')">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </form>
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



<script>
    function eliminar(proveedorId, estadoProveedor) {
        if (estadoProveedor == 1) {
            Swal.fire({
                title: "¡Error!",
                text: "No se puede eliminar un proveedor activo.",
                icon: "error",
                confirmButtonText: "OK"
            });
        } else {
            // Si la categoría no es activa, proceder a eliminar
            Swal.fire({
                title: "¡Estás seguro!",
                text: "¿Deseas eliminar este proveedor?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`form_eliminar_${proveedorId}`).submit();
                }
            });
        }
    }
</script>