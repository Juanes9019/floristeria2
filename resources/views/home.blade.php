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


<main class="main-content bg-gray-100 dark:bg-gray-800 p-6">
    <section class="container container-factures mb-8">
        <div class="card-feature flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-md">
            <i class="fas fa-truck text-2xl text-orange-400"></i>
            <div class="feature-content ml-4">
                <span class="block text-lg font-semibold dark:text-white">Envío gratuito</span>
                <p class="text_page text-gray-600 dark:text-gray-300">Envíos gratuitos en el sector de Girardota.</p>
            </div>
        </div>
    </section>

    <section class="container container-factures mb-8">
        <div class="card-feature flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-md">
            <i class="fas fa-gift text-2xl text-pink-500"></i>
            <div class="feature-content ml-4">
                <span class="block text-lg font-semibold dark:text-white">Arreglos florales</span>
                <p class="text_page text-gray-600 dark:text-gray-300">Regala hermosos arreglos florales.</p>
            </div>
        </div>
    </section>

    <section class="container container-factures mb-8">
        <div class="card-feature flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-md">
            <i class="fas fa-credit-card text-2xl text-orange-400"></i>
            <div class="feature-content ml-4">
                <span class="block text-lg font-semibold dark:text-white">Métodos de pago</span>
                <p class="text_page text-gray-600 dark:text-gray-300">Contamos con diferentes métodos de pago.</p>
            </div>
        </div>
    </section>

    <section class="container container-factures mb-8">
        <div class="card-feature flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-md">
            <i class="fas fa-headset text-2xl text-blue-500"></i>
            <div class="feature-content ml-4">
                <span class="block text-lg font-semibold dark:text-white">Servicio al cliente 24/7</span>
                <p class="text_page text-gray-600 dark:text-gray-300">Número 999-888-7777.</p>
            </div>
        </div>
    </section>
</main>

<section class="container top-products">
    
    <h1 class="heading-1 titulo_carta text-2xl font-bold mb-6 dark:text-white">Sección de Productos</h1>

    <div class="container-options">
        <a href="{{route('all_products')}}"><span>Todos los productos</span></a>
        <a href="{{route('personalizados')}}"><span>Arreglos personalizados</span></a>
    </div>

    <div id="productosCarrusel" class="carousel slide" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner">
            @foreach ($productos->chunk(4) as $chunkIndex => $chunk)
            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                <div class="row">
                    @foreach ($chunk as $producto)
                    <div class="col-md-3 mb-4">
                        <div class="card-wrapper fondo_card" style="padding-top: 20px;">
                            <div class="card h-100 card_view" style="border-top-left-radius: 45px; border-top-right-radius: 45px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                                <h5 class="card-title text-center titulo_carta">{{ $producto->nombre }}</h5>
                                <p class="card-title text-center text_page"><strong>Categoria:</strong> {{ $producto->categoria_producto->nombre }}</p>
                                <img src="{{ $producto->foto }}" class="card-img-top img-fluid" style="border-radius: 15px;;" alt="{{ $producto->nombre }}">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text text-left text_price mb-0">
                                            <strong>Precio:</strong> ${{ number_format($producto->precio, 0, ',', '.') }}
                                        </p>
                                        <a href="{{ route('add', ['id' => $producto->id]) }}" class="fondo_carrito d-flex justify-content-center align-items-center">
                                            <i class="fas fa-shopping-cart icono_cart_home" ></i>
                                        </a>
                                    </div>
                                    <div class="contenedor mt-2">
                                        <a href="{{ route('view_arreglo.arreglo_view', ['id' => $producto->id]) }}" class="btn btn-5">Ver más</a>
                                    </div>
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
            <p class="text_page">Desarrollado por floristeria la tata &copy; 2024</p>
        </div>
    </div>
</footer>


@endsection