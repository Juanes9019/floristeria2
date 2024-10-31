@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h2 class="text-center mb-5">CREAR UN NUEVO PRODUCTO</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-10">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.producto.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Categoría Producto -->

            <div class="form-group">
                <label for="id_categoria_producto">Categoría Producto</label>
                <select id="id_categoria_producto" name="id_categoria_producto" class="form-control @error('id_categoria_producto') is-invalid @enderror">
                    <option disabled {{ old('id_categoria_producto', isset($producto) ? $producto->id_categoria_producto : '') == '' ? 'selected' : '' }}>
                        Seleccione una Categoría
                    </option>
                    @foreach($categorias_productos as $categoria_producto)
                    <option value="{{ $categoria_producto->id_categoria_producto }}"
                        {{ old('id_categoria_producto', isset($producto) ? $producto->id_categoria_producto : '') == $categoria_producto->id_categoria_producto ? 'selected' : '' }}>
                        {{ $categoria_producto->nombre }}
                    </option>
                    @endforeach
                </select>
                @error('id_categoria_producto')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Nombre -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Arreglo #1" value="{{ old('nombre', $producto->nombre) }}">
                @error('nombre')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Arreglo para ocasiones especiales como cumpleaños">{{ old('descripcion', $producto->descripcion) }}</textarea>
                @error('descripcion')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control  
                    @error('cantidad') is-invalid  @enderror" placeholder="1" value="{{ old('cantidad', $producto->cantidad) }}">

                @error('cantidad')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" placeholder="200.000" value="{{ old('precio', $producto->precio) }}">
                </div>
                @error('precio')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Foto -->
            <div class="form-group">
                <label for="foto">Foto</label>
                @if(isset($producto) && $producto->foto)
                <div class="mb-2">
                    <img src="{{ $producto->foto }}" alt="Imagen del producto" class="img-thumbnail" style="max-width: 200px;">
                </div>
                @endif
                <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror">
                @error('foto')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Estado -->
            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="form-group">
                <button type="button" class="btn btn-primary" value="agregar producto" onclick="agregar(event)">Agregar Producto</button>
                <a href="{{ route('Admin.productos') }}" class="btn btn-primary">Cancelar</a>
            </div>

            <!-- Mostrar los insumos seleccionados -->
            <div class="card mt-4">
                <div class="card-header">Insumos seleccionados:</div>
                <div class="card-body">
                    @if($insumos)
                    <ul class="list-group">
                        @foreach($insumos as $insumo)
                        <li class="list-group-item">
                            <strong>{{ $insumo['nombre'] }}</strong> - Cantidad: {{ $insumo['cantidad'] }}
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p>No hay insumos seleccionados</p>
                    @endif
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    function agregar(event) {
        event.preventDefault();

        Swal.fire({
            title: "¡Estás seguro!",
            text: "¿Deseas agregar este producto?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, agregar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Producto agregado!",
                    text: "El producto se agregó correctamente",
                    icon: "success"
                }).then(() => {
                    document.getElementById('formulario_crear').submit();
                });
            }
        });
    }
</script>

@stop