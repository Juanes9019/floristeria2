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

<section class="banner">
    <div class="content-banner">
        <p>¡Descubre la belleza natural!</p>
        <h2>Variedad de flores frescas <br>arreglos únicos</h2>
    </div>
</section>


<main class="main-content bg-gray-100 dark:bg-gray-800 p-6">
    <section class="container container-factures mb-8">
        <div class="card-feature flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-md">
            <i class="fas fa-truck text-2xl text-orange-400"></i>
            <div class="feature-content ml-4">
                <span class="block text-lg font-semibold dark:text-white">Envío gratuito</span>
                <p class="text_page text-gray-600 dark:text-gray-300">Envíos gratuitos a de Girardota.</p>
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
                <p class="text_page text-gray-600 dark:text-gray-300">Diferentes métodos de pago.</p>
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

<div class="content-header mb-5 mt-5">
    <h1 class="heading-1 titulo_carta text-2xl font-bold mb-6 dark:text-white">Sección de Productos</h1>

    <div class="container-options mb-4">
        <a href="{{ route('personalizados') }}"><span>Arreglos personalizados</span></a>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-4 borde_filtro filtro-fijo" style="max-width: 22%;"> 
        <div class="accordion mt-3" id="productosAcordeon">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button ms-2 letra_accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Categorías
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show ms-3" aria-labelledby="headingOne" data-bs-parent="#productosAcordeon">
                    <div class="accordion-body">
                        <form action="{{ route('home') }}" method="GET" id="filter-form">
                            <div>
                                @foreach ($categoria_productos as $item)
                                    <div>
                                        <label class="ck-2">
                                            <input type="checkbox" name="categoria_producto[]" value="{{ $item->id_categoria_producto }}"
                                                id="categoria_{{ $item->id_categoria_producto }}"
                                                @if(in_array($item->id_categoria_producto, request('categoria_producto', []))) checked @endif>
                                            <svg viewBox="0 0 68 68" height="16px" width="16px">
                                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" 
                                                pathLength="575.0541381835938" class="path"></path>
                                            </svg>
                                            <span>{{ $item->nombre }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..." class="form-control mt-3">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button ms-2 letra_accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Buscar flor
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show ms-3" aria-labelledby="headingTwo" data-bs-parent="#productosAcordeon">
                    <div class="accordion-body">
                        <input type="text" class="form-control" placeholder="Buscar...">
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button ms-2 letra_accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Color
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show ms-3" aria-labelledby="headingThree" data-bs-parent="#productosAcordeon">
                    <div class="accordion-body">
                        12313212
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button ms-2 letra_accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Filtros
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show ms-3" aria-labelledby="headingThree" data-bs-parent="#productosAcordeon">
                    <div class="accordion-body">
                        Mas caro
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="row">
            @foreach ($productos as $producto)
                <div class="col-md-3 mb-4">
                    <div class="producto">
                        <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="producto-img">
                        <div class="producto-info">
                            <h5 class="producto-nombre">{{ $producto->nombre }}</h5>
                            <p class="producto-categoria">{{ $producto->categoria_producto->nombre }}</p>
                            <p class="producto-precio">${{ number_format($producto->precio, 0, ',', '.') }}</p>
                            <div class="producto-botones">
                                <a href="{{ route('add', ['id' => $producto->id]) }}" class="boton-carrito">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="{{ route('view_arreglo.arreglo_view', ['id' => $producto->id]) }}" class="boton-ver-mas">
                                    Ver más
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="gallery-wrapper">
    <h2 class="gallery-title">Galería de imagenes</h2>
    <p class="gallery-description">Explora nuestras hermosas flores y arreglos únicos.</p>
    <div class="gallery-container">
        <section class="gallery-2">
            <img src="https://i.imgur.com/xiE1vvO.jpeg" alt="galleria" class="galeria-img-1">
            <img src="https://i.imgur.com/bKFwdmR.jpeg" alt="galleria" class="galeria-img-2">
            <img src="https://i.imgur.com/Z27yfOo.jpeg" alt="galleria" class="galeria-img-3">
            <img src="https://i.imgur.com/H8CfmCq.jpeg" alt="galleria" class="galeria-img-4">
            <img src="https://i.imgur.com/r93OXMW.jpeg" alt="galleria" class="galeria-img-5">
        </section>
    </div>
</div>


<footer class="footer">
    <div class="container container-footer">
        <div class="menu-footer">
            <div class="contact-info">
                <p class="title-footer">Información de contacto</p>
                <ul>
                    <li class="letra">Direccion: cr4 #51-34</li>
                    <li class="letra">Telefono: 999-999-9999</li>
                    <li class="letra">Correo: latata@gmail.com</li>
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
                    <li><a href="#" class="letra">Acerca de nosotros</a></li>
                    <li><a href="#" class="letra">Politicas de privacidad</a></li>
                    <li><a href="#" class="letra">Terminos y condiciones</a></li>
                    <li><a href="#" class="letra">Contactanos</a></li>
                </ul>
            </div>

            <div class="my-account">
                <p class="title-footer">Mi cuenta</p>
                <ul>
                    <li><a href="{{ route('perfilUser') }}" class="letra">Mi cuenta</a></li>
                    <li><a href="{{ route('perfilUser')}}" class="letra">Historial de pedidos</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p class="text_page">Desarrollado por floristeria la tata &copy; 2024</p>
        </div>
    </div>
</footer>

<script>
    // Selecciona todos los checkboxes
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    
    checkboxes.forEach(checkbox => {
        // Añade un listener para el evento de cambio en cada checkbox
        checkbox.addEventListener('change', function() {
            // Encuentra el formulario que contiene el checkbox
            const form = this.closest('form');
            // Envía el formulario automáticamente
            form.submit();
        });
    });
</script>
@endsection