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
    </div>

    <section class="banner">
        <div class="content-banner">
            <p>¡Descubre la belleza natural!</p>
            <h2>Variedad de flores frescas <br>arreglos únicos</h2> 
            <a href="#">Explorar ahora</a>
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
        <h1 class="heading-1">Seccion de Productos</h1>

        <div class="container-options">
            <span class="active">Todos los productos</span>
            <span>Más baratos</span>
            <span>Mejores valorados</span>
        </div>


        <div class="container" >
            <div class="row">
                @foreach ($productos as $producto)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $producto->foto }}" class="card-img-top img-fluid" alt="{{ $producto->nombre }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="card-title"><strong>Categoria:</strong> {{ $producto->categoria-> nombre }}</p>
                            <p class="card-text"><strong>Precio:</strong>${{ number_format($producto->precio, 0, ',', '.') }}</p>
                            <div class="iconos d-flex justify-content-center">
                                <span class="mr-3"><i class="far fa-eye"></i></span>
                                <span class="mx-3"><i class="fas fa-heart"></i></span>
                            </div>
                            <div class="contenedor">
                                <a href="{{ route('view_arreglo.arreglo_view', ['id' => $producto->id]) }}" class="btn btn-5">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section  class="gallery">
        <img src="https://floristeria.s3.sa-east-1.amazonaws.com/amarillas_izquieda.webp" alt="galleria" class="galeria-img-1">
        <img src="https://floristeria.s3.sa-east-1.amazonaws.com/abajo_derecha.webp" alt="galleria" class="galeria-img-2">
        <img src="https://floristeria.s3.sa-east-1.amazonaws.com/mitad_azul.webp" alt="galleria" class="galeria-img-3">
        <img src="https://floristeria.s3.sa-east-1.amazonaws.com/rosas_arriba.webp" alt="galleria" class="galeria-img-4">
        <img src="https://floristeria.s3.sa-east-1.amazonaws.com/moradas_abajo.webp" alt="galleria" class="galeria-img-5">
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
                        <li><a href="#">Mi cuenta</a></li>
                        <li><a href="#">Historial de ordenes</a></li>
                        <li><a href="#">Lista de deseos</a></li>
                        <li><a href="#">Reembolsos</a></li>
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>Desarrollado por floristeria la tata &copy; 2024</p>
            </div>
        </div>
    </footer>


<style>
.card-img-top {
    height: 200px; 
    object-fit: cover;
}

.contenedor{
    display: flex;
    height: 15vh;
    gap: 25px;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
}

.btn{
    position: relative;
    padding: 20px 50px;
    text-decoration: none;
    color: #000;
    letter-spacing: 1px;
    text-indent: 10px;
    z-index: 2;
    border-radius: 20px;
    font-size: 15px;
}


/*-----------boton 5----------*/

.btn-5{
    border: 3px solid #FFE599;
    margin:0;
    overflow: hidden;
}

.btn-5::after{
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    background-color: #FFE599;
    z-index: -2;
}

.btn-5::before{
    content: "";
    position: absolute;
    width: 100%;
    height: 250px;
    left: 0;
    bottom: -150%;
    border-radius: 30%;
    background-color: #FFF2CC;
    
    z-index: -1;
}

.btn-5:hover::before{
    animation: btn-5 2s linear both;
}


@keyframes btn-5 {
    0%{
        transform: rotate(0deg);
    }
    100%{
        bottom: 100px;
        transform: rotate(360deg);
        
    }
}
</style>
@endsection
