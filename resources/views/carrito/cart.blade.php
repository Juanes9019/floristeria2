@extends('layouts.app')

@section('content')
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="card">
                            <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->has('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    @if (Cart::count())

                    <table class="table table-striped">
                        <thead>
                            <th class="text-center">FOTO</th>
                            <th class="text-center">NOMBRE</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">PRECIO</th>
                            <th class="text-center">IMPORTE</th>
                            <th class="text-center">ACCION</th>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                            <tr class="align-middle">
                            <td class="text-center">
                                <img src="{{ $item->options['image'] }}" alt="imagen no disponible"width="100"></td>                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="small button group">
                                            <a href="{{ route('decrementarCantidad', ['id' => $item->rowId]) }}"
                                                class="btn btn-success efecto">-</a>

                                            <button type="button" class="btn">{{ $item->qty }}</button>

                                            <a href="{{ route('incrementarCantidad', ['id' => $item->rowId]) }}"
                                                class="btn btn-success efecto">+</a>
                                    </div>
                                </td>

                                <td class="text-center">${{ number_format($item->price,  0, ',', '.') }}</td>
                                <td class="text-center">{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                                <td  class="text-center">
                                    <form action="{{ route('removeItem')}}" method="post">
                                        @csrf
                                            <input type="hidden" name="rowId" value="{{$item->rowId}}">
                                            <button type="submit"  class="btn btn-sm text-danger"><i class="fa fa-trash fa-lg hover-scale"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            <tr class="fx-bolder">
                                <td colspan="4"></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr class="fx-bolder">
                                <td colspan="4"></td>
                                <td class="text-end"><strong>Subtotal:</strong></td>
                                <td class="text-center">{{ number_format(Cart::subtotal(), 0, ',', '.') }}</td>
                            </tr>
                            <tr class="fx-bolder">
                                <td colspan="4"></td>
                                <td class="text-end"><strong>IVA:</strong></td>
                                <td class="text-center">{{ number_format(Cart::tax(), 0, ',', '.') }}</td>
                            </tr>
                            <tr class="fx-bolder">
                                <td colspan="4"></td>
                                <td class="text-end"><strong>Total:</strong></td>
                                <td class="text-center">{{ number_format(Cart::total(), 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @include('carrito.datos_envio')

                    <div class="row justify-content-center mt-5 mb-5 text-center">

                        <div class="col-sm-4">
                            <a href="{{ route('clear') }}" class="btn btn-danger efecto-botones">Vaciar carrito</a>
                        </div>

                        <div class="col-sm-4">
                            <a href="{{ route('home') }}" class="btn btn-primary efecto-botones">Seguir Comprando</a>
                        </div>


                        <div class="col-sm-4">
                            @auth
                                <a href="{{ route('confirmarCarrito') }}" class="btn btn-success efecto-botones" onclick="validarEnvio()">Comprar</a>

                            @else
                                <a href="/login" class="btn btn-danger efecto-botones">Regístrate primero</a>
                            @endauth
                        </div>

                    </div>

                    @else
                        <p class="text-center">Carrito vacio</p>
                        <div class="action-buttons1">
                            <a  href="/home">
                                <i class="fas fa-shopping-bag" style="margin-right: 5px;"></i> Seguir comprando
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
