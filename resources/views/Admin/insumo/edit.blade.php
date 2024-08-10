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
                        <label for="id_categoria_insumo">Sub_categoria</label>
                        <select name="id_categoria_insumo" id="id_categoria_insumo"
                            class="form-control @error('id_categoria_insumo') is-invalid  @enderror">
                            <option selected disabled>Seleccione una opción</option>
                            @foreach ($sub_categoria as $id => $nombre)
                                <option value="{{ $id }}" {{ old('id_sub_categoria') == $id ? 'selected' : '' }}>
                                    {{ $nombre }} </option>
                            @endforeach
                        </select>

                        @error('id_categoria_insumo')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="cantidad_insumo">Cantidad</label>
                    <input type="number" name="cantidad_insumo" class="form-control  @error('cantidad_insumo') is-invalid  @enderror" id="cantidad_insumo" placeholder="2222" value="{{ old('cantidad_insumo', $insumos->cantidad_insumos) }}">

                    @error('cantidad_insumos')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" class="form-control  @error('precio') is-invalid  @enderror" id="precio" placeholder="2222" value="{{ old('precio', $insumos->precio) }}">

                    @error('precio')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="perdida_insumo">Perdida Insumo</label>
                    <input type="number" name="perdida_insumo" class="form-control  @error('perdida_insumo') is-invalid  @enderror" id="perdida_insumo" placeholder="2222" value="{{ old('perdida_insumo', $insumos->perdida_insumo) }}">

                    @error('perdida_insumo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
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
