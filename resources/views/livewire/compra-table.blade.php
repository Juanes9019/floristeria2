<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class=" container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de Compras</b>
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
                            <a href="{{ route('Admin.compra.create') }}" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th scope="col" class="text-center" wire:click="sortBy('created_at')">
                                        Fecha de Compra
                                        @if ($ordenarColumna === 'created_at')
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

                                    <th scope="col" class="text-center" wire:click="sortBy('proveedor_id')">
                                        Proveedor
                                        @if ($ordenarColumna === 'proveedor_id')
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

                                    <th scope="col" class="text-center" wire:click="sortBy('costo_total')">
                                        Costo Total
                                        @if ($ordenarColumna === 'costo_total')
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
                                    <th scope="col" class="text-center">Estado</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($compras as $compra)
                                    <tr>
                                        <!-- <td class="text-center">{{ ($compras->currentPage() - 1) * $compras->perPage() + $loop->iteration }}</td> -->
                                        <td class="text-center">{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">{{ $compra->proveedor->nombre }}</td>
                                        <td class="text-center">${{ number_format($compra->costo_total, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $compra->estado }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('compra.detalles', $compra->id) }}" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                            </svg></a>
                                        </td>
                                        <td >
                                            <form id="form_eliminar_{{$compra->id}}" action="{{ route('Admin.compra.destroy', $compra->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="boton_anular" onclick="eliminar('{{$compra->id}}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>                                                
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function eliminar(compraId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'No podrás revertir esta acción',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Anular',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form_eliminar_' + compraId).submit();
        }
    });
}


</script>

