@extends('adminlte::page')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <b>Control de categorias</b>
                            </span>

                            <div class="float-right">
                                <a href="{{ route('Admin.categoria.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Registrar categorias') }}
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
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Nombre de la Categoria</th>
                                        <th scope="col" class="text-center">Acciones</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categorias as $categoria)
                                        <tr>
                                            <td class="text-center">{{ ++$i }}</td>
                                            <td class="text-center">{{ $categoria->nombre }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('Admin.categoria.destroy', ['id' => $categoria->id]) }}" method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('Admin.categoria.edit', ['id' => $categoria->id]) }}"><i
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
