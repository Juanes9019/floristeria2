@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">Crear categoría</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.categoria_insumo.store') }}" novalidate >
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre </label>
                    <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Ocasiones especiales" value="{{ old('nombre') }}">

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                        <label for="id_proveedor">Proveedor</label>
                        <select id="id_proveedor" name="id_proveedor" class="form-control @error('id_proveedor') is-invalid  @enderror">
                            <option selected disabled>Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id}}" @if($proveedor->id == $categoria_insumo->id_proveedor) {{'selected'}} @endif>
                                {{ $proveedor->nombre }}
                            </option>
                            @endforeach
                        </select>

                        @error('id_proveedor')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" value="Agregar" onclick="agregar()">
                    <a href="{{ route('Admin.categoria_insumo') }}" class="btn btn-primary ">Volver</a>
                </div>


            </form>
        </div>
    </div> 
<script>
function agregar() {
    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas agregar esta categoria insumo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, agregar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "!categoria insumo agregada!",
                text: "La categoria insumo se agrego correctamente",
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
