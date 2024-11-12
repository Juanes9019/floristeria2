@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center my-5">
    <div class="modal-style-card shadow-lg rounded p-4 bg-white" style="max-width: 800px; width: 100%;">
        <div class="modal-header bg-primary text-white rounded-top p-3">
            <h3 class="modal-title mb-0">{{ $producto->nombre }}</h3>
        </div>
        <div class="modal-body p-4">
            <div class="product-details row">
                <!-- Imagen del producto -->
                <div class="col-md-5 text-center mb-4">
                    <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto;">
                </div>

                <!-- Detalles del producto -->
                <div class="col-md-7">
                    <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                    <p><strong>Categoría:</strong> {{ $producto->categoria_producto->nombre }}</p>
                    <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2, ',', '.') }}</p>
                    <p><strong>Estado:</strong> 
                        <span class="badge badge-{{ $producto->estado == 1 ? 'success' : 'danger' }}">
                            {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Insumos utilizados -->
            <h5 class="mt-4">Insumos utilizados</h5>
            @if($producto->insumos->isEmpty())
                <p>No hay insumos asociados a este producto.</p>
            @else
                <ul class="list-group">
                    @foreach($producto->insumos as $insumo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $insumo->nombre }} {{ $insumo->color ? ' - ' . $insumo->color : '' }}
                            <span class="badge badge-secondary">Cantidad: {{ $insumo->pivot->cantidad_usada }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="modal-footer mt-4">
            <a href="{{ route('Admin.productos') }}" class="btn btn-danger">Volver a la lista de productos</a>
        </div>
    </div>
</div>


@endsection
