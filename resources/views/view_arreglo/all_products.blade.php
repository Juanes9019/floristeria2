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
                <div class="card-header">{{ __('Arreglos florales') }}</div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($productos->chunk(3) as $chunk)
                            @foreach ($chunk as $producto)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ $producto->foto }}" class="card-img-top img-fluid" alt="{{ $producto->nombre }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                                            <p class="card-title"><strong>Categoria:</strong> {{ $producto->categoria->nombre }}</p>
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
                    <div class="mt-3">
                        <div class="card-header text-center">{{ __('Categoria de productos') }}</div>
                        <div class="card-body">
                            @foreach($categoria_categoria as $categoria)
                            <span class="btn btn-primary mt-2">
                                {{ $categoria->nombre }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <label class="alert-danger" id="lblError"></label>
                </div>
            </div>
            <div class="card flex-grow-1 mb-3"> 
                <div class="card-header text-center">{{ __('filtros de busqueda') }}</div>
                <div>
                    <span class="btn btn-primary d-block mb-2 ">Más caro</span>
                    <span class="btn btn-primary d-block mb-2 ">Más barato</span>
                    <span class="btn btn-primary d-block mb-2 ">Nuevos</span>
                    <span class="btn btn-primary d-block mb-2 ">Viejos</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
