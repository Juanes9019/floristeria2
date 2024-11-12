<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de Productos</b>
                        </span>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>

                        <div class="d-flex">
                            <div class="dropdown mr-2">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportar
                                </button>

                            </div>
                            <a href="{{ route('Admin.producto.create') }}" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                    <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover">
                        <thead class="table">
                            <tr>
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
                                <th scope="col" class="text-center">Categoria Producto</th>
                                <th scope="col" class="text-center">Descripción</th>
                                <th scope="col" class="text-center" wire:click="sortBy('precio')">
                                    Precio
                                    @if ($ordenarColumna === 'precio')
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
                                <th scope="col" class="text-center">Foto</th>
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
                            @foreach($productos as $producto)
                            <tr>
                                <td class="align-middle text-center">{{ $producto->nombre }}</td>
                                <td class="align-middle text-center">{{$producto->categoria_producto->nombre}}</td>
                                <td class="align-middle text-center">{{$producto->descripcion_limitada}}</td>
                                <td class="align-middle text-center">{{ number_format($producto->precio, 0, ',', '.') }}</td>
                                <td class="align-middle text-center justify-content-center">
                                    <img src="{{ $producto->foto }}" alt="Foto" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;" loading="lazy">
                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-sm {{ $producto->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                        wire:click="changeStatus({{ $producto->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="changeStatus({{ $producto->id }})"
                                        style="cursor: pointer;">
                                        {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                                        <i class="fas fa-toggle-{{ $producto->estado == 1 ? 'on' : 'off' }}"></i>
                                    </a>

                                    <div wire:loading wire:target="changeStatus({{ $producto->id }})">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-sm btn-warning" href="{{ route('Admin.producto.edit', ['id' => $producto->id]) }}">
                                        <i class="fa fa-fw fa-edit"></i>
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-sm btn-primary" href="{{ route('Admin.producto.show', ['id' => $producto->id]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                        </svg>
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    <form id="form_eliminar_{{ $producto->id }}" action="{{ route('Admin.producto.destroy', ['id' => $producto->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{$producto->id}}','{{$producto->estado}}')">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <label for="pages">Páginas</label>
                    <select id="pages" name="pages" wire:model.live="porPagina">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                    <div class="mt-3">
                        {{ $productos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function eliminar(productoId) {
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
                    document.getElementById('form_eliminar_' + productoId).submit();
                });
            }
        });
    }
</script>