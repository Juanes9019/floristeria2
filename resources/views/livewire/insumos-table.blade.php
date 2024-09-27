<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de insumos</b>
                        </span>
                        <div class="float-right">
                            <a href="{{ route('Admin.insumo.create') }}" class="btn btn-primary btn-sm float-right"
                                data-placement="left">
                                {{ __('Registrar insumos') }}
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
                            <a class="dropdown-item" href="{{ route('Admin.insumos.export', ['format' => 'xlsx']) }}">
                                {{ __('Exportar a Excel') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('Admin.insumos.export', ['format' => 'pdf']) }}">
                                {{ __('Exportar a PDF') }}
                            </a>
                        </div>
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
                        title: 'Insumo Eliminado',
                        text: '{{ $message }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
                @endif

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
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
                                        @endif
                                    </th>

                                    <th scope="col" class="text-center" wire:click="sortBy('id_categoria_insumo')">
                                        Categoria_insumo
                                        @if ($ordenarColumna === 'id_categoria_insumo')
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
                                        @endif
                                    </th>

                                    <th scope="col" class="text-center">Cantidad Insumo</th>
                                    <th scope="col" class="text-center">Costo Unitario</th>
                                    <th scope="col" class="text-center">Perdida Insumo</th>
                                    <th scope="col" class="text-center">Costo Perdida</th>

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
                                @foreach($insumos as $insumo)
                                    <tr>
                                        <td class="text-center">{{ ($insumos->currentPage() - 1) * $insumos->perPage() + $loop->iteration }}</td>
                                        <td class="text-center">{{ $insumo->categoria_insumo->nombre }}</td>
                                        <td class="text-center">
                                            {{ $insumo->nombre }}{{ $insumo->color ? ' - ' . $insumo->color : '' }}
                                        </td>                                        
                                        <td class="text-center">{{ $insumo->cantidad_insumo }}</td>
                                        <td class="text-center">{{ number_format($insumo->costo_unitario, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group" aria-label="small button group">
                                                <a href="{{ route('incrementarInsumo', ['id' => $insumo->id]) }}" class="btn btn-success efecto">+</a>
                                                {{ $insumo->perdida_insumo }}
                                                <a href="{{ route('decrementarInsumo', ['id' => $insumo->id]) }}" class="btn btn-danger efecto">-</a>
                                            </div>
                                        </td>

                                        <td class="text-center">{{ number_format($insumo->costo_perdida, 0, ',', '.') }}</td>

                                        <td class="text-center">
                                            <a class="btn btn-sm {{ $insumo->estado == 1 ? 'btn-success' : 'btn-danger' }}" wire:click="changeStatus({{ $insumo->id }})" style="cursor: pointer;">
                                                {{ $insumo->estado == 1 ? 'Activo' : 'Inactivo' }}
                                                <i class="fas fa-toggle-{{ $insumo->estado == 1 ? 'on' : 'off' }}"></i>
                                            </a>
                                        </td>
                                        <td>
                                        <a class="btn btn-sm btn-success" href="{{ route('Admin.insumo.edit', ['id' => $insumo->id]) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                        </td>
                                        <td class="text-center">
                                        <form id="form_eliminar_{{ $insumo->id }}" action="{{ route('Admin.insumo.destroy', ['id' => $insumo->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{$insumo->id}}','{{$insumo->estado}}')">
                                                <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
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
                            {{ $insumos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function eliminar(id, estadoInsumo) {
    if (estadoInsumo == 1) { 
        Swal.fire({
            title: "¡Error!",
            text: "No se puede eliminar una insumo activo.",
            icon: "error",
            confirmButtonText: "OK"
        });
    } else {
        Swal.fire({
            title: "¡Estás seguro!",
            text: "¿Deseas eliminar este insumo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Insumo Eliminado!",
                    text: "El insumo se eliminó correctamente.",
                    icon: "success"
                }).then(() => {
                    document.getElementById('form_eliminar_' + id).submit();
                });
            }
        });
    }
}
</script>