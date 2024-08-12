@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">CREAR UN NUEVO PRODUCTO</h2>


<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.producto.store') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="id_categoria">Categoría Producto</label>
                <select id="id_categoria" name="id_categoria"
                    class="form-control @error('id_categoria') is-invalid  @enderror">
                    <option selected disabled>Seleccione una opción</option>
                    @foreach($categoria as $id => $nombre)
                    <option value="{{ $id }}" {{ old('id_categoria') == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                    @endforeach
                </select>

                @error('categoria_producto')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" placeholder="Arreglo #1" value="{{ old('nombre', $producto->nombre) }}">

                @error('nombre')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre">Descripcion</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control 
                     @error('descripcion') is-invalid  @enderror" placeholder="Arreglo Para ocaciones Especiales como cumpleaños" value="{{ old('descripcion', $producto->descripcion) }}">

                @error('nombre')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
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
                <input type="number" id="precio" name="precio" class="form-control  @error('precio') is-invalid  @enderror"
                    placeholder="200.000" value="{{ old('precio', $producto->precio) }}">

                @error('precio')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="text" id="foto" name="foto" class="form-control  @error('foto') is-invalid  @enderror"
                    placeholder="www.imgurl.com" value="{{ old('foto', $producto->foto) }}">

                @error('foto')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                </select>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-success" value="agregar insumo" onclick="agregar()">Agregar Producto</button>
                <a href="{{ route('Admin.productos') }}" class="btn btn-primary ">Volver</a>
            </div>


        </form>
    </div>
</div>
<script>
    function agregar() {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas agregar esta categoria?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, agregar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!categoria agregada!",
                    text: "La categoria se agrego correctamente",
                    icon: "success"
                });

                // Prevent the form from submitting automatically
                event.preventDefault();

                // Manually submit the form
                document.getElementById('formulario_crear').submit();
            }
        });
    }
</script>

@stop