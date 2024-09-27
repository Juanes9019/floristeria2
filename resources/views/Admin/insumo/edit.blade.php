@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">EDITAR INSUMO</h2>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
            <form id="formulario_editar" method="POST" action="{{ route('Admin.insumo.update', $insumos->id) }}" novalidate>
                @method('PUT')
                @csrf            
                <div class="form-group">
                        <label for="id_categoria_insumo">Categoria insumo</label>
                        <select id="id_categoria_insumo" name="id_categoria_insumo" class="form-control @error('id_categoria_insumo') is-invalid  @enderror">
                            <option selected disabled>Seleccione una Categoría</option>
                            @foreach($categoria_insumos as $categoria)
                            <option value="{{ $categoria->id}}" @if($categoria->id == $insumos->id_categoria_insumo) {{'selected'}} @endif>
                                {{ $categoria->nombre }}
                            </option>
                            @endforeach
                        </select>

                        @error('id_categoria_insumo')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Nombre..." value="{{ old('nombre', $insumos->nombre) }}">

                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="costo_unitario">Costo Unitario</label>
                    <input type="number" name="costo_unitario" class="form-control  @error('costo_unitario') is-invalid  @enderror" id="costo_unitario" placeholder="$$$" value="{{ old('costo_unitario', $insumos->costo_unitario) }}">

                    @error('costo_unitario')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="1" {{ $insumos->estado == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $insumos->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" value="Editar insumo" onclick="editar()">
                    <a href="{{ route('Admin.insumo') }}" class="btn btn-primary ">Volver</a>
                </div>
            </form>
        </div>
    </div>
    <script>
function editar() {
    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas editar este insumo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Editar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "!insumo Editado!",
                text: "El insumo se edito correctamente",
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
