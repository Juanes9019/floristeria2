@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $producto->nombre }}</h1>
    
    <div class="product-details">
        <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
        <p><strong>Categoría:</strong> {{ $producto->categoria_producto->nombre }}</p>
        <p><strong>Precio:</strong> ${{ $producto->precio }}</p>
        <p><strong>Estado:</strong> {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}</p>
        <p><strong>Foto:</strong></p>
        <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" style="max-width: 300px;">

        <h3>Insumos utilizados</h3>
        @if($producto->insumos->isEmpty())
            <p>No hay insumos asociados a este producto.</p>
        @else
            <ul>
                @foreach($producto->insumos as $insumo)
                    <li>{{ $insumo->nombre }} (Cantidad utilizada: {{ $insumo->pivot->cantidad_usada }})</li>
                @endforeach
            </ul>
        @endif
    </div>

    <a href="{{ route('Admin.productos') }}" class="btn btn-primary">Volver a la lista de productos</a>
</div>

@vite('resources/css/app.css')
@endsection
