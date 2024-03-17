@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1cJkNaxOSDg+Q+Fi19lDDHYQPhNraZxVN2iPQ7XxI2nMWe2kSfuWc2kZ4XK6ix9DtkJze4UJgLwYzLqSwmWTlw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Información del arreglo floral') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 order-md-1">
                            <img src="{{ asset('storage/' . $productos->foto) }}" alt="{{ $productos->nombre }}" class="img-fluid">
                        </div>

                        <div class="col-md-6 order-md-2">
                            <h2>{{ $productos->nombre }}</h2>
                            <div class="chips">
                                <p><strong>Categoria:</strong> {{ $productos->categoria->nombre }}</p>
                                <p><strong>Descripcion:</strong> {{ $productos->descripcion }}</p>
                                <p><strong>Cantidad disponible:</strong> {{ $productos->cantidad }}</p>

                                <!-- <div class="mb-3">
                                    <label for="cantidad" class="form-label">Especifique la cantidad de arreglos florales:</label>
                                    <input type="number" class="form-control" id="cantidad" placeholder="cantidad" aria-describedby="basic-addon1">
                                </div> -->

                                <section></section>
                                <div class="action-buttons">
                                    <a> Precio: {{ number_format($productos->precio, 0) }} </a>
                                </div>
                            </div>       
                        </div>
                    </div>
                    <div>
                        <div class="action-buttons1">
                            <a  href="/home">
                                <i class="fas fa-shopping-bag" style="margin-right: 5px;"></i> Seguir comprando
                            </a>

                            <a  href="{{ route('home/carrito') }}" onclick="validacion()">
                                <i class="fas fa-shopping-cart" style="margin-right: 5px;"></i> Agregar al carrito
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validacion(){
        Swal.fire({
            title: "Se agrego al carrito correctamente",
            icon: "success"
        });
    }
</script>


@endsection
