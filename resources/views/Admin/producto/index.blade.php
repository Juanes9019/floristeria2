@extends('adminlte::page')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <b>Control de Productos</b>
                        </span>

                        <div class="float-right">
                            <a href="{{ route('Admin.producto.create') }}" class="btn btn-primary btn-sm float-right"
                                data-placement="left">
                                {{ __('Registrar productos') }}
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
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Categoria Producto</th>
                                    <th scope="col" class="text-center">Nombre</th>
                                    <th scope="col" class="text-center">Descripcion</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col" class="text-center">Precio</th>
                                    <th scope="col" class="text-center">Foto</th>
                                    <th scope="col" class="text-center">Estado</th>
                                    <th scope="col" class="text-center" colspan="3">Acciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="text-center">{{$producto->categoria_producto->nombre}}</td>
                                    <td class="text-center">{{ $producto->nombre }}</td>
                                    <td class="text-center">OE</td>
                                    <td class="text-center">{{ $producto->cantidad}}</td>
                                    <td class="text-center">{{ number_format($producto->precio, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $producto->foto }}</td>
                                    <td class="text-center">{{ $producto->estado == 1 ? 'Activo': 'Inactivo' }} </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-warning" href="{{ route('Admin.producto.edit', ['id' => $producto->id]) }}">
                                            <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                    <td>
                                        <form action="{{ route('Admin.producto.destroy', ['id' => $producto->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm {{ $producto->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                            href="{{ route('Admin.producto.status', $producto->id) }}">
                                            {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                                            <i class="fa fa-fw fa-sync"></i>
                                        </a>
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