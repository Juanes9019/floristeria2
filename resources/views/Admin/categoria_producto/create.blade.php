@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">CREAR UNA NUEVA CATEGORIA</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.categoria_producto.store') }}" novalidate >
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre de la categoria</label>
                    <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Ocasiones especiales" value="{{ old('nombre') }}">

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button  class="btn btn-success" value="agregar categoria" onclick="agregar()">
                        Agregar Categoría
                    </button>
                    <a href="{{ route('Admin.categorias_productos') }}" class="btn btn-danger ">Volver</a>
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
            event.preventDefault();
            document.getElementById('formulario_crear').submit();
        }
    });
}
</script>

@stop
