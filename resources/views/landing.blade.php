@extends('layouts.app')

@section('content')

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

<section class="banner2">
    <div class="content-banner2">
        <h1 class="banner-title">Crea momentos especiales con nosotros</h1>
        <div class="buttons-container">
            <a href="{{ route('home') }}" class="btn-banner btn-outline">Productos</a>
            <a href="{{ route('personalizados') }}" class="btn-banner btn-outline">Arreglos Personalizados</a>
        </div>
    </div>
</section>


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