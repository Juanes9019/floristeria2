<div class="container-fluid">
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <b>Control de categorias</b>
                        </span>
                    </div>
                </div>
                @if ($message = Session::get('error'))
                <script>
                    Swal.fire({
                        title: '¡Error!',
                        text: '{{ $message }}',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>
                @endif

                @if ($message = Session::get('success'))
                <script>
                    Swal.fire({
                        title: 'Categoría Eliminada',
                        text: '{{ $message }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
                @endif



                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>
                
                        <div class="d-flex">
                            <a href="{{ route('Admin.categoria_producto.create') }}" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>


                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
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
                                    
                                    <th scope="col" class="text-center">Acciones</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias_productos as $categoria_producto)
                                <tr>
                                    <td class="text-center">{{ $categoria_producto->nombre }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm {{ $categoria_producto->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                            wire:click="changeStatus({{ $categoria_producto->id_categoria_producto }})"
                                            wire:loading.attr="disabled"
                                            wire:target="changeStatus({{ $categoria_producto->id_categoria_producto }})"
                                            style="cursor: pointer;">
                                            {{ $categoria_producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                                            <i class="fas fa-toggle-{{ $categoria_producto->estado == 1 ? 'on' : 'off' }}"></i>
                                        </a>

                                        <div wire:loading wire:target="changeStatus({{ $categoria_producto->id_categoria_producto }})">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <a class="btn btn-sm btn-warning"
                                            href="{{ route('Admin.categoria_producto.edit', ['id' => $categoria_producto->id_categoria_producto]) }}"><i
                                                class="fa fa-fw fa-edit"></i></a>
                                    </td>
                                    
                                    <td class="text-center">
                                        <form id="form_eliminar_{{ $categoria_producto->id_categoria_producto }}" action="{{ route('Admin.categoria_producto.destroy', ['id' => $categoria_producto->id_categoria_producto]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{$categoria_producto->id_categoria_producto}}','{{$categoria_producto->estado}}')">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </form>
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
                            {{ $categorias_productos->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function eliminar(categoriaId, estadoCategoria) {
    if (estadoCategoria == 1) { 
        Swal.fire({
            title: "¡Error!",
            text: "No se puede eliminar una categoría activa.",
            icon: "error",
            confirmButtonText: "OK"
        });
    } else {
        // Si la categoría no es activa, proceder a eliminar
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡Esta acción no se puede deshacer!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`form_eliminar_${categoriaId}`).submit();
            }
        });
    }
}
</script>