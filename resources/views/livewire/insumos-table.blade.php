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
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
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
                                        @else
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
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
                                        Cantidad Insumo
                                    </th>
                                    <th scope="col" class="text-center">
                                        Costo Unitario
                                    </th>
                                    <th scope="col" class="text-center">
                                        Perdida Insumo
                                    </th>
                                    <th scope="col" class="text-center">
                                        Costo Perdida
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
                                    <th scope="col" class="text-center">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                    


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <!-- <thead class="thead">
                                    <tr>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Categoria insumo</th>
                                        <th scope="col" class="text-center">Nombre</th>
                                        <th scope="col" class="text-center">Cantidad insumo</th>
                                        <th scope="col" class="text-center">Costo unitario</th>
                                        <th scope="col" class="text-center">Perdida insumo</th>
                                        <th scope="col" class="text-center">Costo Perdida</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                        <th scope="col" class="text-center">Estado</th>
                                        
                                    </tr>
                                </thead> -->
                                <tbody>
                                    @foreach($insumos as $insumo)
                                        <tr>
                                            <td class="text-center">{{ ($insumos->currentPage() - 1) * $insumos->perPage() + $loop->iteration }}</td>
                                            <td class="text-center">{{ $insumo->categoria_insumo->nombre }}</td>
                                            <td class="text-center">{{ $insumo->nombre }}</td>
                                            <td class="text-center">{{ $insumo->cantidad_insumo }}</td>
                                            <td class="text-center">{{ number_format($insumo->costo_unitario, 0, ',', '.') }}</td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="small button group">
                                                <td class="text-center">
                                                    <a href="{{ route('incrementarInsumo', ['id' => $insumo->id]) }}" class="btn btn-success efecto">+</a> 
                                                    {{ $insumo->perdida_insumo }} 
                                                    <a href="{{ route('decrementarInsumo', ['id' => $insumo->id]) }}" class="btn btn-danger efecto">-</a> 
                                                </td>
                                            </div>
                                            <td class="text-center">{{ number_format($insumo->costo_perdida, 0, ',', '.')}}</td>
                                            <td class="text-center">
                                                <form action="{{ route('Admin.insumo.destroy', ['id' => $insumo->id]) }}" method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('Admin.insumo.edit', ['id' => $insumo->id]) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                    </button>
                                                </form>
                                            </td>
                                            <!-- <td>
                                                <a class="btn btn-sm {{ $insumo->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                                href="{{ route('Admin.insumo.status', $insumo->id) }}">
                                                {{ $insumo->estado == 1 ? 'Activo' : 'Inactivo' }}
                                                <i class="fa fa-fw fa-sync"></i>
                                                </a>
                                            </td> -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .centrar-formulario {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>