@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 mt-4">
            <div class="card">
                <div class="card-header" style="background-color: #FFB6C1;">{{ __('Arreglo personalizado') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Botones para abrir los modales -->
                    <div class="d-flex justify-content-between mb-4">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#florModal">
                            Agregar Flores
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accesoriosModal">
                            Agregar Accesorios
                        </button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#comestiblesModal">
                            Agregar Comestibles
                        </button>
                    </div>

                    <!-- Mostrar flores seleccionadas -->
                    <div class="card mt-4">
                        <div class="card-header text-black" style="background-color: #FFB6C1;">Flores seleccionadas:</div>
                        <div class="card-body">
                            @if(session('floresSeleccionadas'))
                                <ul class="list-group">
                                    @foreach(session('floresSeleccionadas') as $key => $i)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $i['nombre'] }} - Cantidad: {{ $i['cantidad'] }}
                                            <div>
                                                <form action="{{ route('actualizarFlor', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrementar" class="btn btn-outline-success btn-sm">-</button>
                                                    <button type="submit" name="action" value="incrementar" class="btn btn-outline-success btn-sm">+</button>
                                                </form>
                                                <form action="{{ route('eliminarFlor', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No hay flores seleccionadas</p>
                            @endif
                        </div>
                    </div>

                    <!-- Mostrar accesorios seleccionados -->
                    <div class="card mt-4">
                        <div class="card-header text-black" style="background-color: #FFB6C1;">Accesorios seleccionados:</div>
                        <div class="card-body">
                            @if(session('accesoriosSeleccionados'))
                                <ul class="list-group">
                                    @foreach(session('accesoriosSeleccionados') as $key => $i)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $i['nombre'] }} - Cantidad: {{ $i['cantidad'] }}
                                            <div>
                                                <form action="{{ route('actualizarAccesorio', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrementar" class="btn btn-outline-success btn-sm">-</button>
                                                    <button type="submit" name="action" value="incrementar" class="btn btn-outline-success btn-sm">+</button>
                                                </form>
                                                <form action="{{ route('eliminarAccesorio', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No hay accesorios seleccionados</p>
                            @endif
                        </div>
                    </div>

                    <!-- Mostrar comestibles seleccionados -->
                    <div class="card mt-4">
                        <div class="card-header text-black" style="background-color: #FFB6C1;">Comestibles seleccionados:</div>
                        <div class="card-body">
                            @if(session('comestiblesSeleccionados'))
                                <ul class="list-group">
                                    @foreach(session('comestiblesSeleccionados') as $key => $i)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $i['nombre'] }} - Cantidad: {{ $i['cantidad'] }}
                                            <div>
                                                <form action="{{ route('actualizarComestible', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrementar" class="btn btn-outline-success btn-sm">-</button>
                                                    <button type="submit" name="action" value="incrementar" class="btn btn-outline-success btn-sm">+</button>
                                                </form>
                                                <form action="{{ route('eliminarComestible', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No hay comestibles seleccionados</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header bg-dark text-white">Total:</div>
                        <div class="card-body">
                            <p>Total: ${{ number_format($totalPrecio, 0) }}</p>
                            <form action="{{ route('add_personalizado') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark w-100">Agregar Arreglo Personalizado al carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- poppap flores -->
<div class="modal fade" id="florModal" tabindex="-1" aria-labelledby="florModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="florModalLabel">Seleccionar Flor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('agregarFlor') }}" method="POST">
                    @csrf
                    <!-- Seleccionar flor directamente -->
                    <label for="flor">Selecciona la flor:</label>
                    <select id="flor" name="flor_id" class="form-select">
                        <option value="">Selecciona una flor</option>
                        @foreach($flores as $flor)
                            <option value="{{ $flor->id }}">{{ $flor->nombre }}</option>
                        @endforeach
                    </select>

                    <!-- Seleccionar color -->
                    <label for="color" class="mt-3">Selecciona el color:</label>
                    <select id="color" name="color" class="form-select">
                        <option value="">Selecciona una color</option>
                        <option value="Blanco">Blanco</option>
                        <option value="Rojo">Rojo</option>
                        <option value="Amarillo">Amarillo</option>
                        <option value="Morado">Morado</option>
                    </select>

                    <label for="cantidad" class="mt-3">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" value="1">

                    <button type="submit" class="btn btn-primary mt-3">Agregar Flor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- poppap accesorios -->
<div class="modal fade" id="accesoriosModal" tabindex="-1" aria-labelledby="accesoriosModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accesoriosModalLabel">Seleccionar Accesorios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('agregarAccesorio') }}" method="POST">
                    @csrf
                    <label for="accesorio">Accesorio:</label>
                    <select id="accesorio" name="accesorio_id" class="form-select">
                        <option value="">Selecciona un accesorio</option>
                        @foreach($accesorios as $accesorio)
                            <option value="{{ $accesorio->id }}">{{ $accesorio->nombre }}</option>
                        @endforeach
                    </select>

                    <label for="cantidadAccesorio" class="mt-3">Cantidad:</label>
                    <input type="number" id="cantidadAccesorio" name="cantidad" class="form-control" min="1" value="1">

                    <button type="submit" class="btn btn-primary mt-3">Agregar Accesorio</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- poppap comestibles -->
<div class="modal fade" id="comestiblesModal" tabindex="-1" aria-labelledby="comestiblesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comestiblesModalLabel">Seleccionar Comestibles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('agregarComestible') }}" method="POST">
                    @csrf
                    <label for="comestible">Comestible:</label>
                    <select id="comestible" name="comestible_id" class="form-select">
                        <option value="">Selecciona un comestible</option>
                        @foreach($comestibles as $comestible)
                            <option value="{{ $comestible->id }}">{{ $comestible->nombre }}</option>
                        @endforeach
                    </select>

                    <label for="cantidadComestible" class="mt-3">Cantidad:</label>
                    <input type="number" id="cantidadComestible" name="cantidad" class="form-control" min="1" value="1">

                    <button type="submit" class="btn btn-primary mt-3">Agregar Comestible</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
