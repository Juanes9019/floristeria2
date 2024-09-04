@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">CREAR UNA NUEVO INSUMO</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <form id="formulario_crear" method="POST" action="{{ route('Admin.insumo.store') }}" novalidate >
                @csrf
                <div class="form-group">
                        <label for="id_categoria_insumo">Categoria_insumo</label>
                        <select name="id_categoria_insumo" id="id_categoria_insumo"
                            class="form-control @error('id_categoria_insumo') is-invalid  @enderror">
                            <option selected disabled>Seleccione una opción</option>
                            @foreach ($categoria_insumo as $id => $nombre)
                                <option value="{{ $id }}" {{ old('id_categoria_insumo') == $id ? 'selected' : '' }}>
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
                    <input type="number" name="cantidad_insumo" class="form-control  @error('cantidad_insumo') is-invalid  @enderror" id="cantidad_insumo" placeholder="Cantidad" value="{{ old('cantidad_insumo') }}">

                    @error('cantidad_insumo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="costo_unitario">Costo Unitario</label>
                    <input type="number" name="costo_unitario" class="form-control  @error('costo_unitario') is-invalid  @enderror" id="costo_unitario" placeholder="2222" value="{{ old('costo_unitario') }}">

                    @error('costo_unitario')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="perdida_insumo">Perdida Insumo</label>
                    <input type="number" name="perdida_insumo" class="form-control  @error('perdida_insumo') is-invalid  @enderror" id="perdida_insumo" placeholder="Perdida" value="{{ old('perdida_insumo') }}">

                    @error('perdida_insumo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <!-- <div class="form-group">
                    <label for="costo_total">Costo Total</label>
                    <input type="number" name="costo_total" class="form-control  @error('costo_total') is-invalid  @enderror" id="costo_total" placeholder="2222" value="{{ old('costo_total') }}">

                    @error('costo_total')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div> -->

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" value="agregar insumo" onclick="agregar()">
                    <a href="{{ route('Admin.insumo') }}" class="btn btn-primary ">Volver</a>
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
            Swal.fire({
                title: "!Insumo agregado!",
                text: "El insumo se agrego correctamente",
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
