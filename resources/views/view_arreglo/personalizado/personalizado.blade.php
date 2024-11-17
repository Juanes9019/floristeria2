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
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                    <div class="carousel-inner">

                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center align-items-center min-vh-10">
                            <div class="col-md-6">
                                <p class="alert alert-primary text-dark text-center">
                                    En esta opción, puedes diseñar un arreglo personalizado desde cero, eligiendo entre una amplia variedad de flores y productos disponibles.
                                </p>
                            </div>
                        </div>
                    </div>


                        <div class="carousel-item">
                            <div class="experience-slide-one row h-100 align-items-center justify-content-center">
                                <div class="col-md-9">
                                    <div class="experience-slide-img text-center"> 
                                        @include('view_arreglo.personalizado.cero')
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item"> 
                            <div class="experience-slide-one row h-100 align-items-center justify-content-center">
                                <div class="col-md-8">
                                    <div class="experience-slide-text">
                                            <div class="card mt-4 shadow-sm">
                                                <div class="card-header text-black text-center" style="background-color: #FFB6C1;">Productos seleccionados:</div>
                                                <div class="card-body bg-light">
                                                    @if(session('insumosSeleccionados'))
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Nombre</th>
                                                                    <th class="text-center">Cantidad</th>
                                                                    <th class="text-center">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach(session('insumosSeleccionados') as $key => $personalizado)
                                                                <tr>
                                                                    <td class="text-center">{{ $personalizado['nombre'] }}</td>
                                                                    <td class="text-center">{{ $personalizado['cantidad'] }}</td>
                                                                    <td class="text-center">
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
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <!-- Total -->
                                                        <div class="card mt-4">
                                                            <div class="card-header bg-dark text-white">Total:</div>
                                                            <div class="card-body">
                                                                <p>Total: ${{ number_format($totalPrecio, 0) }}</p>
                                                                <div class="d-flex justify-content-center">
                                                                    <form action="{{ route('add_personalizado') }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="btn custom-btn d-flex align-items-center justify-content-center text-white">
                                                                            <i class="fas fa-cart-plus me-2"></i> Agregar al carrito
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p class="text-center mb-0">No hay productos seleccionados.</p>
                                                    @endif
                                                </div>
                                            </div>
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
