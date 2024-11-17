<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de Categoría Insumos</b>
                        </span>
                    </div>
                </div>

                <div class="card-body">

                    @if ($errors->has('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('status') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: '{{ session('success') }}',
                                position: 'top-end',
                                toast: true,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>
                    @endif

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>
                
                        <div class="d-flex">
                            <a href="{{ route('Admin.categoria_insumo.create') }}" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="text-center" wire:click="sortBy('nombre')">
                                        Nombre de la Categoría
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
                                        @endif
                                    </th>

                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($categoria_insumos as $cat)
                                    <tr>
                                        <td class="text-center">{{ $cat->nombre }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-sm {{ $cat->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                                wire:click="changeStatus({{ $cat->id }})" style="cursor: pointer;">
                                                {{ $cat->estado == 1 ? 'Activo' : 'Inactivo' }}
                                                <i class="fas fa-toggle-{{ $cat->estado == 1 ? 'on' : 'off' }}"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div role="group" aria-label="Basic example">
                                                <a class="px-3 mx-1 btn btn-sm btn-warning" href="{{ route('Admin.categoria_insumo.edit', ['id' => $cat->id]) }}">
                                                    <i class="fa fa-fw fa-edit"></i> 
                                                </a>
                                                <form id="form_eliminar_{{ $cat->id }}" action="{{ route('Admin.categoria_insumo.destroy', ['id' => $cat->id]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="px-3 mx-1 btn btn-danger btn-sm" onclick="eliminar('{{$cat->id}}','{{$cat->estado}}')">
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
                            {{ $categoria_insumos->links() }}
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
            // Si está inactiva, proceder con la eliminación
            Swal.fire({
                title: "¡Estás seguro!",
                text: "¿Deseas eliminar esta categoría?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form_eliminar_' + categoriaId).submit();
                }
            });
        }
    }
</script>
