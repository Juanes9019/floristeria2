@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/boton.css') }}">

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

<section class="banner">
    <div class="content-banner">
        <p>¡Descubre la belleza natural!</p>
        <h2>Variedad de flores frescas <br>arreglos únicos</h2>
        <a href="{{route('all_products')}}">Explorar ahora</a>
    </div>
</section>


<main class="main-content">
    <section class="container container-factures">
        <div class="card-feature">
            <i class="fas fa-truck" style="color: #FFB083;"></i>
            <div class="feature-content">
                <span>Envío gratuito</span>
                <p>Envios gratuitos en el sector de girardota.</p>
            </div>
        </div>
    </section>

    <section class="container container-factures">
        <div class="card-feature">
            <i class="fas fa-gift"></i>
            <div class="feature-content">
                <span>Arreglos florales</span>
                <p>Regala hermosos arreglos florales.</p>
            </div>
        </div>
    </section>

    <section class="container container-factures">
        <div class="card-feature">
            <i class="fas fa-credit-card" style="color: #FFB083;"></i>
            <div class="feature-content">
                <span>Métodos de pago</span>
                <p>Contamos con diferentes métodos de pago.</p>
            </div>
        </div>
    </section>

    <section class="container container-factures">
        <div class="card-feature">
            <i class="fas fa-headset"></i>
            <div class="feature-content">
                <span>Servicio al cliente 24/7</span>
                <p>Número 999-888-7777.</p>
            </div>
        </div>
    </section>
</main>

<section class="container top-products">
    <h1 class="heading-1">Sección de Productos</h1>

    <div class="container-options">
        <a href="{{route('all_products')}}"><span>Todos los productos</span></a>
    </div>

    <div id="productosCarrusel" class="carousel slide" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner">
            @foreach ($productos->chunk(4) as $chunkIndex => $chunk)
            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                <div class="row">
                    @foreach ($chunk as $producto)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ $producto->foto }}" class="card-img-top img-fluid" alt="{{ $producto->nombre }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $producto->nombre }}</h5>
                                <p class="card-title"><strong>Categoria:</strong> {{ $producto->categoria_producto->nombre }}</p>
                                <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto->precio, 0, ',', '.') }}</p>
                                <div class="contenedor">
                                    <a href="{{ route('view_arreglo.arreglo_view', ['id' => $producto->id]) }}" class="btn btn-5">Ver más</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#productosCarrusel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#productosCarrusel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>
</section>


<section class="gallery">
    <img src="https://i.imgur.com/xiE1vvO.jpeg" alt="galleria" class="galeria-img-1">
    <img src="https://i.imgur.com/bKFwdmR.jpeg" alt="galleria" class="galeria-img-2">
    <img src="https://i.imgur.com/Z27yfOo.jpeg" alt="galleria" class="galeria-img-3">
    <img src="https://i.imgur.com/H8CfmCq.jpeg" alt="galleria" class="galeria-img-4">
    <img src="https://i.imgur.com/r93OXMW.jpeg" alt="galleria" class="galeria-img-5">
</section>

<footer class="footer">
    <div class="container container-footer">
        <div class="menu-footer">
            <div class="contact-info">
                <p class="title-footer">Información de contacto</p>
                <ul>
                    <li>Direccion: cr4 #51-34</li>
                    <li>Telefono: 999-999-9999</li>
                    <li>Correo: latata@gmail.com</li>
                </ul>

                <div class="social-icons">
                    <a href="#"><span class="facebook"><i class="fab fa-facebook-f"></i></span></a>
                    <a href="#"><span class="instagram"><i class="fab fa-instagram"></i></span></a>
                    <a href="#"><span class="twitter"><i class="fab fa-twitter"></i></span></a>
                    <a href="#"><span class="whatsapp"><i class="fab fa-whatsapp"></i></span></a>
                </div>
            </div>


            <div class="information">
                <p class="title-footer">Información</p>
                <ul>
                    <li><a href="#">Acerca de nosotros</a></li>
                    <li><a href="#">Politicas de privacidad</a></li>
                    <li><a href="#">Terminos y condiciones</a></li>
                    <li><a href="#">Contactanos</a></li>
                </ul>
            </div>

            <div class="my-account">
                <p class="title-footer">Mi cuenta</p>
                <ul>
                    <li><a href="{{ route('perfilUser') }}">Mi cuenta</a></li>
                    <li><a href="{{ route('perfilUser')}}">Historial de pedidos</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p>Desarrollado por floristeria la tata &copy; 2024</p>
        </div>
    </div>
</footer>


@endsection