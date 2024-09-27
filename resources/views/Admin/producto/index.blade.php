@extends('adminlte::page')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
                                    <th scope="col" class="text-center">Nombre</th>
                                    <th scope="col" class="text-center">Categoria Producto</th>
                                    <th scope="col" class="text-center">Descripción</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col" class="text-center">Precio</th>
                                    <th scope="col" class="text-center">Foto</th>
                                    <th scope="col" class="text-center">Estado</th>
                                    <th scope="col" class="text-center">Acciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="text-center">{{ $producto->nombre }}</td>
                                    <td class="text-center">{{$producto->categoria_producto->nombre}}</td>
                                    <td class="text-center">{{$producto->descripcion_limitada}}</td>
                                    <td class="text-center">{{ $producto->cantidad}}</td>
                                    <td class="text-center">{{ number_format($producto->precio, 0, ',', '.') }}</td>
                                    <td class="text-center justify-content-center">
                                        <img src="{{ $producto->foto }}" alt="Foto" class="thumbnail" width="150" height="150" loading="lazy">
                                    </td>
                                    <td class="text-center">{{ $producto->estado == 1 ? 'Activo': 'Inactivo' }} </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-warning" href="{{ route('Admin.producto.edit', ['id' => $producto->id]) }}">
                                            <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                    <td>
                                        <form id="form_eliminar_{{ $producto->id }}" action="{{ route('Admin.producto.destroy', ['id' => $producto->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{$producto->id}}','{{$producto->estado}}')">
                                                <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm {{ $producto->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                            href="{{ route('Admin.producto.status', $producto->id) }}">
                                            {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                                            <i class="fas fa-toggle-{{ $producto->estado == 1 ? 'on' : 'off' }}"></i>
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

<script>
    function eliminar(productoId, estadoProducto) {
    if (estadoProducto == 1) { 
        Swal.fire({
            title: "¡Error!",
            text: "No se puede eliminar un Producto activo.",
            icon: "error",
            confirmButtonText: "OK"
        });
    } else {
        // Si está inactiva, proceder con la eliminación
        Swal.fire({
            title: "¡Estás seguro!",
            text: "¿Deseas eliminar esta producto?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Categoría Eliminada!",
                    text: "El producto se eliminó correctamente.",
                    icon: "success"
                }).then(() => {
                    document.getElementById('form_eliminar_' + productoId).submit();
                });
            }
        });
    }
}
</script>

@stop