@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/boton.css') }}">


<div class="container-fluid full-height mt-4">
    <div class="row justify-content-center full-height g-3"> 
        <div class="col-md-8 full-height">
            <div class="card h-100">
                @if(session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-header" style="background-color: #FFB6C1;">{{ __('Arreglos florales') }}</div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($productos->chunk(3) as $chunk)
                            @foreach ($chunk as $producto)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ $producto->foto }}" class="card-img-top img-fluid" alt="{{ $producto->nombre }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                                            <p class="card-title"><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
                                            <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto->precio, 0, ',', '.') }}</p>
                                            <div class="contenedor">
                                                <a href="{{ route('view_arreglo.arreglo_view', ['id' => $producto->id]) }}" class="btn btn-5">Ver más</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 full-height d-flex flex-column">
            <div class="card mb-3 flex-grow-4 text-center">
                    <div class="card-body">
                        <div>
                            <div class="card-header text-center" style="background-color: #FFB6C1; padding-top: 5px; padding-bottom: 5px; margin-top: -10px;">
                                {{ __('Categoría de productos') }}
                            </div>
                            <div class="card-body d-flex flex-wrap justify-content-center mt-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                                @foreach($categoria_categoria as $categoria)
                                <a href="{{ route('all_products', ['categoria' => $categoria->id, 'filtro' => request()->input('filtro')]) }}" class="botones_filtro">
                                    {{ $categoria->nombre }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="alert-danger" id="lblError"></label>
                        </div>
                    </div>
                </div>
                <div class="card flex-grow-1 mb-3">
                    <div class="card-header text-center" style="background-color: #FFB6C1;">{{ __('Filtros de búsqueda') }}</div>
                        <form action="all_products" method="get">
                            <div class="container_buscar mt-3 mb-3"> 
                                <input type="text" name="query" placeholder="Buscar productos..." value="{{ request()->input('query') }}">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    <div class="card-body">
                        <a href="{{ route('all_products', ['filtro' => 'todos', 'categoria' => request()->input('categoria')]) }}" class="botones_filtro">Todos los productos</a>
                        <a href="{{ route('all_products', ['filtro' => 'caro', 'categoria' => request()->input('categoria')]) }}" class="botones_filtro">Productos más caro</a>
                        <a href="{{ route('all_products', ['filtro' => 'barato', 'categoria' => request()->input('categoria')]) }}" class="botones_filtro">Productos más barato</a>
                        <a href="{{ route('all_products', ['filtro' => 'nuevos', 'categoria' => request()->input('categoria')]) }}" class="botones_filtro">Productos nuevos</a>
                        <a href="{{ route('all_products', ['filtro' => 'antiguos', 'categoria' => request()->input('categoria')]) }}" class="botones_filtro">Productos Antiguos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
