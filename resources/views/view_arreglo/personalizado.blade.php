@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 mt-4">
            <div class="card">
            <div class="card-header text-black" style="background-color: #FFB6C1;">{{ __('Arreglo personalizado') }}</div>
                <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                    <!-- Botones para abrir los modales -->
                    <div class="d-flex justify-content-between mb-4">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#florModal">
                            <i class="fas fa-seedling"></i> Agregar Flores
                        </button>
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#accesoriosModal">
                            <i class="fas fa-gift"></i> Agregar Accesorios
                        </button>
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#comestiblesModal">
                            <i class="fas fa-apple-alt"></i> Agregar Comestibles
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
                                            <div>
                                                <strong>{{ $i['nombre'] }}</strong> - Cantidad: {{ $i['cantidad'] }}
                                            </div>
                                            <div class="btn-group" role="group" aria-label="Acciones">
                                            <div class="me-2">
                                                <form action="{{ route('actualizarFlor', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrementar" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <button type="submit" name="action" value="incrementar" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                                <form action="{{ route('eliminarFlor', $key) }}" method="POST" style="display: inline;">
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
                                            <div>
                                                <strong>{{ $i['nombre'] }}</strong> - Cantidad: {{ $i['cantidad'] }}
                                            </div>                                            <div>
                                                <form action="{{ route('actualizarAccesorio', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrementar" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <button type="submit" name="action" value="incrementar" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('eliminarAccesorio', $key) }}" method="POST" style="display: inline;">
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
                                            <div>
                                                <strong>{{ $i['nombre'] }}</strong> - Cantidad: {{ $i['cantidad'] }}
                                            </div>                                            <div>
                                                <form action="{{ route('actualizarComestible', $key) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrementar" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <button type="submit" name="action" value="incrementar" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('eliminarComestible', $key) }}" method="POST" style="display: inline;">
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
                                <p>No hay comestibles seleccionados</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header bg-dark text-white">Total:</div>
                        <div class="card-body">
                            <p>Total: ${{ number_format($totalPrecio, 0) }}</p>
                            <div class="d-flex justify-content-center">
                                <form action="{{ route('add_personalizado') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn custom-btn d-flex align-items-center justify-content-center text-white"><i class="fas fa-cart-plus me-2"></i>Agregar Arreglo Personalizado al carrito</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- poppap flores -->
<div class="modal fade" id="florModal" tabindex="-1" aria-labelledby="florModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="florModalLabel">Seleccionar Flor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('agregarFlor') }}" method="POST">
                            @csrf
                            <label for="flor">Selecciona la flor:</label>
                            <select id="flor" name="flor_id" class="form-select">
                                <option value="">Selecciona una flor</option>
                                @foreach($flores as $flor)
                                    <option value="{{ $flor->id }}" data-colores='@json($flor->colores)'>{{ $flor->nombre }}</option>
                                @endforeach
                            </select>

                            <label for="color" class="mt-3">Selecciona el color:</label>
                            <select id="color" name="color" class="form-select">
                                <option value="">Selecciona un color</option>
                            </select>

                            <label for="cantidad" class="mt-3">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" value="1">

                            <button type="submit" class="btn btn-primary mt-3">Agregar Flor</button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <div id="imagen-flor-container" class="text-center div_tamaño">
                            <img id="imagen-flor" src="ruta/default.jpg" alt="Imagen de la flor" style="max-width: 100%; display: block;">
                        </div>
                        <div id="descripcion-flor" class="mt-3">
                            <p>por favor selecciona una flor y un color, para mostrar la imagen</p>
                        </div>
                    </div>
                </div> 
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
<style>
    .div_tamaño {
        width: 70%; 
        margin: 0 auto; 
    }
</style>
@endsection
