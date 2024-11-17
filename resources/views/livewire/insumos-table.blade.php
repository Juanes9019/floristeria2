<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de insumos</b>
                        </span>
                    </div>
                </div>
                @if ($message = Session::get('error'))
                    <script>
                        function eliminar(id, estadoInsumo) {
                            if (estadoInsumo == 1) {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "No se puede eliminar un insumo activo.",
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
                @endif

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
                
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Exportar
                            </button>
                            <a href="{{ route('Admin.insumo.historialPerdidas') }}" class="btn btn-primary">Historial de Pérdidas</a>
                            <a href="{{ route('Admin.insumo.create') }}" class="btn btn-primary"data-placement="left">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                            </a>
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
                </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
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
                                        @endif
                                    </th>

                                    <th scope="col" class="text-center" wire:click="sortBy('id_categoria_insumo')">
                                        Categoría insumo
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

                                    <th scope="col" class="text-center">Cantidad Insumo</th>
                                    <th scope="col" class="text-center">Costo Unitario</th>
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
                                        <td class="text-center">
                                            {{ $insumo->nombre }}{{ $insumo->color ? ' - ' . $insumo->color : '' }}
                                        </td>               
                                        <td class="text-center">{{ $insumo->categoria_insumo->nombre }}</td>                         
                                        <td class="text-center">{{ $insumo->cantidad_insumo }}</td>
                                        <td class="text-center">{{ number_format($insumo->costo_unitario, 0, ',', '.') }}</td>
                                        
                                        <td class="text-center">
                                            <a class="btn btn-sm {{ $insumo->estado == 1 ? 'btn-success' : 'btn-danger' }}" wire:click="changeStatus({{ $insumo->id }})" style="cursor: pointer;">
                                                {{ $insumo->estado == 1 ? 'Activo' : 'Inactivo' }}
                                                <i class="fas fa-toggle-{{ $insumo->estado == 1 ? 'on' : 'off' }}"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-sm btn-warning" href="{{ route('Admin.insumo.edit', ['id' => $insumo->id]) }}">
                                                    <i class="fa fa-fw fa-edit"></i>    
                                                </a>
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
            text: "No se puede eliminar un insumo activo.",
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