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
    <!-- Sidebar de filtros -->
    <div class="col-md-4 borde_filtro filtro-fijo" style="max-width: 22%;">
        <div class="accordion mt-3" id="productosAcordeon">
            <!-- Categorías -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button ms-2 letra_accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Filtros
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show ms-3" aria-labelledby="headingOne" data-bs-parent="#productosAcordeon">
                    <div class="accordion-body">
                        <form action="{{ route('home') }}" method="GET" id="filter-form">
                            <div>
                                <label>Buscar flor:</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..." class="form-control mt-3" id="search-input">
                            </div>
                            <br>
                            <div>
                                <label>Categorias:</label>
                                @foreach ($categoria_productos as $item)
                                    <div>
                                        <label class="ck-2">
                                            <input type="checkbox" name="categoria_producto[]" value="{{ $item->id_categoria_producto }}"
                                                id="categoria_{{ $item->id_categoria_producto }}"
                                                @if(in_array($item->id_categoria_producto, request('categoria_producto', []))) checked @endif>
                                            <svg viewBox="0 0 68 68" height="16px" width="16px">
                                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path"></path>
                                            </svg>
                                            <span>{{ $item->nombre }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Ordenar por -->
                            <div class="form-group mt-4">
                                <label for="order_by">Ordenar por:</label>
                                <select name="order_by" id="order_by" class="form-control mt-2">
                                    <option value="">Seleccionar</option>
                                    <option value="mas_bajo" {{ request('order_by') == 'mas_bajo' ? 'selected' : '' }}>Precio más barato</option>
                                    <option value="mas_caro" {{ request('order_by') == 'mas_caro' ? 'selected' : '' }}>Precio más caro</option>
                                    <option value="nuevos" {{ request('order_by') == 'nuevos' ? 'selected' : '' }}>Areglos nuevos</option>
                                    <option value="antiguos" {{ request('order_by') == 'antiguos' ? 'selected' : '' }}>Areglos antiguos</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos -->
    <div class="col-md-9">
        <div class="row">
            @forelse ($productos as $producto)
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
            @empty
                <p>No se encontraron productos.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    // Evento para checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            document.getElementById('filter-form').submit();
        });
    });

    // Evento para el campo de búsqueda
    document.getElementById('search-input').addEventListener('input', function () {
        clearTimeout(this.delay);
        this.delay = setTimeout(() => {
            document.getElementById('filter-form').submit();
        }, 500);
    });

    // Evento para ordenar
    document.getElementById('order_by').addEventListener('change', () => {
        document.getElementById('filter-form').submit();
    });
</script>


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




<style>
    .color-box {
    width: 35px;
    height: 35px;
    margin: 5px;
    border: 1px solid Black;
    cursor: pointer;
    border-radius: 5px; /* opcional para bordes redondeados */
}
.color-box:hover {
    border-color: #000;
}

</style>

@endsection