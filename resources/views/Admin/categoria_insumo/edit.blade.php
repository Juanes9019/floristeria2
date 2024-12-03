@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">Editar categoría</h2>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
            <form id="formulario_editar" method="POST" action="{{ route('Admin.categoria_insumo.update', ['id' => $categoria_insumo->id]) }}" novalidate>
                @method('PUT')
                @csrf            
                <div class="card card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre">Nombre <strong style="color: red;">*</strong></label>
                                <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Hombre..." value="{{ old('nombre', $categoria_insumo->nombre) }}">
                                @error('nombre')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>    
                            <div class="col-md-6">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado" class="form-control">
                                    <option value="1" {{ $categoria_insumo->estado == '1' ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ $categoria_insumo->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <input type="button" class="btn btn-primary" value="Editar" onclick="editar()">
                        <a href="{{ route('Admin.categoria_insumo') }}" class="btn btn-danger ">Cancelar</a>
                    </div>
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

            event.preventDefault();

            document.getElementById('formulario_editar').submit();
        }
    });
}
</script>

@stop
