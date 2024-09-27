@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 mt-4">
            <div class="card">
                <div class="card-header text-black" style="background-color: #FFB6C1;">{{ __('Generar Producto') }}</div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <!-- Filtrar insumos por categoría -->
                    <form method="GET" action="{{ route('admin.generar_producto.index') }}" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Filtrar por Categoría de Insumos:</label>
                            <select id="categoria_id" name="categoria_id" class="form-select" onchange="this.form.submit()">
                                <option value="">Selecciona una categoría</option>
                                @foreach($categorias_insumos as $categoria_insumo)
                                    <option value="{{ $categoria_insumo->id }}" {{ $categoriaId == $categoria_insumo->id ? 'selected' : '' }}>
                                        {{ $categoria_insumo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <label for="insumo">Selecciona el insumo:</label>
                            <select id="insumo" name="insumo_id" class="form-select">
                            <option value="">Selecciona un Insumo</option>
                                @foreach($insumosFiltrados as $insumo)
                                    <option value="{{ $insumo->id }}">{{ $insumo->nombre }} - Disponibles: {{ $insumo->cantidad }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Botón para abrir el modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insumosModal">
                        Agregar Insumo
                    </button>

                    <!-- Modal para agregar insumos -->
                    <div class="modal fade" id="insumosModal" tabindex="-1" aria-labelledby="insumosModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="insumosModalLabel">Seleccionar Insumos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if(!empty($insumosFiltrados))
                                    <form action="{{ route('admin.agregarInsumo') }}" method="POST">
                                        @csrf
                                        <label for="modal_insumo">Selecciona el insumo:</label>
                                        <select id="modal_insumo" name="insumo_id" class="form-select">
                                            @foreach($insumosFiltrados as $insumo)
                                                <option value="{{ $insumo->id }}">{{ $insumo->nombre }} - Disponibles: {{ $insumo->cantidad }}</option>
                                            @endforeach
                                        </select>

                                        <label for="cantidad" class="mt-3">Cantidad:</label>
                                        <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" value="1" required>

                                        <button type="submit" class="btn btn-primary mt-3">Agregar Insumo</button>
                                    </form>
                                    @else
                                        <p>No hay insumos disponibles en esta categoría.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mostrar insumos seleccionados -->
                    <div class="card mt-4">
                        <div class="card-header text-black" style="background-color: #FFB6C1;">Insumos seleccionados:</div>
                        <div class="card-body">
                            @if(session('insumosSeleccionados') && count(session('insumosSeleccionados')) > 0)
                                <ul class="list-group">
                                    @foreach(session('insumosSeleccionados') as $key => $i)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $i['nombre'] }}</strong> - Cantidad: {{ $i['cantidad'] }}
                                            </div>
                                            <div class="btn-group" role="group" aria-label="Acciones">
                                                <form action="{{ route('admin.actualizarInsumo', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrementar" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <button type="submit" name="action" value="incrementar" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.eliminarInsumo', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
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
            </div>
        </div>
    </div>
</div>

@endsection
