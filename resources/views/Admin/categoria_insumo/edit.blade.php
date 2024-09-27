@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">EDITAR CATEGORIA INSUMO</h2>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
            <form id="formulario_editar" method="POST" action="{{ route('Admin.categoria_insumo.update', ['id' => $categoria_insumo->id]) }}" novalidate>
                @method('PUT')
                @csrf            

                <div class="form-group">
                    <label for="nombre">Nombre de la categoria</label>
                    <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Hombre..." value="{{ old('nombre', $categoria_insumo->nombre) }}">
                    @error('nombre')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
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
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="1" {{ $categoria_insumo->estado == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $categoria_insumo->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" value="Editar categoria insumo" onclick="editar()">
                    <a href="{{ route('Admin.categoria_insumo') }}" class="btn btn-primary ">Volver</a>
                </div>
            </form>
        </div>
    </div>
    <script>
function editar() {
    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas editar esta categoria insumo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Editar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "!categoria insumo Editada!",
                text: "La categoria insumo se edito correctamente",
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
