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
                                    <th scope="col" class="text-center">Estado</th>
                                    <th scope="col" class="text-center">Acciones</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="text-center">{{ $categoria->nombre }}</td>
                                    <td class="text-center">{{ $categoria->estado == 1 ? 'Activo' : 'Inactivo' }}</td>

                                    <td class="text-center">
                                        <form id="form_eliminar_{{ $categoria->id }}" action="{{ route('Admin.categoria.destroy', ['id' => $categoria->id]) }}" method="POST">
                                            <a class="btn btn-sm btn-success"
                                                href="{{ route('Admin.categoria.edit', ['id' => $categoria->id]) }}"><i
                                                    class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>

                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{$categoria->id}}')">
                                                <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                            </button>
                                            <a class="btn btn-sm {{ $categoria->estado == 1 ? 'btn-success' : 'btn-danger' }}" href="{{ route('Admin.categoria.status', $categoria->id) }}">
                                                {{ $categoria->estado == 1 ? 'Activo' : 'Inactivo' }}
                                                <i class="fa fa-fw fa-sync"></i>
                                            </a>
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

<script>
    function eliminar(categoriaId) {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas Eliminar este proveedor?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Categoría Eliminada!",
                    text: "La categoria se Eliminó Correctamente",
                    icon: "success"
                }).then(() => {
                    document.getElementById('form_eliminar_' + categoriaId).submit();
                });
            }
        });
    }
</script>


@stop