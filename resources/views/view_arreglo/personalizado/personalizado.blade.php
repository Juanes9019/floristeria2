@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">

<div class="card-body">
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
</div>

<div class="container custom-border-shadow" style="width: 90%; max-width: 1300px;">
    <div class="row justify-content-center">
        <section class="timeline">
            <div class="container">
                <div id="carouselExampleCaptions" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" aria-current="true" aria-label="Slide 1" class="active">
                            <h5>Paso 1</h5>
                            <i class="fa-solid fa-sort"></i>                        
                        </button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2">
                            <h5>Paso 2</h5>
                            <i class="fa-solid fa-box"></i>
                        </button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3">
                            <h5>Paso 3</h5>
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4">
                            <h5>Paso 4</h5>
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <div class="experience-slide-one row h-100 align-items-center">
                                <div class="col-md-6">
                                    <p class="alert alert-primary text-dark">En esta opción, puedes diseñar un arreglo personalizado desde cero, eligiendo entre una amplia variedad de flores y productos disponibles.</p>
                                    <div class="d-flex justify-content-center mb-4">
                                        <form method="GET" action="{{ route('personalizados') }}">
                                            <input type="hidden" name="section" value="1">
                                            <button type="submit" class="btn btn-outline-info"><i class="fas fa-box-open"></i> Personalizar arreglo</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="alert alert-primary text-dark">En esta opción, puedes crear un arreglo personalizado basado en uno ya establecido. Tendrás la opción de cambiar las flores o agregar más elementos.</p>
                                    <div class="d-flex justify-content-center mb-4">
                                        <form method="GET" action="{{ route('personalizados') }}">
                                            <input type="hidden" name="section" value="2">
                                            <button type="submit" class="btn btn-outline-info"><i class="fas fa-edit"></i> Personalizar producto predeterminado</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="experience-slide-one row h-100 align-items-center justify-content-center">
                                <div class="col-md-8">
                                    <div class="experience-slide-img text-center"> 
                                        @if ($section == '1')
                                            @include('view_arreglo.personalizado.cero')
                                        @elseif ($section == '2')
                                            @include('view_arreglo.personalizado.estandar')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item"> 
                            <div class="experience-slide-one row h-100 align-items-center justify-content-center">
                                <div class="col-md-8">
                                    <div class="experience-slide-text">
                                            <div class="card mt-4 shadow-sm">
                                                <div class="card-header text-black text-center" style="background-color: #FFB6C1;">
                                                    Productos seleccionados:
                                                </div>
                                                <div class="card-body bg-light">
                                                    @if(session('insumosSeleccionados'))
                                                        <ul class="list-group">
                                                            @foreach(session('insumosSeleccionados') as $key => $personalizado)
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <strong>{{ $personalizado['nombre'] }}</strong> - Cantidad: {{ $personalizado['cantidad'] }}
                                                                    </div>
                                                                    <div class="btn-group" role="group">
                                                                        <form action="{{ route('actualizar_producto', $key) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button type="submit" name="action" value="incrementar" class="btn btn-outline-primary btn-sm">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                            <button type="submit" name="action" value="decrementar" class="btn btn-outline-primary btn-sm">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>
                                                                        </form>
                                                                        <form action="{{ route('eliminar_producto', $key) }}" method="POST" class="d-inline ml-1">
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
                                                        <p class="text-center mb-0">No hay productos seleccionados.</p>
                                                    @endif
                                                </div>
                                            </div>
                            
                                            <div class="card mt-4 shadow-sm">
                                                <div class="card-header text-black text-center" style="background-color: #FFB6C1;">
                                                    Productos seleccionados:
                                                </div>
                                                <div class="card-body bg-light">
                                                    @if(session('insumosPersonalizados'))
                                                        <ul class="list-group">
                                                            @foreach(session('insumosPersonalizados') as $key => $personalizado)
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <strong>{{ $personalizado['nombre_producto'] }} - Insumo: {{ $personalizado['nombre_insumo'] }}</strong> - Cantidad: {{ $personalizado['cantidad'] }}
                                                                    </div>
                                                                    <div class="btn-group" role="group">
                                                                        <form action="{{ route('actualizar_producto', $key) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button type="submit" name="action" value="incrementar" class="btn btn-outline-primary btn-sm">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                            <button type="submit" name="action" value="decrementar" class="btn btn-outline-primary btn-sm">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>
                                                                        </form>
                                                                        <form action="{{ route('eliminar_producto', $key) }}" method="POST" class="d-inline ml-1">
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
                                                        <p class="text-center mb-0">No hay productos personalizados seleccionados.</p>
                                                    @endif
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="experience-slide-one row h-100 align-items-center">
                                <div class="col-md-5">
                                    <div class="experience-slide-img">
                                        <img src="{{ 'https://i.imgur.com/ia1BeKH.png' }}" alt="imagen no disponible" width="100">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="experience-slide-text">
                                        <h3>junio</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Botones de navegación -->
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn btn-outline-secondary ml-5" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <i class="fas fa-chevron-left"></i> Anterior
                        </button>
                        <button class="btn btn-outline-secondary mr-5" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            Siguiente <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
