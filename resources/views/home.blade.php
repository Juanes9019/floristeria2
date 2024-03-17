@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<section></section>
<header class="header">
    <div class="overlay">
        <h1 class="titulo_banner">¡Bienvenidos a Floristería La Tata!</h1>
        <p>En nuestra floristería, nos enorgullece ofrecerte una amplia gama de servicios para satisfacer tus necesidades florales en la ciudad de Medellín y sus alrededores. Te garantizamos una experiencia floral excepcional en cada pedido.</p>
        <p>Realizamos envíos a toda Medellín, el envio sera gratis para el serctor de giradot</p>
        <p><strong>¡Confía en nosotros para ser tu floristería de confianza en Medellín!</strong></p>
    </div>
    <img src="{{ Storage::url('productos/fondo_flores.jpg') }}" alt="fondo imagen" class="full-width">

</header>
<section></section>

<h1 id="titulo_inicio">Regala un Momento Inolvidable</h1>

<div class="container">
    <div class="row">
        @foreach ($productos as $producto)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/' . $producto->foto) }}" class="card-img-top img-fluid" alt="{{ $producto->nombre }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                    <p class="card-text">Precio: {{ $producto->precio }}</p>
                    <p class="card-text">Cantidad disponible: {{ $producto->cantidad }}</p>
                    <a href=" {{ route('view_arreglo.arreglo_view', ['id' => $producto->id]) }}" class="btn btn-outline-dark custom-btn-pink">Ver arreglo</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
