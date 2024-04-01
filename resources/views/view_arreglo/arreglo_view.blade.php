@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('view_arreglo.partials.msg')
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
                <div class="container" >
                    <div class="row align-items-center">
                        <div class="col-md-6 order-md-1">
                            <img src="{{ $productos->foto }}" class="card-img-top img-fluid" alt="{{ $productos->nombre }}">
                        </div>

                        <div class="col-md-6 order-md-2">
                            <h2>{{ $productos->nombre }}</h2>
                            <div class="chips">
                                <p><strong>Categoria:</strong> {{ $productos->categoria->nombre }}</p>
                                <p><strong>Descripcion:</strong> {{ $productos->descripcion }}</p>

                                <section></section>
                                <div class="action-buttons">
                                    <a> Precio: {{ number_format($productos->precio, 0) }} </a>
                                </div>
                            </div>       
                        </div>
                    </div>
                    <form action="{{ route('add')}}" methos=post>
                        @csrf

                        <div class="action-buttons1">
                            <input type="hidden" name="id" value="{{$productos->id}}">

                            <a  href="/home"> Seguir comprando</a>
                            <input type="submit" name="btn" id="btn"class="btn btn-dark w-100" value="Agregar al carrito">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card{
        margin-top: 3rem;
    }
</style>

@endsection
