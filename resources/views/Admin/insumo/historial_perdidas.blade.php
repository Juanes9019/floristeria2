@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <br><center><h3>Historial de Pérdidas</h3></center><br>
    <div class="card card-body">

        @if ($errors->has('status'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('status') }}
            </div>
        @endif

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '{{ session('success') }}',
                    position: 'top-end',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif

        <div class="form-group">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Insumo</th>
                    <th>Cantidad Pérdida</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historialPerdidas as $perdida)
                <tr>
                    <td>{{ $perdida->fecha_perdida }}</td>
                    <td>{{ $perdida->insumo->nombre }}{{ $perdida->insumo->color ? ' - ' . $perdida->insumo->color : '' }}</td>
                    <td>{{ $perdida->cantidad_perdida }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <a href="{{ route('Admin.insumo.perdida') }}" class="btn btn-primary">{{ __('Registrar') }}</a>
        <a href="{{ route('Admin.insumo') }}" class="btn btn-danger">Volver</a>
        </div>
    </div>
</div>
@endsection
