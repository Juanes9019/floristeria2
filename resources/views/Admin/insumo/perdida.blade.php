@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h2>Registrar Pérdida de Insumo</h2><br>

        <form action="{{ route('admin.insumo.storePerdida') }}" method="POST">
        @csrf
            <div class="form-group">
                <label for="insumo">Seleccionar Insumo</label>
                <select name="insumo_id" id="insumo" class="form-control" required>
                    @foreach($insumos as $insumo)
                        <option value="{{ $insumo->id }}">{{ $insumo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cantidad_perdida">Cantidad:</label><br>
                <input type="number" name="cantidad_perdida" id="cantidad_perdida" placeholder="000" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger">Registrar</button>
            <a href="{{ route('Admin.insumo') }}" class="btn btn-primary ">Cancelar</a>
            </form>
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

