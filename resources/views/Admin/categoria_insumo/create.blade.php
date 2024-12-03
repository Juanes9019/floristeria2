@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<br><h2 class="text-center mb-5">Crear categoría</h2>
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.categoria_insumo.store') }}" novalidate >
            @csrf
            <div class="card card-body">
                <div class="form-group">
                    <label for="nombre">Nombre <strong style="color: red;">*</strong></label>
                    <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Ocasiones especiales" value="{{ old('nombre') }}">

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" value="Agregar" onclick="agregar()">
                    <a href="{{ route('Admin.categoria_insumo') }}" class="btn btn-danger ">Cancelar</a>
                </div>
            </div>      
        </form>
    </div>
</div> 
<script>
function agregar() {
    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas agregar este insumo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, agregar"
    }).then((result) => {
        if (result.isConfirmed) {
            event.preventDefault();

            document.getElementById('formulario_crear').submit();
        }
    });
}
</script>

@stop
