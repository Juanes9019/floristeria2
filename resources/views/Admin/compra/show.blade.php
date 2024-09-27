@extends('adminlte::page')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                <b>Detalles de compra #{{ $compra->id }}</b>
                            </span>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>Categoría</th>
                                    <th>Insumo</th>
                                    <th>Cantidad</th>
                                    <th>Costo Unitario</th>
                                    <th>SubTotal</th>
                            </thead>
                                <tbody>
                                @foreach($compra->detalles as $detalle)
                                    <tr>
                                        <td>{{ $detalle->categoria_insumo->nombre }}</td>
                                        <td>{{ $detalle->insumo->nombre }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>{{ $detalle->costo_unitario }}</td>
                                        <td>{{ $detalle->subtotal }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <a href="{{ route('Admin.compra.index') }}" class="btn btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .centrar-formulario {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

@stop