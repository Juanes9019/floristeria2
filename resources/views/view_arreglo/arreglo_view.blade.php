@extends('layouts.app')

@section('content')

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session('success') }}',
        position: 'top-end',
        toast: true,
        showConfirmButton: false,
        timer: 5000
    });
</script>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header titulo_carta" style="background-color: #facfd6; font-size: 17px;">{{ __('Información del arreglo floral') }}</div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <img src="{{ $productos->foto }}" class="card-img-top img-fluid" alt="{{ $productos->nombre }}">
                        </div>

                        <div class="col-md-6 order-md-2">
                            <h2 class="titulo_carta">{{ $productos->nombre }}</h2>
                            <div class="chips">
                                <p class="text_page"><strong>Categoría:</strong> {{ $productos->categoria_producto->nombre }}</p>
                                <p class="text_page"><strong>Descripción:</strong> {{ $productos->descripcion }}</p>
                                <p class="text_page"><strong>Detalles:</strong></p>
                                <ul class="lista-sin-estilo">
                                    @foreach ($productos->insumos as $insumo)
                                        <li>
                                            {{ $insumo->nombre }} {{ $insumo->color }} - Cantidad usada: {{ $insumo->pivot->cantidad_usada }}
                                        </li>
                                    @endforeach
                                </ul>
                                
                                <div class="action-buttons my-1">
                                    <a> Precio: {{ number_format($productos->precio, 0) }} </a>
                                </div>
                            </div>       
                        </div>
                    </div>

                    <form action="{{ route('add') }}" method="get">
                        @csrf
                        <div class="action-buttons1">
                            <input type="hidden" name="id" value="{{ $productos->id }}">

                            <a href="{{ route('home') }}">
                                <i class="fas fa-reply"></i>&nbsp;Seguir comprando
                            </a>
                            <button type="submit" name="btn" id="btn" class="btn btn-dark w-100">
                                <i class="fas fa-shopping-cart"></i>&nbsp;Agregar al carrito
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        margin-top: 3rem;
    }

    .action-buttons1 a {
        text-decoration: none;    
    }

    .lista-sin-estilo {
        list-style: none; /* Elimina la viñeta o punto de la lista */
        font-family: "Zain", sans-serif;
        font-size: 18px;
    }
</style>

@endsection
