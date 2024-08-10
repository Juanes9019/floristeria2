@extends('adminlte::page')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <b>Control de insumos</b>
                            </span>

                            <div class="float-right">
                                <a href="{{ route('Admin.insumo.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Registrar insumos') }}
                                </a>
                            </div>
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
                                    <tr>
                                        <th scope="col" class="text-center">Id insumo</th>
                                        <th scope="col" class="text-center">Id categoria insumo</th>
                                        <th scope="col" class="text-center">Cantidad insumo</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Perdida insumo</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($insumos as $insumo)
                                        <tr>
                                            <td class="text-center">{{ ++$i }}</td>
                                            <td class="text-center">{{ $insumo->id_categoria_insumo }}</td>
                                            <td class="text-center">{{ $insumo->cantidad_insumo }}</td>
                                            <td class="text-center">{{ $insumo->precio }}</td>
                                            <td class="text-center">{{ $insumo->perdida_insumo }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('Admin.insumo.destroy', ['id' => $insumo->id]) }}" method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('Admin.insumo.edit', ['id' => $insumo->id]) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
