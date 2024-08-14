@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">EDITAR Producto</h2>
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_editar" method="POST" action="{{ route('Admin.producto.update', $producto->id) }}" novalidate>
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="id_categoria">Categoría Producto</label>
                <select id="id_categoria" name="id_categoria" class="form-control @error('id_categoria') is-invalid  @enderror">
                    <option selected disabled>Seleccione una Categoría</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id}}" @if($categoria->id == $producto->id_categoria) {{'selected'}} @endif>
                        {{ $categoria->nombre }}
                    </option>
                    @endforeach
                </select>

                @error('id_categoria')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" placeholder="Arreglo #2"
                    value="{{ $producto->nombre }}">

                @error('nombre')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre">Descripcion</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control 
                     @error('descripcion') is-invalid  @enderror" placeholder="2222" value="{{$producto->descripcion }}">

                @error('nombre')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control  
                    @error('cantidad') is-invalid  @enderror" placeholder="2222" value="{{$producto->cantidad}}">

                @error('cantidad')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" class="form-control  @error('precio') is-invalid  @enderror"
                    placeholder="2222" value="{{$producto->precio }}">

                @error('precio')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="text" id="foto" name="foto" class="form-control  @error('foto') is-invalid  @enderror"
                    placeholder="www.imgur.com" value="{{ $producto->foto }}">

                @error('foto')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="1" {{ $producto->estado == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $producto->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <input type="button" class="btn btn-primary" value="Editar insumo" onclick="editar()">
                <a href="{{ route('Admin.productos') }}" class="btn btn-danger ">Volver</a>
            </div>
        </form>
    </div>
</div>
<script>
    function editar() {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas editar esta categoria?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Editar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!categoria Editada!",
                    text: "La categoria se edito correctamente",
                    icon: "success"
                });

                // Prevent the form from submitting automatically
                event.preventDefault();

                // Manually submit the form
                document.getElementById('formulario_editar').submit();
            }
        });
    }
</script>

@stop